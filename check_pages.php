<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=colegio_app', 'root', '');

echo "=== PÁGINAS DE CALIFICACIONES/GRADES ===\n\n";
$stmt = $pdo->query("
    SELECT id, page_name, route, id_father_page 
    FROM pages 
    WHERE page_name LIKE '%alificacion%' 
       OR page_name LIKE '%Calificaciones%'
       OR route LIKE '%grade%'
    ORDER BY id_father_page, page_name
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    echo "ID: {$row['id']}, Nombre: {$row['page_name']}, Ruta: {$row['route']}, Padre: {$row['id_father_page']}\n";
}

echo "\n=== TODAS LAS PÁGINAS SIN PADRE ===\n\n";
$stmt = $pdo->query("
    SELECT id, page_name, route 
    FROM pages 
    WHERE id_father_page IS NULL
    ORDER BY page_name
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    echo "ID: {$row['id']}, Nombre: {$row['page_name']}, Ruta: {$row['route']}\n";
}
