<?php

namespace App\Helpers;

use App\Models\Backup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class BackupHelper
{
    /**
     * Create a full backup (database + files)
     */
    public static function createFullBackup()
    {
        $backupId = date('Y-m-d_H-i-s') . '_' . Str::random(6);
        $backupDir = storage_path('app/backups/' . $backupId);
        
        // Create backup directory
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        // 1. Database Backup
        self::backupDatabase($backupDir);
        
        // 2. Files Backup (public/storage)
        self::backupFiles($backupDir);
        
        // 3. Create zip file
        $zipFile = self::createZip($backupDir, $backupId);
        
        // 4. Cleanup temp directory
        File::deleteDirectory($backupDir);
        
        // 5. Save backup info
        $backupInfo = Backup::create([
            'name' => 'backup_' . $backupId . '.zip',
            'path' => 'backups/backup_' . $backupId . '.zip',
            'size' => File::size($zipFile),
        ]);
        
        return $backupInfo;
    }

    /**
     * Backup database using PHP
     */
    private static function backupDatabase($backupDir)
    {
        $sqlFile = $backupDir . '/database.sql';
        $tables = DB::select('SHOW TABLES');
        
        $content = "-- EktaMart Database Backup\n";
        $content .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $content .= "-- Tables: " . count($tables) . "\n\n";
        
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            
            // Drop table
            $content .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            
            // Create table
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $createSql = $createTable[0]->{'Create Table'};
            $content .= $createSql . ";\n\n";
            
            // Insert data (limit to 1000 rows per table for performance)
            $rows = DB::table($tableName)->limit(1000)->get();
            if ($rows->count() > 0) {
                foreach ($rows as $row) {
                    $values = array_map(function($value) {
                        if ($value === null) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, (array)$row);
                    
                    $columns = implode('`, `', array_keys((array)$row));
                    $valuesList = implode(', ', $values);
                    
                    $content .= "INSERT INTO `{$tableName}` (`{$columns}`) VALUES ({$valuesList});\n";
                }
                $content .= "\n";
            }
        }
        
        File::put($sqlFile, $content);
        return $sqlFile;
    }

    /**
     * Backup public files
     */
    private static function backupFiles($backupDir)
    {
        $filesDir = $backupDir . '/files';
        File::makeDirectory($filesDir, 0755, true);
        
        // Copy public/storage files
        $storagePath = storage_path('app/public');
        if (File::exists($storagePath)) {
            File::copyDirectory($storagePath, $filesDir . '/storage');
        }
        
        // Copy .env file
        $envPath = base_path('.env');
        if (File::exists($envPath)) {
            File::copy($envPath, $filesDir . '/.env');
        }
        
        return $filesDir;
    }

    /**
     * Create zip file
     */
    private static function createZip($backupDir, $backupId)
    {
        $zipFile = storage_path('app/backups/backup_' . $backupId . '.zip');
        
        if (!class_exists('ZipArchive')) {
            // Fallback: Just copy directory
            File::copyDirectory($backupDir, storage_path('app/backups/' . $backupId));
            return $zipFile;
        }
        
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = File::allFiles($backupDir);
            foreach ($files as $file) {
                $zip->addFile($file->getRealPath(), $file->getRelativePathname());
            }
            $zip->close();
        }
        
        return $zipFile;
    }

    /**
     * Get all backups
     */
    public static function getBackups()
    {
        $backups = Backup::orderBy('created_at', 'desc')->get();
        
        if ($backups->isEmpty()) {
            // Check filesystem for backups
            $backupFiles = Storage::disk('local')->files('backups');
            $backupList = [];
            
            foreach ($backupFiles as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                    $size = Storage::disk('local')->size($file);
                    $backupList[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => self::formatSize($size),
                        'date' => date('Y-m-d H:i:s', Storage::disk('local')->lastModified($file)),
                    ];
                }
            }
            
            return $backupList;
        }
        
        return $backups->map(function($backup) {
            return [
                'id' => $backup->id,
                'name' => $backup->name,
                'path' => $backup->path,
                'size' => self::formatSize($backup->size),
                'date' => $backup->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    /**
     * Download backup
     */
    public static function downloadBackup($fileName)
    {
        $filePath = 'backups/' . $fileName;
        
        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->download($filePath, $fileName);
        }
        
        return null;
    }

    /**
     * Delete backup
     */
    public static function deleteBackup($fileName)
    {
        $filePath = 'backups/' . $fileName;
        
        // Delete from database
        $backup = Backup::where('name', $fileName)->first();
        if ($backup) {
            $backup->delete();
        }
        
        // Delete file
        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            return true;
        }
        
        return false;
    }

    /**
     * Format file size
     */
    private static function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}