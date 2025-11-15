<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Page;
use App\Models\PageType;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleByPage;

return new class extends Migration
{
    public function up()
    {
            // Esta migración fue movida al seeder TopicsPageSeeder
            // para evitar conflictos con la creación de páginas
    }

    public function down()
    {
            // Esta migración fue movida al seeder TopicsPageSeeder
    }
};
