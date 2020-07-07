<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Item;
use UserSeeder;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run test setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * An item can be added to the database.
     *
     * @return void
     */
    public function testAnItemCanBeAdded(): void
    {
        $url = 'https://laravel.com/docs/7.x';
        $item = Item::create(['user_id' => 1, 'url' => $url]);

        $this->assertTrue($item->exists);
    }

    /**
     * An item can be deleted from the database.
     *
     * @return void
     */
    public function testAnItemCanBeDeleted(): void
    {
        $url = 'https://laravel.com/docs/7.x';
        $item = Item::create(['user_id' => 1, 'url' => $url]);
        $item->delete();

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }
}
