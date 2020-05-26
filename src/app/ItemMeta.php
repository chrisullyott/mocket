<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMeta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['host', 'site_name', 'title', 'description', 'image_url'];

    /**
     * Get the item record associated with this meta.
     */
    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    /**
     * Get a shortened version of the host.
     *
     * @return string
     */
    public function getShortHostAttribute()
    {
        return str_replace('www.', '', $this->host);
    }

    /**
     * Get the title attribute, decoded.
     *
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }

    /**
     * Get the description attribute, decoded.
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }
}
