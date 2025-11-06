<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role as ModelRole;
use App\Models\RoleByPage;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;
use RolesByPages;

class RoleController extends Controller
{
    public function getAll()
    {
        return view('roles.index', ['roles' => ModelRole::all()]);
    }

    public function getById($id)
    {
        $role = $this->getRoleById($id);
        list($modules, $permissions) = $this->getModulesAndPermissions();

        $pagePermissions = [];

        if ($role->pagesByRole) {
            $role->pagesByRole->each(function($pr) use (&$pagePermissions) {
                $pagePermissions[$pr->id_page][] = $pr->id_permission;
            });
        }

        return view('roles.form', [
            "role" => $role,
            "modules" => $modules,
            "permissions" => $permissions,
            "pagePermissions" => $pagePermissions
        ]);
    }

    public function viewCreate()
    {
        list($modules, $permissions) = $this->getModulesAndPermissions();

        return view('roles.form', [
            "role" => [],
            "modules" => $modules,
            "permissions" => $permissions
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'rol_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        if ($this->validateRoleData($request->rol_name)) {
            return redirect()->route('roles.index')
                ->with('error', 'El rol ya existe.');
        }

        $role = ModelRole::create([
            'rol_name' => $request->rol_name,
            'description' => $request->description,
        ]);

        $this->saveRolesByPages($role, $request->permissions ?? []);

        return redirect()->route('roles.index', $role->id)
            ->with('success', 'Rol creado.');
    }

    public function update(Request $request, $id)
    {
        $role = $this->getRoleById($id);

        $request->validate([
            'rol_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        if ($this->validateRoleData($request->rol_name, $id)) {
            return redirect()->route('roles.index', $role->id)
                ->with('error', 'El rol ya existe.');
        }

        $role->update($request->only(['rol_name', 'description']));

        $this->saveRolesByPages($role, $request->permissions ?? []);

        return redirect()->route('roles.index', $role->id)
            ->with('success', 'Rol actualizado.');
    }

    public function delete($id)
    {
        $role = $this->getRoleById($id);

        RoleByPage::where('id_role', $role->id)->delete();
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado.');
    }

    private function validateRoleData(string $rolName, ?int $id = null): bool
    {
        $modelRole = ModelRole::where('rol_name', $rolName);
        if ($id) {
            $modelRole->where('id', '!=', $id);
        }
        $role = $modelRole->first();

        return $role !== null;
    }

    private function getRoleById(int $id)
    {
        $role = ModelRole::with('pagesByRole')->where('id', $id)->first();

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

    public function getModulesAndPermissions()
    {
        $modules = (new PageController())->getAllPagesByModules();
        $permissions = Permission::all();

        $spanishPermissions = [
            'view' => 'Ver',
            'create' => 'Crear',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'export' => 'Exportar',
            'import' => 'Importar',
        ];

        $permissions = $permissions->mapWithKeys(function ($permission) use ($spanishPermissions) {
            return [$permission->id => $spanishPermissions[$permission->permission] ?? $permission->permission];
        });

        return [
            $modules,
            $permissions
        ];
    }

    private function saveRolesByPages(ModelRole $role, array $permissions)
    {
        RoleByPage::where('id_role', $role->id)->delete();

        foreach ($permissions as $permission) {
            list($pageId, $permissionId) = explode('-', $permission);
            RoleByPage::create([
                'id_role' => $role->id,
                'id_page' => $pageId,
                'id_permission' => $permissionId,
            ]);
        }
    }
}
