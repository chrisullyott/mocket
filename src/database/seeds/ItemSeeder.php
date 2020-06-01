<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls = [
            'http://troels.arvin.dk/db/rdbms/',
            'https://blog.mint.com/how-to/identity-theft-protection/',
            'https://www.youtube.com/watch?v=tVooja0Ta5I'
            'https://laracasts.com/podcast/318183',
            'https://www.youtube.com/watch?v=WPoQfKQlOjg',
            'https://laracasts.com/series/testing-vue/episodes/2',
            'https://www.codeforamerica.org/work',
            'http://chrisullyott.com/help-the-amazon-rainforest',
            'https://www.ted.com/talks/brene_brown_the_power_of_vulnerability',
            'https://www.youtube.com/watch?v=IS62jMJDzgg#t=42m18s',

        ];

        // Turn on mass-assignment protection.
        Item::reguard();

        // Build an Item for each URL.
        foreach ($urls as $url) {
            Item::create([
                'user_id' => 1,
                'url' => $url,
                'is_favorite' => rand(0, 1)
            ]);
        }
    }
}
