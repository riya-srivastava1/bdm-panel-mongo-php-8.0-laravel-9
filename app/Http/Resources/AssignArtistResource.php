<?php

namespace App\Http\Resources;

use App\Http\Controllers\TraitClass\DistanceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignArtistResource extends JsonResource
{
    use DistanceTrait;

    public static $lng;
    public static $lat;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // -----------
        $lat1 = doubleval($this->coordinates['coordinates'][1]);
        $lng1 = doubleval($this->coordinates['coordinates'][0]);
        $lat2 = doubleval(self::$lat);
        $lng2 = doubleval(self::$lng);
        $dist = $this->getDistanceWithLatLng($lat1, $lng1, $lat2, $lng2, 'K');
        $distance = $dist > 1000 ? number_format($dist / 1000, 2, '.', '') . ' km' : number_format($dist, 2) . ' m';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'steps' => $this->steps,
            'image' =>  $this->image ? cdn($this->image) : '',
            'gender' => $this->gender,
            'address' => $this->address,
            'device_token' => $this->device_token,
            'status' => $this->status,
            'is_booking_accepted' => $this->is_booking_accepted,
            'active_status_label' => $this->status && $this->is_booking_accepted ? 'active' : 'in-active',
            'distance' => $distance,
            'a_lat' => doubleval($this->coordinates['coordinates'][1]),
            'a_lng' => doubleval($this->coordinates['coordinates'][0]),
            'lat' => self::$lat,
            'lng' => self::$lng,
        ];
    }
}
