<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Development',
            'DevOps & Cloud',
            'Mobile Development',
            'Data & Analytics',
            'Design & UI/UX',
            'Writing & Translation',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name]
            );
        }
    }
}
