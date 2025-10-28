<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageType;

class PageTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type_name' => 'Módulo', 'description' => 'Unidad principal del menú'],
            ['type_name' => 'Pagina', 'description' => 'Elemento secundario dentro de un módulo'],
            ['type_name' => 'Componente', 'description' => 'Elemento secundario dentro de una pagina'],
        ];

        foreach ($types as $type) {
            PageType::firstOrCreate(['type_name' => $type['type_name']], $type);
        }
    }
}
