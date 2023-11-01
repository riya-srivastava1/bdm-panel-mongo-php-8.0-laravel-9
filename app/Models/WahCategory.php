<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WahCategory extends Eloquent
{
    protected $path = "uploads/wah/category/";

    protected $fillable = [
        'name',
        'icon',
        'gender',
        'status'
    ];

    public function getIconAttribute($file)
    {
        return $this->path . $file;
    }

    public function services()
    {
        return $this->hasMany(WahService::class);
    }
}
