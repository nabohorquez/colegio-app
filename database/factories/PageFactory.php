<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'id_page_type' => $this->faker->numberBetween(1, 3),
            'id_father_page' => null,
            'page_name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'route' => $this->faker->slug() . '.index',
        ];
    }

    public function module()
    {
        return $this->state(fn (array $attributes) => [
            'id_page_type' => 1,
            'id_father_page' => null,
        ]);
    }

    public function page()
    {
        return $this->state(fn (array $attributes) => [
            'id_page_type' => 2,
        ]);
    }

    public function component()
    {
        return $this->state(fn (array $attributes) => [
            'id_page_type' => 3,
        ]);
    }
}
