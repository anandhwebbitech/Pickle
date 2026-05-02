<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComboOffer extends Model
{
    //
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(ComboOfferItem::class);
    }
}
