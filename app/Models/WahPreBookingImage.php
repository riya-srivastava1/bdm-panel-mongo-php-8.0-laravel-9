<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class WahPreBookingImage extends Model
{
    protected $imagePath = '/uploads/wah/pre-service-image/';

    protected $fillable = [
        'wah_artist_id',
        'order_id',
        'first_image',
        'second_image',
        'third_image',
        'image_count',
    ];


    public function getFirstImageAttribute($file)
    {
        return $this->imagePath . $file;
    }

    public function getSecondImageAttribute($file)
    {
        return $this->imagePath . $file;
    }

    public function getThirdImageAttribute($file)
    {
        return $this->imagePath . $file;
    }
}
