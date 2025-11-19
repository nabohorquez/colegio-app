<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition()
    {
        return [
            'permission' => $this->faker->unique()->randomElement(['create', 'read', 'update', 'delete', 'export']),
        ];
    }
}
