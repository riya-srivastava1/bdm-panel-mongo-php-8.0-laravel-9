<?php

namespace App\Http\Controllers;

use App\WahService;
use Illuminate\Http\Request;
use App\Models\WahSubService;
use App\Models\WahServicePrice;
use App\Http\Requests\WahServicePriceRequest;
use App\Http\Resources\WahSubServiceResource;

class WahServicePriceController extends Controller
{
    public function index($wah_sub_service_id)
    {
        $isEdit = false;
        $subService = WahSubService::findOrFail($wah_sub_service_id);
        $prices = WahServicePrice::where('wah_sub_service_id', $wah_sub_service_id)
            ->get();

        return view('wah.service-price', compact(['isEdit', 'prices', 'subService']));
    }


    private function priceSave($request, $servicePrice)
    {
        $servicePrice->wah_sub_service_id = $request->wah_sub_service_id;
        $servicePrice->location = $request->location;
        $servicePrice->list_price = intval($request->list_price);
        $servicePrice->zoylee_product_charge = intval($request->zoylee_product_charge);
        $servicePrice->artist_price = doubleval($request->artist_price);
        return $servicePrice->save();
    }
    public function store(WahServicePriceRequest $request)
    {
        if (WahServicePrice::where('wah_sub_service_id', $request->wah_sub_service_id)->where('location', $request->location)->count()) {
            return back()->with('error', 'Please add different location price');
        }

        if ($this->priceSave($request, new WahServicePrice())) {
            return back()->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function edit($id)
    {
        $editServicePrice = WahServicePrice::findOrFail($id);
        $isEdit = true;
        $subService = WahSubService::findOrFail($editServicePrice->wah_sub_service_id);
        $prices = WahServicePrice::where('wah_sub_service_id', $editServicePrice->wah_sub_service_id)
            ->get();

        return view('wah.service-price', compact(['isEdit', 'prices', 'subService', 'editServicePrice']));
    }

    public function update(WahServicePriceRequest $request, $id)
    {

        $servicePrice = WahServicePrice::findOrFail($id);
        if (WahServicePrice::where('wah_sub_service_id', $request->wah_sub_service_id)
            ->where('_id', '!=', $id)
            ->where('location', $request->location)
            ->count()
        ) {
            return back()->with('error', 'Please add different location price');
        }

        if ($this->priceSave($request, $servicePrice)) {
            return redirect()->route('wah.service.price', $request->wah_sub_service_id)->with('success', 'Successfully Updated');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function delete($id)
    {
        if (WahServicePrice::destroy($id)) {
            return back()->with('success', 'Successfully Deleted');
        }
        return back()->with('error', 'Something went wrong!');
    }
}
