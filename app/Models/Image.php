<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'plant_id',
        'path',
        'title',
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
    
}
