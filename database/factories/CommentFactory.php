<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph($nbSentences = 5, $variableNbSentences = true),
            'parent_id' => 1,
            'meta_data' => [
                'likes' => $this->faker->randomDigit,
                'liked_by' => $this->faker->numberBetween($min = 1, $max = 29),
            ],
            'user_id' => $this->faker->numberBetween($min = 1, $max = 29),
            'post_id' => $this->faker->numberBetween($min = 1, $max = 29),
            'created_at' => $this->faker->date($format = 'Y-m-d', $max = 'now') . $this->faker->time($format = 'H:i:s', $max = 'now'),
            'updated_at' => $this->faker->date($format = 'Y-m-d', $max = 'now') . $this->faker->time($format = 'H:i:s', $max = 'now'),
        ];
    }
}
