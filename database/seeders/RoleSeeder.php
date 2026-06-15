use Spatie\Permission\Models\Role;

public function run()
{
    Role::create(['name'=>'Super Admin']);
    Role::create(['name'=>'Admin']);
    Role::create(['name'=>'Vendor']);
    Role::create(['name'=>'Customer']);
}