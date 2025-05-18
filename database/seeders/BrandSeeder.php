<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'id' => 1,
                'name' => 'San Miguel Brewery',
                'slug' => 'san-miguel-brewery',
                'description' => 'San Miguel Brewery Inc. is the largest beer producer in the Philippines, known for iconic brands like San Miguel Pale Pilsen and Red Horse. Established in 1890, it dominates the local beer market with a wide range of alcoholic beverages.',
                'image_url' => 'images/brands/1/san-miguel-brewery.jpg',
                'website_url' => null,
                'founding_year' => 1890,
                'headquarters' => 'Mandaluyong, Philippines',
                'created_at' => '2025-05-17 10:36:43',
                'updated_at' => '2025-05-17 10:36:43'
            ],
            [
                'id' => 2,
                'name' => 'Asia Brewery',
                'slug' => 'asia-brewery',
                'description' => 'Asia Brewery is one of the largest beverage producers in the Philippines, competing with San Miguel. Known for brands like Beer na Beer and Colt 45, it offers affordable alternatives in the local market.',
                'image_url' => 'images/brands/2/asia-brewery.png',
                'website_url' => null,
                'founding_year' => 1982,
                'headquarters' => 'Manila, Philippines',
                'created_at' => '2025-05-17 10:36:43',
                'updated_at' => '2025-05-17 10:36:43'
            ],
            [
                'id' => 3,
                'name' => 'Engkanto Brewery',
                'slug' => 'engkanto-brewery',
                'description' => 'Engkanto Brewery is a craft brewery in the Philippines known for its high-quality craft beers like Engkanto Pale Ale and IPA. It represents the growing craft beer movement in the country.',
                'image_url' => 'images/brands/3/engkanto-brewery.png',
                'website_url' => null,
                'founding_year' => 2017,
                'headquarters' => 'Makati, Philippines',
                'created_at' => '2025-05-17 10:36:43',
                'updated_at' => '2025-05-17 10:36:43'
            ],
            [
                'id' => 4,
                'name' => 'The Cebruery',
                'slug' => 'the-cebruery',
                'description' => 'The Cebruery is a craft brewery based in Cebu, Philippines, specializing in unique craft beers with tropical flavors. Known for Island Hopper IPA and other innovative brews.',
                'image_url' => 'images/brands/4/the-cebruery.jpg',
                'website_url' => null,
                'founding_year' => 2016,
                'headquarters' => 'Cebu, Philippines',
                'created_at' => '2025-05-17 10:36:43',
                'updated_at' => '2025-05-17 10:36:43'
            ],
            [
                'id' => 5,
                'name' => 'Pedro Brewcrafters',
                'slug' => 'pedro-brewcrafters',
                'description' => 'Pedro Brewcrafters is a Filipino craft brewery known for its creative beer offerings. Based in Manila, it produces small-batch craft beers with local ingredients and innovative recipes.',
                'image_url' => 'images/brands/5/pedro-brewcrafters.jpg',
                'website_url' => null,
                'founding_year' => 2015,
                'headquarters' => 'Manila, Philippines',
                'created_at' => '2025-05-17 10:36:43',
                'updated_at' => '2025-05-17 10:36:43'
            ],
            [
                'id' => 6,
                'name' => 'Crazy Carabao',
                'slug' => 'crazy-carabao',
                'description' => 'Crazy Carabao is a local craft brewery producing unique Filipino-inspired craft beers. Known for its playful branding and quality brews that appeal to both casual drinkers and beer enthusiasts.',
                'image_url' => 'images/brands/6/crazy-carabao.png',
                'website_url' => null,
                'founding_year' => 2018,
                'headquarters' => 'Quezon City, Philippines',
                'created_at' => '2025-05-17 10:36:43',
                'updated_at' => '2025-05-17 10:36:43'
            ],
            [
                'id' => 7,
                'name' => 'Nipa Brew',
                'slug' => 'nipa-brew',
                'description' => 'Nipa Brew is a Filipino craft beer brand specializing in locally-inspired brews. The name references the traditional nipa palm, symbolizing their commitment to Filipino flavors and ingredients.',
                'image_url' => 'images/brands/7/nipa-brew.png',
                'website_url' => null,
                'founding_year' => 2019,
                'headquarters' => 'Manila, Philippines',
                'created_at' => '2025-05-17 10:36:44',
                'updated_at' => '2025-05-17 10:36:44'
            ],
            [
                'id' => 8,
                'name' => 'Alamat Brewery',
                'slug' => 'alamat-brewery',
                'description' => 'Alamat Brewery crafts beers inspired by Filipino culture and ingredients. Known for innovative brews like their Ube Stout, they celebrate local flavors through craft beer.',
                'image_url' => 'images/brands/8/alamat-brewery.jpg',
                'website_url' => null,
                'founding_year' => 2020,
                'headquarters' => 'Taguig, Philippines',
                'created_at' => '2025-05-17 10:36:44',
                'updated_at' => '2025-05-17 10:36:44'
            ],
            [
                'id' => 9,
                'name' => "Joe's Brew",
                'slug' => 'joes-brew',
                'description' => "Joe's Brew is a pioneer in the Philippine craft beer scene, offering a range of artisanal beers since 2011. Known for their Fish Rider Pale Ale and commitment to quality brewing.",
                'image_url' => 'images/brands/9/joes-brew.jpg',
                'website_url' => null,
                'founding_year' => 2011,
                'headquarters' => 'Manila, Philippines',
                'created_at' => '2025-05-17 10:36:44',
                'updated_at' => '2025-05-17 10:36:44'
            ],
            [
                'id' => 10,
                'name' => "Fat Pauly's Craft Brewery",
                'slug' => 'fat-paulys-craft-brewery',
                'description' => "Fat Pauly's Craft Brewery specializes in bold, flavorful craft beers with a Filipino twist. Their IPA and Coffee Porter are particularly popular among craft beer enthusiasts.",
                'image_url' => 'images/brands/10/fat-paulys-craft-brewery.jpg',
                'website_url' => null,
                'founding_year' => 2017,
                'headquarters' => 'Cebu, Philippines',
                'created_at' => '2025-05-17 10:36:44',
                'updated_at' => '2025-05-17 10:36:44'
            ]
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert($brand);
        }
    }
} 