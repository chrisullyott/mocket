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
            'https://blog.mint.com/how-to/identity-theft-protection/',
            'https://goinswriter.com/remarkable/',
            'https://michaelhyatt.com/how-to-beat-a-burnout-culture/',
            'https://www.youtube.com/watch?v=WPoQfKQlOjg',
            'https://www.codeforamerica.org/work',
            'http://chrisullyott.com/help-the-amazon-rainforest',
            'https://www.ted.com/talks/brene_brown_the_power_of_vulnerability'
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
