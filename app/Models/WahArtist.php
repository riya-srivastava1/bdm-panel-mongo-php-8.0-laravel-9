<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class WahArtist extends Eloquent
{
    use SoftDeletes;

    protected $imagePath = '/uploads/wah/artist-profile/';
    protected $idProofPath = '/uploads/wah/artist-id-proof/';
    protected $cCPath = '/uploads/wah/covid-certificate/';
    protected $pVCPath = '/uploads/wah/police-verification-certificate/';
    protected $contract = '/uploads/wah/contract/';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'alternate_no',
        'password',
        'experience',
        'gender',
        'dob',

        'city',
        'address',
        'zipcode',
        'coordinates',
        'map_place_id',
        'addhar_no',

        'services',
        'equipments',

        'emergency_contact_number',
        'emergency_contact_name',
        'relation',
        'vehicle_registration_no',
        'vehicle_type',
        'qualification',

        'image',
        'qualification_certificate', //x
        'id_proof',
        'covid_certificate',
        'police_verification_certificate',
        'contract',

        'steps',
        'status',
        'is_booking_accepted',

        'is_block', // block column ...
        'block_type',
        'valid_till',
        'remark',

        'bank_name',
        'branch_name',
        'account_no',
        'account_holder_name',
        'ifsc_code',
        'kyc'
    ];



    // protected $casts = [
    //     'coordinates' => 'array',
    // ];


    public function getImageAttribute($file)
    {
        return $this->imagePath . $file;
    }
    public function getContractAttribute($file)
    {
        return $this->contract . $file;
    }

    public function getIdProofAttribute($file)
    {
        return $this->idProofPath . $file;
    }

    public function getCovidCertificateAttribute($file)
    {
        return $this->cCPath . $file;
    }

    public function getPoliceVerificationCertificateAttribute($file)
    {
        return $this->pVCPath . $file;
    }

    public function booking()
    {
        return $this->hasMany(UserBooking::class, 'wah_artist_id', '_id')->where('service_status', true);
    }

    public function artistComment()
    {
        return $this->hasOne(WahArtistComment::class, 'wah_artist_id', '_id');
    }
}
