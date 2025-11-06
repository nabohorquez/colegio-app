<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\RoleByPage;
use App\Models\Page;
use App\Models\Role;

// List users and their roles
$users = User::with('roles')->get();
echo "Users and roles:\n";
foreach ($users as $u) {
    $roleNames = $u->roles->pluck('rol_name')->toArray();
    echo "- User {$u->id}: {$u->name} ({$u->email}) Roles: " . implode(', ', $roleNames) . "\n";
}

// List role_by_pages for SuperAdministrador and for first user's roles
$super = Role::where('rol_name','SuperAdministrador')->first();
if ($super) {
    echo "\nRoleByPage entries for SuperAdministrador (id={$super->id}):\n";
    $rbps = RoleByPage::where('id_role',$super->id)->get();
    foreach ($rbps as $r) {
        $page = Page::find($r->id_page);
        $perm = $r->id_permission;
        echo "- page_id={$r->id_page} page_name=" . ($page? $page->page_name : 'N/A') . " perm_id={$perm}\n";
    }
} else {
    echo "\nNo SuperAdministrador role found.\n";
}

// For first user, list allowed pages via PageController logic
echo "\nComputed menu for first user (if any):\n";
$firstUser = $users->first();
if ($firstUser) {
    $modules = (new App\Http\Controllers\PageController())->getPagesToMenu($firstUser->id);
    foreach ($modules as $m) {
        echo "- Module: {$m->page_name} (id={$m->id}) route={$m->route}\n";
        if (!empty($m->sub_pages)) {
            foreach ($m->sub_pages as $sp) {
                echo "  - Subpage: {$sp->page_name} (id={$sp->id}) route={$sp->route}\n";
            }
        }
    }
} else {
    echo "No users found.\n";
}

echo "\nDone.\n";
