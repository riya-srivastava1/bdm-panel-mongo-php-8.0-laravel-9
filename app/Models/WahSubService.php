<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class WahSubService extends Eloquent
{
    protected $path = "uploads/wah/sub-service/";
    protected $fillable = [
        'wah_service_id',
        'name',
        'image',
        'duration',
        'summery',
    ];

    public function service()
    {
        return $this->belongsTo(WahService::class, 'wah_service_id')->with('category');
    }
    public function category()
    {
        return $this->service()->category;
    }


    public function price()
    {
        return $this->hasMany(WahServicePrice::class);
    }

    public function getImageAttribute($file)
    {
        return $this->path . $file;
    }
}
