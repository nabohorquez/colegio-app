<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function getPagesToMenu($userId = null)
    {
        $roleIds = User::find($userId)?->roles()->get()->map(fn($role) => $role->id)->toArray();
        if (empty($roleIds)) {
            return [];
        }

        $modules = Page::where('id_page_type', 1)->get();
        $allowedPages = Page::whereIn('id_page_type', [1, 2, 3])
            ->whereHas('roles', function ($q) use ($roleIds) {
                $q->whereIn('roles.id', $roleIds);
            })
            ->get();

        $moduleIds = $allowedPages
            ->where('id_page_type', 1)
            ->map(fn($page) => $page->id)->toArray();
        $pages = $allowedPages->where('id_page_type', 2);
        $components = $allowedPages->where('id_page_type', 3);

        foreach ($modules as $page) {
            $page->sub_pages = $pages
                ->where('id_father_page', $page->id)
                ->map(function($page) use ($components) {
                    $page->components = $components
                        ->where('id_father_page', $page->id)
                        ->values()
                        ->all();
                    return $page;
                })
                ->values()
                ->all();
        }

        $modules = $modules->filter(function($page) use ($moduleIds) {
            return !empty($page->sub_pages) || (
                in_array($page->id, $moduleIds) && !empty($page->route)
            );
        })->values();

        return $modules;
    }

    public function getAll()
    {
        return view('pages.index', [
            'pagesTable' => Page::join('pages as father', 'father.id', 'pages.id_father_page')
                ->select(['pages.*', 'father.page_name as module_name'])
                ->where('pages.id_page_type', 2)
                ->orderBy('pages.page_name')
                ->get()
        ]);
    }

    public function viewCreate() {
        $modules = Page::where('id_page_type', 1)->orderBy('page_name')->get();
        $moduleOptions = [];
        foreach ($modules as $page) {
            $moduleOptions[$page->id] = $page->page_name;
        }

        return view('pages.form', [
            "page" => [],
            'moduleOptions' => $moduleOptions
        ]);
    }

    public function getById($id)
    {
        $page = $this->getPageById($id);

        $modules = Page::where('id_page_type', 1)->orderBy('page_name')->get();
        $moduleOptions = [];
        foreach ($modules as $module) {
            $moduleOptions[$module->id] = $module->page_name;
        }

        return view('pages.form', [
            "page" => $page,
            'moduleOptions' => $moduleOptions
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'module_id' => 'required|integer|exists:pages,id',
            'page_name' => 'required|string|max:50',
            'description' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:20',
        ]);

        if ($this->validatePageData($request->page_name)) {
            return response()->json(['message' => 'La pagina ya existe'], 400);
        }

        $data = [
            'id_father_page' => $request->module_id,
            'page_name' => $request->page_name,
            'description' => $request->description,
            'id_page_type' => 2,
        ];

        if ($request->filled('route')) {
            $existingRoute = Page::where('route', $request->route)->first();
            if ($existingRoute) {
                return redirect()->route('pages.index')
                    ->with('error', 'La ruta ya existe.');
            }

            $data['route'] = $request->route;
        }

        $page = Page::create($data);

        return redirect()->route('pages.index', $page->id)
            ->with('success', 'Modulo creado.');
    }

    public function update(Request $request, $id)
    {
        $page = $this->getPageById($id);

        $request->validate([
            'module_id' => 'required|integer|exists:pages,id',
            'page_name' => 'sometimes|required|string|max:50',
            'description' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:20'
        ]);


        if ($this->validatePageData($request->page_name, $id)) {
            return redirect()->route('pages.index', $page->id)
                ->with('error', 'El modulo ya existe.');
        }

        $data = [
            'id_father_page' => $request->module_id,
            'page_name' => $request->page_name,
            'description' => $request->description,
        ];

        if ($request->filled('route')) {
            $data['route'] = $request->route;
        }

        $page->update($data);

        return redirect()->route('pages.index', $page->id)
            ->with('success', 'Modulo actualizado.');
    }

    public function delete($id)
    {
        $page = $this->getPageById($id);

        $page->delete();
        return redirect()->route('pages.index')
            ->with('success', 'Modulo eliminado.');
    }

    private function validatePageData(string $pageName, ?int $id = null): bool
    {
        $pageModel = Page::where([
            'page_name' => $pageName,
            'id_page_type' => 2
        ]);
        if ($id) {
            $pageModel->where('id', '!=', $id);
        }
        $page = $pageModel->first();

        return $page !== null;
    }

    private function getPageById(int $id)
    {
        $page = Page::find($id);
        if ($page) {
            return $page;
        } else {
            throw new NotFoundHttpException('La pagina no se encuentra');
        }
    }
}
