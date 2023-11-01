<?php

namespace App\Http\Controllers;

use App\Models\WahArtist;
use App\Models\WahService;
use Illuminate\Http\Request;
use App\Mail\DeleteArtistMail;
use Illuminate\Validation\Rule;
use App\Models\WahArtistEquipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TraitClass\FileUploadTrait;

class WahArtistController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {
        $artists = (new WahArtist())->newQuery();
        // search=&status=active&iba=active&gender=male
        if ($request->has('status')) {
            $status = $request->status == 'active' ? true : false;
            $artists->where('status', $status);
        }
        if ($request->has('iba')) {
            $status = $request->iba == 'active' ? true : false;
            $artists->where('is_booking_accepted', $status);
        }
        if ($request->has('gender')) {
            $artists->where('gender', $request->gender);
        }
        if ($request->has('search') && !empty($request->search)) {
            // return WahArtist::where('name', 'like', '%' . trim($request->search) . '%')->get();
            $artists->orWhere('name', 'like', '%' . trim($request->search) . '%')
                ->orWhere('phone',  'like', '%' . trim($request->search) . '%')
                ->orWhere('city',  'like', '%' . trim($request->search) . '%');
        }
        $artists = $artists->orderByDesc('created_at')->paginate(50);

        $trashed_artist = [];
        if (Auth::guard('bdm')->user()->email == 'isaac@zoylee.com' || Auth::guard('bdm')->user()->email == 'deepak.sharma@zoylee.com') {
            $trashed_artist = WahArtist::onlyTrashed()->paginate(10);
        }
        return view('wah.artist', compact(['artists', 'trashed_artist']));
    }

    public function artistDetails($id)
    {
        $artist = WahArtist::findOrFail($id);
        return view('wah.artist-details', compact(['artist']));
    }

    public function createStepOne($id = null)
    {
        $artist = false;
        if ($id) {
            $artist = WahArtist::findOrFail($id);
        }
        $data = WahService::orderByDesc('created_at')->get();
        $collection = collect($data);
        $services = $collection->unique('name');
        $equips = WahArtistEquipment::all();
        return view('wah.create-artist-step-1', compact(['services', 'equips', 'artist']));
    }

    public function createStepTwo($id)
    {
        $artist = WahArtist::findOrFail($id);
        return view('wah.create-artist-step-2', compact(['artist']));
    }

    public function createStepThree($id)
    {
        $artist = WahArtist::findOrFail($id);
        return view('wah.create-artist-step-3', compact('artist'));
    }

    public function createStepFour($id)
    {
        $artist = WahArtist::findOrFail($id);
        return view('wah.create-artist-step-4', compact('artist'));
    }
    public function createStepFive($id)
    {
        $artist = WahArtist::findOrFail($id);
        return view('wah.create-artist-step-5', compact('artist'));
    }

    public function storeStepOne(Request $request)
    {

        $request->validate([
            'name' => 'required',
            // 'email' => 'required|unique:wah_artists',
            'phone' => 'required|unique:wah_artists|digits:10',
            // 'password' => 'required|min:6',
            'alternate_no' => 'required|digits:10',
            'experience' => 'required',
            'gender' => 'required',
            'services' => 'required',
            'equipments' => 'required',
        ]);
        $dbDate = \Carbon\Carbon::parse($request->dob);
        $diffYears = \Carbon\Carbon::now()->diffInYears($dbDate);
        if ($diffYears < 18) {
            return back()->with('error', 'Artist age must be grater than 18 year');
        }


        $artist = new WahArtist();
        $artist->name = $request->name;
        $artist->email = $request->email;
        $artist->phone = $request->phone;
        $artist->dob = date('Y-m-d', strtotime($request->dob));
        $artist->alternate_no = $request->alternate_no;
        $artist->experience = intval($request->experience);
        $artist->gender = $request->gender;
        $artist->services = $request->services;
        $artist->equipments = $request->equipments;
        $artist->password = Hash::make($request->password);
        $artist->steps = 1;
        if ($artist->save()) {
            return redirect()->route('wah.artist.create.step.two', $artist->id)->with('success', 'Update Successfully');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function storeStepOneUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => "required|digits:10" . Rule::unique('wah_artists')->ignore($id, '_id'),
            'alternate_no' => 'required|digits:10',
            'experience' => 'required',
            'gender' => 'required',
            'services' => 'required',
            'equipments' => 'required',
        ]);
        if (!empty($request->email)) {
            $request->validate(['email' => Rule::unique('wah_artists')->ignore($id, '_id')]);
        }
        $dbDate = \Carbon\Carbon::parse($request->dob);
        $diffYears = \Carbon\Carbon::now()->diffInYears($dbDate);
        if ($diffYears < 18) {
            return back()->with('error', 'Artist age must be grater than 18 year');
        }


        $artist =  WahArtist::findOrFail($id);
        $artist->name = $request->name;
        $artist->email = $request->email;
        $artist->phone = $request->phone;
        $artist->dob = date('Y-m-d', strtotime($request->dob));
        $artist->alternate_no = $request->alternate_no;
        $artist->experience = intval($request->experience);
        $artist->gender = $request->gender;
        $artist->services = $request->services;
        $artist->equipments = $request->equipments;
        if (!empty($request->password)) {
            $request->validate(['password' => 'required|min:6']);
            $artist->password = Hash::make($request->password);
        }
        if ($artist->save()) {
            return redirect()->route('wah.artist.create.step.two', $artist->id)->with('success', 'Update Successfully');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function storeStepTwo(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required',
            'lng' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
            'map_place_id' => 'required',
            'addhar_no' => 'required|digits:12',
        ]);

        $artist = WahArtist::findOrFail($id);
        $artist->city = $request->city;
        $artist->zipcode = $request->zipcode;
        $artist->map_place_id = $request->map_place_id;
        $artist->latest_map_place_id = $request->map_place_id;
        $artist->coordinates = ['type' => 'Point', 'coordinates' => [doubleval($request->lng), doubleval($request->lat)]];
        $artist->latest_coordinates = ['type' => 'Point', 'coordinates' => [doubleval($request->lng), doubleval($request->lat)]];
        $artist->address = $request->address;
        $artist->addhar_no = $request->addhar_no;
        $artist->steps = 2;
        if ($artist->save()) {
            return redirect()->route('wah.artist.create.step.three', $artist->id)->with('success', 'Update Successfully');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function storeStepThree(Request $request, $id)
    {
        $request->validate([
            'emergency_contact_number' => 'required',
            'emergency_contact_name' => 'required',
            'relation' => 'required',
            // 'vehicle_registration_no' => 'required',
            'vehicle_type' => 'required',
            'qualification' => 'required',
        ]);

        $artist = WahArtist::findOrFail($id);
        if ($artist->phone == $request->emergency_contact_number) {
            return back()->with('error', 'Phone and Emergency contact number can not be same.');
        }
        $artist->emergency_contact_number = $request->emergency_contact_number;
        $artist->emergency_contact_name = $request->emergency_contact_name;
        $artist->relation = $request->relation;
        $artist->vehicle_registration_no = $request->vehicle_registration_no;
        $artist->vehicle_type = $request->vehicle_type;
        $artist->qualification = $request->qualification;
        $artist->steps = 3;

        if ($artist->save()) {
            return redirect()->route('wah.artist.create.step.four', $artist->id)->with('success', 'Update Successfully');
        }

        return back()->with('error', 'Something went wrong!');
    }

    private function getFileName($image)
    {
        list($type, $file) = explode(';', $image);
        list(, $extension) = explode('/', $type);
        list(, $file) = explode(',', $file);
        $result['file'] = $file;
        return $result;
    }

    public function artistProfile(Request $request, $id)
    {
        $request->validate(['image' => 'required|max:200']);

        $path = 'zoylee/uploads/wah/artist-profile/';
        $artist = WahArtist::findOrFail($id);
        if ($file = $request->file('image')) {
            $old_img = $artist->image;
            $artist->image = $request->file('image')->hashName();
            if ($this->doFileUpload($path, $file)) {
                if (strpos($old_img, '.')) {
                    $this->doFileUnlink('zoylee' . $old_img);
                }
                $artist->save();
                return back()->with('success', 'Successfully Updated');
            }
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function uploadIdProof(Request $request, $id)
    {
        $request->validate(['id_proof' => 'required|mimes:png,jpg,pdf|max:1024']);
        $path = 'zoylee/uploads/wah/artist-id-proof/';
        $artist = WahArtist::findOrFail($id);

        if ($file = $request->file('id_proof')) {
            $old_img = $artist->id_proof;
            $artist->id_proof = $request->file('id_proof')->hashName();
            if ($this->doFileUpload($path, $file)) {
                if (strpos($old_img, '.')) {
                    $this->doFileUnlink('zoylee' . $old_img);
                }
                $artist->save();
                return back()->with('success', 'Successfully Updated');
            }
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function uploadCovidCertificate(Request $request, $id)
    {
        $request->validate(['covid_certificate' => 'required|mimes:png,jpg,pdf|max:1024']);
        $path = 'zoylee/uploads/wah/covid-certificate/';
        $artist = WahArtist::findOrFail($id);

        if ($file = $request->file('covid_certificate')) {
            $old_img = $artist->covid_certificate;
            $artist->covid_certificate = $request->file('covid_certificate')->hashName();
            if ($this->doFileUpload($path, $file)) {
                if (strpos($old_img, '.')) {
                    $this->doFileUnlink('zoylee' . $old_img);
                }
                $artist->save();
                return back()->with('success', 'Successfully Updated');
            }
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function uploadPoliceVerification(Request $request, $id)
    {
        $request->validate(['police_verification_certificate' => 'required|mimes:png,jpg,pdf|max:1024']);
        $path = 'zoylee/uploads/wah/police-verification-certificate/';
        $artist = WahArtist::findOrFail($id);

        if ($file = $request->file('police_verification_certificate')) {
            $old_img = $artist->police_verification_certificate;
            $artist->police_verification_certificate = $request->file('police_verification_certificate')->hashName();
            $artist->steps = 4;
            if ($this->doFileUpload($path, $file)) {
                if (strpos($old_img, '.')) {
                    $this->doFileUnlink('zoylee' . $old_img);
                }
                $artist->save();
                return back()->with('success', 'Successfully Updated');
            }
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function uploadContract(Request $request, $id)
    {
        $request->validate(['contract' => 'required|mimes:png,jpg,pdf|max:1024']);
        $path = 'zoylee/uploads/wah/contract/';
        $artist = WahArtist::findOrFail($id);

        if ($file = $request->file('contract')) {
            $old_img = $artist->contract;
            $artist->contract = $request->file('contract')->hashName();
            $artist->steps = 4;
            if ($this->doFileUpload($path, $file)) {
                if (strpos($old_img, '.')) {
                    $this->doFileUnlink('zoylee' . $old_img);
                }
                $artist->save();
                return back()->with('success', 'Successfully Updated');
            }
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function updateBankInfoStep5(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required',
            'branch_name' => 'required',
            'account_no' => 'required',
            'account_holder_name' => 'required',
            'ifsc_code' => 'required',
        ]);

        $artist = WahArtist::findOrFail($id);

        $artist->bank_name = $request->bank_name;
        $artist->branch_name = $request->branch_name;
        $artist->account_no = $request->account_no;
        $artist->account_holder_name = $request->account_holder_name;
        $artist->ifsc_code = $request->ifsc_code;
        $artist->kyc = $request->kyc;
        $artist->steps = 5;

        if ($artist->save()) {
            return back()->with('success', 'Update Successfully');
            return redirect()->route('wah.artist.details', $artist->id)->with('success', 'Update Successfully');
        }

        return back()->with('error', 'Something went wrong!');
    }


    public function updateArtistStatus($id)
    {
        $findArtist = WahArtist::findOrFail($id);
        $findArtist->status = !$findArtist->status;
        $findArtist->save();
        return back()->with('success', 'Successfully Updated');
    }
    public function updateArtistIsBookingStatus($id)
    {
        $findArtist = WahArtist::findOrFail($id);
        $findArtist->is_booking_accepted = !$findArtist->is_booking_accepted;
        $findArtist->save();
        return back()->with('success', 'Successfully Updated');
    }

    public function softDelete($id)
    {
        $artist = WahArtist::where('_id', $id)->first();
        $artist->status = false;
        $artist->save();

        $artist = WahArtist::findOrFail($id);
        // $this->doFileUnlink('zoylee' . $artist->image);
        // $this->doFileUnlink('zoylee' . $artist->id_proof);
        // $this->doFileUnlink('zoylee' . $artist->covid_certificate);
        // $this->doFileUnlink('zoylee' . $artist->police_verification_certificate);
        // 'ajay@zoylee.com',
        // Mail::to('isaac@zoylee.com')
        //     ->cc(['vishal@zoylee.com', 'vijaya@zoylee.com', 'bikash@zoylee.com'])
        //     ->send(new DeleteArtistMail($artist));

        $artist->delete();
        return back()->with('success', 'Successfully Deleted');
    }

    public function restore($id)
    {
        WahArtist::withTrashed()->find($id)->restore();
        return back()->with('success', 'Successfully Re Stored');
    }

    public function delete($id)
    {
        $artist = WahArtist::withTrashed()->find($id);
        $this->doFileUnlink('zoylee' . $artist->image);
        $this->doFileUnlink('zoylee' . $artist->id_proof);
        $this->doFileUnlink('zoylee' . $artist->covid_certificate);
        $this->doFileUnlink('zoylee' . $artist->police_verification_certificate);
        // Mail::to('isaac@zoylee.com')
        //     ->cc(['vishal@zoylee.com', 'ajay@zoylee.com', 'vijaya@zoylee.com', 'bikash@zoylee.com'])
        //     ->send(new DeleteArtistMail($artist));
        $artist->forceDelete();
        return back()->with('success', 'Successfully Deleted');

        // Product::onlyTrashed()->where('deleted_at', '<', Carbon::subDays(30))->forceDelete();
    }
}
