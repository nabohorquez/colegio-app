<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role as ModelRole;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Role extends Controller
{
    public function getAll()
    {
        return view('components.role', ['roles' => ModelRole::all()]);
    }

    public function getById($id)
    {
        $role = $this->getRoleById($id);
        return response()->json($role);
    }

    public function create(Request $request)
    {
        $request->validate([
            'rol_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($this->validateRoleData($request->rol_name)) {
            return response()->json(['message' => 'El rol ya existe'], 400);
        }

        $role = ModelRole::create([
            'rol_name' => $request->rol_name,
            'description' => $request->description,
        ]);

        return response()->json($role, 201);
    }

    public function update(Request $request, $id)
    {
        $role = $this->getRoleById($id);

        $request->validate([
            'rol_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($this->validateRoleData($request->rol_name, $id)) {
            return response()->json(['message' => 'El rol ya existe'], 400);
        }

        $role->update($request->only(['rol_name', 'description']));

        return response()->json($role);
    }

    public function delete($id)
    {
        $role = $this->getRoleById($id);

        $role->delete();
        return response()->json(['message' => 'Rol eliminado correctamente']);
    }

    private function validateRoleData(string $rolName, ?int $id = null): bool
    {
        $modelRole = new ModelRole();
        $modelRole->where('rol_name', $rolName);
        if ($id) {
            $modelRole->where('id', '!=', $id);
        }
        $role = $modelRole->first();

        return $role !== null;
    }

    private function getRoleById(int $id)
    {
        $role = ModelRole::find($id);
        if ($role) {
            return $role;
        } else {
            throw new NotFoundHttpException('El rol no se encuentra');
        }
    }
}
