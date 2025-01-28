<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class bookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Predefined RFID values
        static $rfids = [
            '0280160541',
            '0280160285',
            '0280160029',
            '0280159773',
            '0280159517',
        ];

        static $index = 0;

        return [
            'rfid' => $rfids[$index++ % count($rfids)], // Cycle through the predefined RFID values
            'name' => $this->faker->sentence(4),
            'category_id' => random_int(1, 10),
            'auther_id' => random_int(1, 10),
            'publisher_id' => random_int(1, 10),
            'status' => 'Y',
        ];
    }
}
