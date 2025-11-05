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
        $this->call(TopicsSeeder::class);
    }
}
