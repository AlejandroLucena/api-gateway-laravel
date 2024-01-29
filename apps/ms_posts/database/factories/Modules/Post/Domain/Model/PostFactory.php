<?php

namespace Database\Factories\Modules\Post\Domain\Model;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Post\Domain\Model\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->text(),
        ];
    }
}
