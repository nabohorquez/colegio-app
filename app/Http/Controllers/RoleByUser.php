<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleByUser as ModelRoleByUser;

class RoleByUser extends Controller
{
    public function getAll()
    {
        return response()->json(ModelRoleByUser::all());
    }
}
