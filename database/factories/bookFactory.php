<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
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

        // Predefined values for category, author, and publisher
        $categories = ['Fiction', 'Non-fiction', 'Science Fiction', 'Mystery', 'Romance'];
        $authors = ['J.K. Rowling', 'Stephen King', 'Agatha Christie', 'George Orwell', 'Jane Austen'];
        $publishers = ['Penguin', 'HarperCollins', 'Simon & Schuster', 'Hachette', 'Macmillan'];

        return [
            'rfid'      => $rfids[$index++ % count($rfids)], // Cycle through the predefined RFID values
            'name'      => $this->faker->sentence(4),
            'category'  => $this->faker->randomElement($categories),
            'author'    => $this->faker->randomElement($authors),
            'publisher' => $this->faker->randomElement($publishers),
            'copy'      => $this->faker->numberBetween(1, 10),
            'status'    => 'Y',
        ];
    }
}
