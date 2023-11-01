<?php

namespace App\Http\Controllers;

use App\Models\WahService;
use Illuminate\Http\Request;
use App\Models\WahSubService;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\TraitClass\SMSTrait;
use App\Http\Controllers\TraitClass\FileUploadTrait;

class WahSubServiceController extends Controller
{
    use FileUploadTrait;

    public $path;

    public function __construct()
    {
        $this->path = 'zoylee/uploads/wah/sub-service/';
    }

    public function index(Request $request)
    {
        $isEdit = false;
        $services = WahService::with('category')->get();
        $subServices  = (new WahSubService())->newQuery();

        if (!empty($request->search)) {
            $subServices->where('name', 'like', '%' . trim($request->search) . '%');
        }
        if (!empty($request->gender)) {
            // return $subServices->with('service')->paginate(2);
            $subServices->whereHas('service.category', function (Builder $query) use ($request) {
                $query->whereGender($request->gender);
            });
        }

        if (!empty($request->service)) {
            $subServices->where('wah_service_id', $request->service);
        }
        $subServices = $subServices->orderByDesc('created_at')->paginate(30);
        return view('wah.sub-service', compact(['isEdit', 'services', 'subServices']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wah_service_id' => 'required',
            'name' => 'required',
            'duration' => 'required',
            'image' => 'required|max:200|mimes:png,jpg,webp'
        ]);
        $subService = new WahSubService;

        if ($file = $request->file('image')) {
            if ($this->doFileUpload($this->path, $file)) {
                $subService->image = $request->file('image')->hashName();
            }
        }
        $subService->name = $request->name;
        $subService->wah_service_id = $request->wah_service_id;
        $subService->summery = array_filter(preg_split('/\r\n|[\r\n]/', $request->summery));
        $subService->duration = intval($request->duration);
        if ($subService->save()) {
            return redirect()->route('wah.sub.services', '#add_edit_service')->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went worng!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wah_service_id' => 'required',
            'name' => 'required',
            'duration' => 'required',
        ]);
        $subService =  WahSubService::findOrFail($id);
        $old_img = $subService->image;
        if ($file = $request->file('image')) {
            $request->validate(['image' => 'required|max:200|mimes:png,jpg,webp']);
            if ($this->doFileUpload($this->path, $file)) {
                $subService->image = $request->file('image')->hashName();
                $this->doFileUnlink('zoylee/' . $old_img);
            }
        }
        $subService->name = $request->name;
        $subService->wah_service_id = $request->wah_service_id;
        $subService->summery = array_filter(preg_split('/\r\n|[\r\n]/', $request->summery));
        $subService->duration = intval($request->duration);
        if ($subService->save()) {
            return redirect()->route('wah.sub.services')->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went worng!');
    }

    public function edit($id)
    {
        $editSubService = WahSubService::findOrFail($id);
        $isEdit = true;
        $services = WahService::with('category')->get();
        $subServices = WahSubService::orderByDesc('created_at')->paginate(10);

        return view('wah.sub-service', compact(['editSubService', 'isEdit', 'services', 'subServices']));
    }

    public function delete($id)
    {
        $subService = WahSubService::findOrFail($id);
        $subService->price()->delete();
        $this->doFileUnlink('zoylee/' . $subService->image);
        if ($subService->delete()) {
            return redirect()->route('wah.sub.services')->with('success', 'Successfully Deleted');
        }
        return back()->with('error', 'Something went worng!');
    }
}
