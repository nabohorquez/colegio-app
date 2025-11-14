<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\RoleController;
use App\Models\Page;

// Simular login
$user = User::first();
Auth::loginUsingId($user->id);

echo "=== Testing Access to enrollment_types ===\n\n";
echo "User: {$user->name} (ID={$user->id})\n";
echo "Roles:\n";
foreach ($user->roles as $role) {
    echo "  - {$role->rol_name}\n";
}

// Simular lo que hace el middleware CheckPagePermissions
$routeName = 'enrollment_types.index';
echo "\nRoute Name: $routeName\n";

$moduleName = Str::before($routeName, '.') ?: $routeName;
echo "Module Name (extracted): $moduleName\n";

// Obtener permisos usando el método del RoleController
$roleController = new RoleController();
$permissions = $roleController->getPermissionsPageByRoleId($user->id, $moduleName);

echo "\nPermissions found: ";
if (empty($permissions)) {
    echo "❌ EMPTY!\n";
} else {
    echo implode(', ', $permissions) . "\n";
}

// Si no hay permisos, esto es lo que hace el middleware
if (empty($permissions)) {
    echo "\n⚠️ El middleware rechazaría este acceso (redirect a dashboard)\n";
} else {
    echo "\n✅ El middleware permitiría este acceso\n";
}

// Verificar qué página se está buscando
echo "\n=== Checking Database ===\n";
$page = Page::where('route', 'enrollment_types')->first();
if ($page) {
    echo "✅ Página encontrada: {$page->page_name} (ID={$page->id})\n";
} else {
    echo "❌ Página NO encontrada en BD\n";
}

// Verificar la relación de roles
if ($page) {
    echo "\nRoles asignados a esta página:\n";
    $roles = $page->roles()->get();
    foreach ($roles as $role) {
        echo "  - {$role->rol_name}\n";
    }
}
