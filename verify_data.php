<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=colegio_app', 'root', '');

echo "=== VERIFICACIÓN DE DATOS CARGADOS ===\n\n";

$tables = [
    'Actividades' => 'activities',
    'Contenidos (Topics)' => 'topics',
    'Materias (Subjects)' => 'subjects',
    'Estudiantes' => 'students',
    'Matrículas' => 'enrollments',
    'Tipos de Matrículas' => 'enrollment_types',
];

foreach ($tables as $label => $table) {
    $result = $pdo->query("SELECT COUNT(*) as count FROM $table")->fetch(PDO::FETCH_ASSOC);
    echo "✅ " . str_pad($label, 25) . ": " . $result['count'] . " registros\n";
}

echo "\n=== ENLACES PARA VISUALIZAR ===\n\n";
echo "📱 Calificaciones:       http://127.0.0.1:8000/student-grades\n";
echo "📚 Contenidos:           http://127.0.0.1:8000/topics\n";
echo "🎯 Actividades:          http://127.0.0.1:8000/activities\n";
echo "👨‍🎓 Matrículas:            http://127.0.0.1:8000/enrollments\n";
echo "📖 Materias:             http://127.0.0.1:8000/subjects\n";
?>

