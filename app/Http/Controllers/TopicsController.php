<?php

// app/Http/Controllers/TopicsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function mostrar()
    {
        // Aquí se pueden cargar datos desde la base de datos (Modelo)

        // Si más adelante necesitas pasar datos reales, consulta un modelo y pásalos aquí.
        $data = [
            'nombre' => 'Mundo Laravel'
        ];

        // Mostrar la vista de topics dentro de la carpeta school_admin
        return view('school_admin.topics.topics', $data);
    }
}