<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TraitClass\FileUploadTrait;
use App\Models\WahCategory;
use App\Models\WahService;
use Illuminate\Http\Request;

class WahServiceController extends Controller
{
    use FileUploadTrait;
    public $path;

    public function __construct()
    {
        $this->path = "zoylee/uploads/wah/service/";
    }

    public function index()
    {
        $isEdit = false;
        $category = WahCategory::all();
        $services = WahService::with('category')
            ->orderByDesc('created_at')
            ->paginate(30);
        return view('wah.services', compact(['isEdit', 'category', 'services']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wah_category_id' => 'required',
            'name' => 'required',
            'image' => 'required|max:200|mimes:png,jpg,webp',
        ]);

        $service = new WahService();

        if ($file = $request->file('image')) {
            if ($this->doFileUpload($this->path, $file)) {
                $service->image = $request->file('image')->hashName();
            }
        }
        $service->wah_category_id = $request->wah_category_id;
        $service->name = $request->name;
        $service->status = true;
        $service->summery = trim($request->summery);
        if ($service->save()) {
            return back()->with('success', 'Successfully Updated');
        }

        return back()->with('error', 'Something went worng!');
    }

    public function edit($id)
    {
        $editService = WahService::findOrFail($id);
        $isEdit = true;
        $category = WahCategory::all();
        $services = WahService::with('category')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('wah.services', compact(['isEdit', 'editService', 'category', 'services']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wah_category_id' => 'required',
            'name' => 'required',

        ]);

        $service =  WahService::findOrFail($id);
        $old_image = $service->image;

        if ($file = $request->file('image')) {
            $request->validate(['image' => 'required|max:200|mimes:png,jpg,webp']);
            if ($this->doFileUpload($this->path, $file)) {
                $service->image = $request->file('image')->hashName();
                $this->doFileUnlink('zoylee/' . $old_image);
            }
        }
        $service->wah_category_id = $request->wah_category_id;
        $service->name = $request->name;
        $service->summery = trim($request->summery);
        if ($service->save()) {
            return redirect()->route('wah.service')->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went worng!');
    }

    public function delete($id)
    {
        $service = WahService::findOrFail($id);
        $this->doFileUnlink('zoylee/' . $service->image);
        if ($service->delete()) {
            return redirect()->route('wah.service')->with('success', 'Successfully deleted');
        }
        return back()->with('error', 'Something went wrong');
    }

    public function updatePS($id)
    {
        $data = WahService::findOrFail($id);
        $data->is_popular_service = !$data->is_popular_service;
        $data->save();
        return back();
    }
}
