<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class WahService extends Eloquent
{
    protected $path = "uploads/wah/service/";

    protected $fillable = [
        'wah_category_id',
        'name',
        'image',
        'summery',
        'status',
        'is_popular_service'
    ];

    public function getImageAttribute($file)
    {
        return $this->path . $file;
    }

    public function category()
    {
        return $this->belongsTo(WahCategory::class, 'wah_category_id');
    }
}
