<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;

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
            ->map(fn($module) => $module->id)->toArray();
        $pages = $allowedPages->where('id_page_type', 2);
        $components = $allowedPages->where('id_page_type', 3);

        foreach ($modules as $module) {
            $module->sub_pages = $pages
                ->where('id_father_page', $module->id)
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

        $modules = $modules->filter(function($module) use ($moduleIds) {
            return !empty($module->sub_pages) || (
                in_array($module->id, $moduleIds) && !empty($module->route)
            );
        })->values();

        return $modules;
    }
}
