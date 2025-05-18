<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Lagers',
                'description' => 'Crisp, clean, and refreshing beers fermented with bottom-fermenting yeast at cooler temperatures.',
                'image_url' => 'images/categories/lagers/lagers.jpg'
            ],
            [
                'name' => 'Ales',
                'description' => 'Full-bodied beers fermented with top-fermenting yeast at warmer temperatures, offering complex flavors.',
                'image_url' => 'images/categories/ales/ales.jpg'
            ],
            [
                'name' => 'Wheat Beers',
                'description' => 'Light, refreshing beers brewed with a significant proportion of wheat relative to malted barley.',
                'image_url' => 'images/categories/wheat-beers/wheat-beers.jpg'
            ],
            [
                'name' => 'Stouts',
                'description' => 'Dark, rich beers made using roasted malt or barley, known for their coffee and chocolate notes.',
                'image_url' => 'images/categories/stouts/stouts.jpg'
            ],
            [
                'name' => 'Porters',
                'description' => 'Dark beers with a rich history, featuring roasted malt flavors with chocolate and caramel notes.',
                'image_url' => 'images/categories/porters/porters.jpg'
            ],
            [
                'name' => 'Craft',
                'description' => 'Unique and innovative beers from small, independent breweries, often experimenting with flavors.',
                'image_url' => 'images/categories/craft/craft.jpg'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'image_url' => $category['image_url'],
                ]
            );
        }
    }
} 