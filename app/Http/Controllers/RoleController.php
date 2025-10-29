<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Role as ModelRole;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function getAll()
    {
        return view('roles.index', ['roles' => ModelRole::all()]);
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

    /**
     * Obtener permisos por pagina
     * @param int $userId User iD
     * @param string $pageRoute Page route
     */
    public function getPermissionsPageByRoleId(int $userId, string $pageRoute)
    {
        $user = User::find($userId);
        $roleIds = $user ? $user->roles->pluck('id')->toArray() : [];

        if (empty($roleIds)) {
            return [];
        }

        $allowedPages = Page::where('route', 'like', $pageRoute . '%')
            ->whereHas('roles', function ($q) use ($roleIds) {
                $q->whereIn('roles.id', $roleIds);
            })
            ->get()
            ->filter(fn($page) =>
                (strpos($page->route, '.') ? Str::before($page->route, '.') : $page->route) === $pageRoute
            );

        if ($allowedPages->isEmpty()) {
            return [];
        }

        $permissions = $allowedPages->map(function ($allowedPage) {
            return $allowedPage->roleByPage->map(function ($rp) {
                return optional($rp->permissionByPage)->permission;
            });
        })->first();

        return $permissions ? $permissions->filter()->values()->toArray() : [];
    }
}
