<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Page;
use Illuminate\Support\Facades\DB;

// Eliminar páginas de enrollment_types y enrollments
$deleted_count = DB::table('pages')
    ->whereIn('page_name', ['Enrollment Types', 'Enrollments'])
    ->delete();

echo "✅ Eliminadas $deleted_count páginas de enrollment\n";

// Eliminar permisos relacionados en roles_by_pages
$deleted_perms = DB::table('roles_by_pages')
    ->where('id_page', 'not exists', function($q) {
        $q->select('id')->from('pages');
    })
    ->delete();

echo "✅ Limpieza completada\n";
?>
