<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePage extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageModel = new \App\Models\Page();
        $fatherPageName = 'Administración del Sistema';
        $pages = [
            [
                'page_name' => 'Dashboard',
                'route' => 'dashboard',
                'id_page_type' => 1,
                'description' => 'Página principal del sistema',
            ],
            [
                'page_name' => $fatherPageName,
                'id_page_type' => 1,
                'description' => 'Página para la gestión de usuarios',
            ],
        ];

        foreach ($pages as $pageData) {
            $pageModel::create([
                'page_name' => $pageData['page_name'],
                'route' => $pageData['route'] ?? '',
                'id_page_type' => $pageData['id_page_type'],
                'description' => $pageData['description'],
                'id_father_page' => $pageData['id_father_page'] ?? null,
            ]);
        }

        $fatherPage = $pageModel::where('page_name', $fatherPageName)->first();
        if ($fatherPage) {
            $subPages = [
                [
                    'page_name' => 'Gestión de Usuarios',
                    'route' => 'users.index',
                    'id_page_type' => 2,
                    'description' => 'Página para la gestión de usuarios',
                    'id_father_page' => $fatherPage->id,
                ],
                [
                    'page_name' => 'Gestión de Roles',
                    'route' => 'roles.index',
                    'id_page_type' => 2,
                    'description' => 'Página para la gestión de permisos',
                    'id_father_page' => $fatherPage->id,
                ],
            ];
            foreach ($subPages as $subPageData) {
                $pageModel::create([
                    'page_name' => $subPageData['page_name'],
                    'route' => $subPageData['route'] ?? null,
                    'id_page_type' => $subPageData['id_page_type'],
                    'description' => $subPageData['description'],
                    'id_father_page' => $subPageData['id_father_page'],
                ]);
            }
        }
    }
}
