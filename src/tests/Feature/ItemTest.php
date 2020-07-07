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
     * Data for a test item.
     *
     * @var array
     */
    private static $itemData = [
        'user_id' => 1,
        'url' => 'https://laravel.com/docs/7.x'
    ];

    /**
     * Run test setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * @test An item can be added to the database.
     * @return void
     */
    public function item_can_be_added(): void
    {
        $item = Item::create(static::$itemData);

        $this->assertTrue($item->exists);
    }

    /**
     * @test An item can be deleted from the database.
     * @return void
     */
    public function item_can_be_deleted(): void
    {
        $item = Item::create(static::$itemData);
        $item->delete();

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }
}
