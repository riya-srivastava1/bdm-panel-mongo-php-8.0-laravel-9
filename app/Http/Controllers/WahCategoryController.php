<?php

namespace App\Http\Controllers;

use App\Models\WahService;
use App\Models\WahCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\TraitClass\FileUploadTrait;

class WahCategoryController extends Controller
{
    use FileUploadTrait;
    protected $path;

    public function __construct()
    {
        $this->path = "zoylee/uploads/wah/category/";
    }

    public function index()
    {
        $isEdit = false;
        $category = WahCategory::orderByDesc('updated_at')->get();
        return view('wah.category', compact(['category', 'isEdit']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:wah_categories',
            'icon' => 'mimes:PNG,png,jpg,JPG,JPEG,jpeg,svg|max:50|required',
            'gender' => 'required'
        ]);

        $category = new WahCategory();

        if ($file = $request->file('icon')) {
            if ($this->doFileUpload($this->path, $file)) {
                $category->icon =  $request->file('icon')->hashName();
            }
        }
        $category->name = $request->name;
        $category->gender = $request->gender;
        $category->status = $request->true;

        if ($category->save()) {
            return back()->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went wrong');
    }

    public  function edit($id)
    {
        $editCategory = WahCategory::findOrFail($id);
        $isEdit = true;
        $category = WahCategory::orderByDesc('updated_at')->get();
        return view('wah.category', compact(['editCategory', 'category', 'isEdit']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gender' => 'required',
            'name' => "required|" . Rule::unique('wah_categories')->ignore($id, '_id')
        ]);
        $category = WahCategory::findOrFail($id);
        $old_icon = $category->icon;
        $category->name = $request->name;
        $category->gender = $request->gender;
        if ($file = $request->file('icon')) {
            $request->validate([
                'icon' => 'mimes:PNG,png,jpg,JPG,JPEG,jpeg,svg|max:50|required'
            ]);
            if ($this->doFileUpload($this->path, $file)) {
                $category->icon =  $request->file('icon')->hashName();
                $this->doFileUnlink('zoylee/' . $old_icon);
            }
        }
        if ($category->save()) {
            return redirect()->route('wah.category')->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went wrong');
    }

    public function delete($id)
    {
        $category = WahCategory::with('services')->findOrFail($id);
        foreach ($category->services as $service) {
            $this->doFileUnlink('zoylee/' . $service->image);
            $service->delete();
        }
        $this->doFileUnlink('zoylee/' . $category->icon);

        if ($category->delete()) {
            return redirect()->route('wah.category')->with('success', 'Successfully deleted');
        }
        return back()->with('error', 'Something went wrong');
    }
}
