<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=colegio_app', 'root', '');

echo "Eliminando página ID 14 (Calificaciones antigua con ruta: school.grades.index)...\n\n";

try {
    // Eliminar de roles_by_pages
    $count = $pdo->exec('DELETE FROM roles_by_pages WHERE id_page = 14');
    echo "✓ Permisos eliminados ($count registros)\n";
    
    // Luego eliminar la página
    $pdo->exec('DELETE FROM pages WHERE id = 14');
    echo "✓ Página ID 14 eliminada\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n✅ Verificando páginas de calificaciones/grades:\n";
$stmt = $pdo->query('SELECT id, page_name, route FROM pages WHERE route LIKE "%grade%" ORDER BY id');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    echo "ID: {$row['id']}, Nombre: {$row['page_name']}, Ruta: {$row['route']}\n";
}
