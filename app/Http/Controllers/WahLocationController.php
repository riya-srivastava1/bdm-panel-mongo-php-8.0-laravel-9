<?php

namespace App\Http\Controllers;

use App\Http\Requests\WahLocationRequest;
use App\Models\WahLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WahLocationController extends Controller
{
    public function index()
    {
        $location = WahLocation::orderByDesc('created_at')->get();
        $isEdit = false;
        return view('wah.location', compact(['isEdit', 'location']));
    }


    private function saveLocation($request, $location)
    {
        $location->city = $request->city;
        $location->lat = doubleval($request->lat);
        $location->lng = doubleval($request->lng);
        $location->zipcode = $request->zipcode;
        $location->map_place_id = $request->map_place_id;
        $location->address = $request->address;
        $location->coordinates = ['type' => 'Point', 'coordinates' => [doubleval($request->lng), doubleval($request->lat)]];
        return $location->save();
    }


    public function store(WahLocationRequest $request)
    {
        $request->validate(['city' => 'required|unique:wah_locations']);
        $location = new WahLocation();

        if ($this->saveLocation($request, $location)) {
            return back()->with('success', 'Successfully updated');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function edit($id)
    {
        $editLocation = WahLocation::findOrFail($id);
        $location = WahLocation::orderByDesc('created_at')->get();
        $isEdit = true;
        return view('wah.location', compact(['isEdit', 'location', 'editLocation']));
    }

    public function update(WahLocationRequest $request, $id)
    {
        $request->validate(['city' => 'required|' . Rule::unique('wah_locations')->ignore($id, '_id')]);

        $location = WahLocation::findOrFail($id);

        if ($this->saveLocation($request, $location)) {
            return redirect()->route('wah.location')->with('success', 'Successfully updated');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function delete($id)
    {
        if (WahLocation::destroy($id)) {
            return redirect()->route('wah.location')->with('success', 'Successfully Deleted');
        }
        return back()->with('error', 'Something went wrong!');
    }
}
