<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Roles::class);
        $this->call(FirstUser::class);
        $this->call(Permissions::class);
        $this->call(PageTypes::class);
        $this->call(RolePage::class);
        $this->call(PermissionSuperAdmin::class);
        $this->call(ModulePage::class);
        $this->call(PagePage::class);
            $this->call(SchoolAdminPageSeeder::class);
            $this->call(EmployeesModuleSeeder::class);
        $this->call(GuardiansModuleSeeder::class);
        $this->call(StudentsModuleSeeder::class);
        $this->call(TopicsSeeder::class);
              $this->call(TopicsPageSeeder::class);
        $this->call(ActivitiesSeeder::class);
        $this->call(ActivitiesPageSeeder::class);
    }
    
}
