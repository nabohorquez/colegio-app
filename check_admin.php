<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Page;

$schoolAdmin = Page::where('route', 'school.admin')->first();
if ($schoolAdmin) {
    echo "\n📁 Administración de Colegio\n";
    $pages = Page::where('id_father_page', $schoolAdmin->id)->orderBy('id')->get();
    foreach ($pages as $page) {
        $hasChildren = Page::where('id_father_page', $page->id)->exists();
        $icon = $hasChildren ? "📂" : "📄";
        echo "   $icon " . $page->page_name . " (" . ($page->route ?? 'null') . ")\n";
    }
}
