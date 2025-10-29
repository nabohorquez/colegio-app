<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Role as ModelRole;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModuleController extends Controller
{
    public function getAll()
    {
        return view('modules.index', [
            'modulesTable' => Page::where('id_page_type', 1)->orderBy('page_name')->get()
        ]);
    }

    public function viewCreate() {
        return view('modules.form', [
            "module" => []
        ]);
    }

    public function getById($id)
    {
        $module = $this->getModuleById($id);
        return view('modules.form', [
            "module" => $module
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'module_name' => 'required|string|max:50',
            'description' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:20',
        ]);

        if ($this->validateModuleData($request->module_name)) {
            return response()->json(['message' => 'El modulo ya existe'], 400);
        }

        $data = [
            'page_name' => $request->module_name,
            'description' => $request->description,
            'id_page_type' => 1,
        ];

        if ($request->filled('route')) {
            $existingRoute = Page::where('route', $request->route)->first();
            if ($existingRoute) {
                return redirect()->route('modules.index')
                    ->with('error', 'La ruta ya existe.');
            }

            $data['route'] = $request->route;
        }

        $module = Page::create($data);

        return redirect()->route('modules.index', $module->id)
            ->with('success', 'Modulo creado.');
    }

    public function update(Request $request, $id)
    {
        $module = $this->getModuleById($id);

        $request->validate([
            'module_name' => 'sometimes|required|string|max:50',
            'description' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:20'
        ]);


        if ($this->validateModuleData($request->module_name, $id)) {
            return redirect()->route('modules.index', $module->id)
                ->with('error', 'El modulo ya existe.');
        }

        $data = [
            'page_name' => $request->module_name,
            'description' => $request->description,
        ];

        if ($request->filled('route')) {
            $data['route'] = $request->route;
        }

        $module->update($data);

        return redirect()->route('modules.index', $module->id)
            ->with('success', 'Modulo actualizado.');
    }

    public function delete($id)
    {
        $module = $this->getModuleById($id);

        $module->delete();
        return redirect()->route('modules.index')
            ->with('success', 'Modulo eliminado.');
    }

    private function validateModuleData(string $moduleName, ?int $id = null): bool
    {
        $moduleModel = Page::where([
            'page_name' => $moduleName,
            'id_page_type' => 1
        ]);
        if ($id) {
            $moduleModel->where('id', '!=', $id);
        }
        $module = $moduleModel->first();

        return $module !== null;
    }

    private function getModuleById(int $id)
    {
        $module = Page::find($id);
        if ($module) {
            return $module;
        } else {
            throw new NotFoundHttpException('La pagina no se encuentra');
        }
    }
}
