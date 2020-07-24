<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\ItemDataProvider;

class ItemDataProviderTest extends TestCase
{
    /**
     * A URL to test.
     * @var string
     */
    private static $url = 'http://chrisullyott.com/about';

    /**
     * Properties we need from a URL.
     * @var array
     */
    private static $requiredProps = [
        'host',
        'site_name',
        'title',
        'description',
        'image_url'
    ];

    /**
     * Properties that must not be empty.
     * @var array
     */
    private static $nonNullProps = [
        'host',
        'title'
    ];

    /**
     * @test Data is successfully fetched from a URL.
     */
    public function data_is_provided(): void
    {
        $provider = new ItemDataProvider(static::$url);
        $data = $provider->getData();

        foreach (static::$requiredProps as $prop) {
            $this->assertArrayHasKey($prop, $data);
        }

        foreach (static::$nonNullProps as $prop) {
            $this->assertNotEmpty($data[$prop]);
        }
    }
}
