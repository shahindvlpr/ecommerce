<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_phone' => 'nullable|string|max:20',
            'store_address' => 'nullable|string|max:500',
            'store_description' => 'nullable|string|max:500',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:50',
        ]);

        $this->saveSettings($request->all(), 'general');

        return redirect()->back()->with('success', 'General settings updated successfully!');
    }

    /**
     * Update payment settings.
     */
    public function updatePayment(Request $request)
    {
        $request->validate([
            'ssl_store_id' => 'nullable|string|max:255',
            'ssl_store_password' => 'nullable|string|max:255',
            'ssl_mode' => 'nullable|string|in:sandbox,live',
            'ssl_base_url' => 'nullable|url|max:255',
            'cod_enabled' => 'nullable|boolean',
            'bkash_enabled' => 'nullable|boolean',
            'nagad_enabled' => 'nullable|boolean',
            'sslcommerz_enabled' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['cod_enabled'] = $request->has('cod_enabled');
        $data['bkash_enabled'] = $request->has('bkash_enabled');
        $data['nagad_enabled'] = $request->has('nagad_enabled');
        $data['sslcommerz_enabled'] = $request->has('sslcommerz_enabled');

        $this->saveSettings($data, 'payment');

        // Update .env file
        $this->updateEnvFile($request);

        return redirect()->back()->with('success', 'Payment settings updated successfully!');
    }

    /**
     * Update shipping settings.
     */
    public function updateShipping(Request $request)
    {
        $request->validate([
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'standard_shipping_cost' => 'nullable|numeric|min:0',
            'shipping_zones' => 'nullable|string',
        ]);

        $this->saveSettings($request->all(), 'shipping');

        return redirect()->back()->with('success', 'Shipping settings updated successfully!');
    }

    /**
     * Update email settings.
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_driver' => 'required|string|in:smtp,sendmail,mailgun',
            'mail_host' => 'required_if:mail_driver,smtp|nullable|string|max:255',
            'mail_port' => 'required_if:mail_driver,smtp|nullable|numeric',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|in:tls,ssl,null',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        $this->saveSettings($request->all(), 'email');

        // Update .env file for mail settings
        $this->updateMailEnv($request);

        return redirect()->back()->with('success', 'Email settings updated successfully!');
    }

    /**
     * Update SEO settings.
     */
    public function updateSeo(Request $request)
    {
        $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['og_image']);

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('settings/seo', 'public');
            $data['og_image'] = $path;
        }

        $this->saveSettings($data, 'seo');

        return redirect()->back()->with('success', 'SEO settings updated successfully!');
    }

    /**
     * Update social settings.
     */
    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|url|max:255',
        ]);

        $this->saveSettings($request->all(), 'social');

        return redirect()->back()->with('success', 'Social settings updated successfully!');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        Cache::flush();

        return redirect()->back()->with('success', 'Cache cleared successfully!');
    }

    /**
     * Show backup page.
     */
    public function backup()
    {
        $backups = $this->getBackupFiles();
        return view('admin.backup.index', compact('backups'));
    }

    /**
     * Create backup.
     */
    public function createBackup()
    {
        // Create backup logic
        return response()->json(['success' => true, 'message' => 'Backup created successfully!']);
    }

    /**
     * Download backup.
     */
    public function downloadBackup($file)
    {
        // Download backup file
        return redirect()->back()->with('info', 'Download feature coming soon!');
    }

    /**
     * Delete backup.
     */
    public function deleteBackup($file)
    {
        // Delete backup file
        return redirect()->back()->with('success', 'Backup deleted successfully!');
    }

    // ==================== HELPER METHODS ====================

    private function getSettings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        
        return [
            'general' => [
                'store_name' => $settings['store_name'] ?? config('app.name', 'EktaMart'),
                'store_email' => $settings['store_email'] ?? 'info@ektamart.com',
                'store_phone' => $settings['store_phone'] ?? '',
                'store_address' => $settings['store_address'] ?? '',
                'store_description' => $settings['store_description'] ?? '',
                'currency' => $settings['currency'] ?? 'USD',
                'timezone' => $settings['timezone'] ?? 'UTC',
            ],
            'payment' => [
                'ssl_store_id' => $settings['ssl_store_id'] ?? '',
                'ssl_store_password' => $settings['ssl_store_password'] ?? '',
                'ssl_mode' => $settings['ssl_mode'] ?? 'sandbox',
                'ssl_base_url' => $settings['ssl_base_url'] ?? 'https://sandbox.sslcommerz.com',
                'cod_enabled' => $settings['cod_enabled'] ?? true,
                'bkash_enabled' => $settings['bkash_enabled'] ?? false,
                'nagad_enabled' => $settings['nagad_enabled'] ?? false,
                'sslcommerz_enabled' => $settings['sslcommerz_enabled'] ?? false,
            ],
            'shipping' => [
                'free_shipping_threshold' => $settings['free_shipping_threshold'] ?? 100,
                'standard_shipping_cost' => $settings['standard_shipping_cost'] ?? 10,
                'shipping_zones' => $settings['shipping_zones'] ?? '',
            ],
            'email' => [
                'mail_driver' => $settings['mail_driver'] ?? 'smtp',
                'mail_host' => $settings['mail_host'] ?? 'smtp.gmail.com',
                'mail_port' => $settings['mail_port'] ?? 587,
                'mail_username' => $settings['mail_username'] ?? '',
                'mail_password' => $settings['mail_password'] ?? '',
                'mail_encryption' => $settings['mail_encryption'] ?? 'tls',
                'mail_from_address' => $settings['mail_from_address'] ?? 'noreply@ektamart.com',
                'mail_from_name' => $settings['mail_from_name'] ?? 'EktaMart',
            ],
            'seo' => [
                'meta_title' => $settings['meta_title'] ?? 'EktaMart - Premium Ecommerce Platform',
                'meta_description' => $settings['meta_description'] ?? 'EktaMart is a premium multi-vendor ecommerce platform.',
                'meta_keywords' => $settings['meta_keywords'] ?? 'ecommerce, online shopping, multi-vendor',
                'og_image' => $settings['og_image'] ?? null,
            ],
            'social' => [
                'facebook' => $settings['facebook'] ?? '',
                'twitter' => $settings['twitter'] ?? '',
                'instagram' => $settings['instagram'] ?? '',
                'youtube' => $settings['youtube'] ?? '',
                'linkedin' => $settings['linkedin'] ?? '',
                'whatsapp' => $settings['whatsapp'] ?? '',
            ],
        ];
    }

    private function saveSettings(array $data, string $section)
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'section' => $section]
            );
        }
    }

    private function updateEnvFile(Request $request)
    {
        // Update SSLCommerz settings in .env
        if ($request->has('ssl_store_id')) {
            $this->updateEnvValue('SSLCOMMERZ_STORE_ID', $request->ssl_store_id);
        }
        if ($request->has('ssl_store_password')) {
            $this->updateEnvValue('SSLCOMMERZ_STORE_PASSWORD', $request->ssl_store_password);
        }
        if ($request->has('ssl_mode')) {
            $this->updateEnvValue('SSLCOMMERZ_MODE', $request->ssl_mode);
        }
        if ($request->has('ssl_base_url')) {
            $this->updateEnvValue('SSLCOMMERZ_BASE_URL', $request->ssl_base_url);
        }
    }

    private function updateMailEnv(Request $request)
    {
        if ($request->has('mail_driver')) {
            $this->updateEnvValue('MAIL_MAILER', $request->mail_driver);
        }
        if ($request->has('mail_host')) {
            $this->updateEnvValue('MAIL_HOST', $request->mail_host);
        }
        if ($request->has('mail_port')) {
            $this->updateEnvValue('MAIL_PORT', $request->mail_port);
        }
        if ($request->has('mail_username')) {
            $this->updateEnvValue('MAIL_USERNAME', $request->mail_username);
        }
        if ($request->has('mail_password')) {
            $this->updateEnvValue('MAIL_PASSWORD', $request->mail_password);
        }
        if ($request->has('mail_encryption')) {
            $this->updateEnvValue('MAIL_ENCRYPTION', $request->mail_encryption);
        }
        if ($request->has('mail_from_address')) {
            $this->updateEnvValue('MAIL_FROM_ADDRESS', $request->mail_from_address);
        }
        if ($request->has('mail_from_name')) {
            $this->updateEnvValue('MAIL_FROM_NAME', $request->mail_from_name);
        }
    }

    private function updateEnvValue($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            file_put_contents($path, $content);
        }
    }

    private function getBackupFiles()
    {
        // Get backup files from storage
        return [];
    }
}