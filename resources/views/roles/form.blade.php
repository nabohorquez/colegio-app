@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{
                Str::after(Route::currentRouteName(), '.') == 'viewCreate'
                    ? route('roles.create') : route('roles.update', $role->id)
            }}" method="post"
        >
            @csrf
            @if(Str::after(Route::currentRouteName(), '.') != 'viewCreate')
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="rol_name" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" id="rol_name" name="rol_name" value="{{ $role->rol_name ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $role->description ?? '' }}</textarea>
            </div>

            <div class="mb-3 mt-5">
                <h5 class="form-label d-block">Permisos por módulo</h5>
                <div class="row g-3">
                    <ul class="nav nav-tabs" id="moduleTabs">
                        @foreach ($modules as $module)
                            <li class="nav-item">
                                <button
                                    class="nav-link"
                                    id="{{ $module->id }}-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#{{ $module->id }}-tab-pane"
                                    type="button"
                                    role="tab"
                                    aria-controls="{{ $module->id }}-tab-pane"
                                >
                                    {{ $module->page_name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="pagesByModuleTabContent">
                        @foreach ($modules as $module)
                            <div
                                class="tab-pane fade row"
                                id="{{ $module->id }}-tab-pane"
                                role="tabpanel"
                                aria-labelledby="{{ $module->id }}-tab"
                                tabindex="{{ $module->id }}"
                            >
                                <div class="col-12 justify-content-end d-flex mx-2 row">
                                    <div class="d-flex col-sm-12 col-md-6 col-lg-4" role="search">
                                        <input class="form-control me-2" type="search"
                                            placeholder="Buscar pagina" aria-label="Search"
                                            oninput="filterPagesByModule('{{ Str::slug($module->id) }}', this.value)"
                                            id="searchField"
                                        />
                                    </div>
                                    <div class="form-check mb-2 col-sm-12 col-md-6 col-lg-4">
                                        <input
                                            class="mx-1 form-check-input permission-item permission-{{ Str::slug($module->id) }}"
                                            type="checkbox" name="permissionAll" value="{{ $module->id }}"
                                            id="permissionAll{{ $module->id }}"
                                            onchange="checkedAllModule('{{ Str::slug($module->id) }}', this.checked)"
                                        >
                                        <label class="form-check-label"
                                            for="permissionAll{{ $module->id }}">Seleccionar todo</label>
                                    </div>
                                </div>
                                <div class="col-12 row">
                                    @if(!$module->sub_pages || count($module->sub_pages) === 0)
                                        <h6 class="fw-semibold col-12 label-page-module-{{ Str::slug($module->id) }}"
                                            data-etiqueta="{{ $module->page_name }}"
                                            data-page="{{ Str::slug($module->id) }}"
                                            data-module="{{ Str::slug($module->id) }}"
                                        >
                                            {{ $module->page_name }}
                                        </h6>
                                        @foreach ($permissions as $key => $permission)
                                            <div class="col-sm-6 col-md-3 col-lg-3 permission-row"
                                                data-etiqueta="{{ $module->page_name }}"
                                                data-page="{{ Str::slug($module->id) }}"
                                                data-module="{{ Str::slug($module->id) }}"
                                            >
                                                <div class="form-check mb-2">
                                                    <input
                                                        class="form-check-input permission-item permission-{{ Str::slug($module->id) }}"
                                                        type="checkbox" name="permissions[]" value="{{ $module->id }}-{{ $key }}"
                                                        id="modulePermission{{ $key }}"
                                                        onchange="updateModuleCheckboxState('{{ Str::slug($module->id) }}')"
                                                        {{ isset($pagePermissions[$module->id]) && in_array($key, $pagePermissions[$module->id]) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label"
                                                        for="modulePermission{{ $key }}">{{ $permission }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach ($module->sub_pages as $sub_page)
                                            <h6 class="fw-semibold col-12 label-sub-page-module-{{ Str::slug($module->id) }}"
                                                data-etiqueta="{{ $sub_page->page_name }}"
                                                data-page="{{ Str::slug($sub_page->id) }}"
                                                data-module="{{ Str::slug($module->id) }}"
                                            >
                                                {{ $sub_page->page_name }}
                                            </h6>
                                            @foreach ($permissions as $key => $permission)
                                                <div class="col-sm-6 col-md-3 col-lg-3 permission-row"
                                                    data-etiqueta="{{ $sub_page->page_name }}"
                                                    data-page="{{ Str::slug($sub_page->id) }}"
                                                    data-module="{{ Str::slug($module->id) }}"
                                                >
                                                    <div class="form-check mb-2">
                                                        <input
                                                            class="form-check-input permission-item permission-{{ Str::slug($module->id) }} sub-page-{{ Str::slug($sub_page->id) }}"
                                                            type="checkbox" name="permissions[]" value="{{ $sub_page->id }}-{{ $key }}"
                                                            id="subPagePermission{{ $key }}"
                                                            onchange="updateModuleCheckboxState('{{ Str::slug($module->id) }}')"
                                                            {{ isset($pagePermissions[$sub_page->id]) && in_array($key, $pagePermissions[$sub_page->id]) ? 'checked' : '' }}
                                                        >
                                                        <label class="form-check-label"
                                                            for="subPagePermission{{ $key }}">{{ $permission }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('js/role/form.js') }}"></script>
    @endpush
@endsection
