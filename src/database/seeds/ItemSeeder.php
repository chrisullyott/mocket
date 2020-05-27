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
            'https://www.youtube.com/watch?v=IS62jMJDzgg#t=42m18s',
            'https://www.codeforamerica.org/work',
            'https://www.youtube.com/watch?v=WPoQfKQlOjg',
            'https://laracasts.com/podcast/318183'
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