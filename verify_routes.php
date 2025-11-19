<?php
echo "=== VERIFICACIÓN DE RUTAS ===\n\n";

$routesFile = 'routes/web.php';
$content = file_get_contents($routesFile);

echo "Rutas definidas para:\n";
echo "✓ Topics: " . (strpos($content, "prefix('topics')") ? "SÍ" : "NO") . "\n";
echo "✓ Activities: " . (strpos($content, "prefix('activities')") ? "SÍ" : "NO") . "\n";
echo "✓ Student-grades: " . (strpos($content, "prefix('student-grades')") ? "SÍ" : "NO") . "\n";
echo "✓ Enrollments: " . (strpos($content, "prefix('enrollments')") ? "SÍ" : "NO") . "\n";

echo "\n=== VERIFICACIÓN DE VISTAS ===\n\n";

$files = [
    'resources/views/school_admin/topics/index.blade.php' => 'topics',
    'resources/views/school_admin/activities/index.blade.php' => 'activities',
    'resources/views/school_admin/grades/index.blade.php' => 'student-grades',
];

foreach ($files as $file => $expected) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $hasOldRoutes = (strpos($content, "school.topics") !== false || 
                        strpos($content, "school.activities") !== false || 
                        strpos($content, "school.grades") !== false);
        
        if ($hasOldRoutes) {
            echo "⚠️  $file: RUTAS ANTIGUAS DETECTADAS\n";
        } else {
            echo "✓ $file: OK\n";
        }
    }
}
