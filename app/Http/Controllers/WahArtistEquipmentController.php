<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\WahArtistEquipment;

class WahArtistEquipmentController extends Controller
{
    public function index()
    {
        $equipments = WahArtistEquipment::orderByDesc('created_at')->paginate(20);
        $isEdit = false;
        return view('wah.equipment', compact(['equipments', 'isEdit']));
    }

    private function saveEquip($request, $equip)
    {
        $equip->name = $request->name;
        return $equip->save();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:wah_artist_equipment']);
        if ($this->saveEquip($request, new WahArtistEquipment())) {
            return back()->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went wrong');
    }

    public function edit($id)
    {
        $editEquipment = WahArtistEquipment::findOrFail($id);
        $isEdit = true;
        $equipments = WahArtistEquipment::orderByDesc('created_at')->paginate(20);
        return view('wah.equipment', compact(['editEquipment', 'isEdit', 'equipments']));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => ['required', Rule::unique('wah_artist_equipment')->ignore($id, '_id')]]);

        if ($this->saveEquip($request, WahArtistEquipment::findOrFail($id))) {
            return redirect()->route('wah.equipment')->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went wrong');
    }

    public function delete($id)
    {
        if (WahArtistEquipment::destroy($id)) {
            return redirect()->route('wah.equipment')->with('success', 'Successfully deleted');
        }
        return back()->with('error', 'Something went wrong');
    }
}
