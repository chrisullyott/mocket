<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemMeta;
use App\ItemDataProvider;

class Item extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['meta'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'url', 'is_favorite'];

    /**
     * Get the meta record associated with this item.
     */
    public function meta()
    {
        return $this->hasOne('App\ItemMeta');
    }

    /**
     * Get this item's routable path.
     */
    public function path()
    {
        return "/item/{$this->id}";
    }

    /**
     * Delete this model and the child models.
     *
     * @return void
     */
    public function delete()
    {
        $this->meta->delete();
        parent::delete();
    }

    /**
     * Create a new Item from data.
     *
     * @return Item
     */
    public static function create(array $attributes = [])
    {
        // Create Item.
        $item = static::query()->create($attributes);

        // Create ItemMeta.
        $meta = new ItemMeta();
        $provider = new ItemDataProvider($item->url);
        $meta->fill($provider->getData());
        $item->meta()->save($meta);

        return $item;
    }
}
