<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    public function AllProperty() {
        $property = Property::latest()->get();
        return view('backend.property.all_property', compact('property'));
    } // End Method

    public function AddProperty() {

        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.add_property', compact('propertyType', 'amenities', 'activeAgent'));
    } // End Method

    public function StoreProperty(Request $request) {

        $amenities = $request->amenities_id;
        $amenities = implode(",", $amenities);

        $pcode = IdGenerator::generate(['table'=> 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);

        $image = $request->file('property_thumbnail');
        $thumbnail_name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$thumbnail_name_gen);
        $thumbnail_url = 'upload/property/thumbnail/'.$thumbnail_name_gen;

            $property_id = Property::insertGetId([
                'ptype_id' => $request->ptype_id,
                'amenities_id' => $amenities,
                'property_name' => $request->property_name,
                'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
                'property_code' => $pcode,
                'property_status' => $request->property_status,

                'lowest_price' => $request->lowest_price,
                'max_price' => $request->max_price,

                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,

                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'garage' => $request->garage,
                'garage_size' => $request->garage_size,
                'property_size' => $request->property_size,
                'property_video' => $request->property_video,

                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'neighborhood' => $request->neighborhood,

                'latitude' => $request->latitude,
                'longitude' => $request->longitude,

                'featured' => $request->featured,
                'hot' => $request->hot,

                'agent_id' => $request->agent_id,
                'status' => 1,
                'property_thumbnail' => $thumbnail_url,

                'created_at' => Carbon::now(),
            ]);

            /// Multiple Image Upload From Here ///

        $images = $request->file('multi_img');
        foreach ($images as $image) {
            $multiImg_name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(770, 520)->save('upload/property/multi-image/'.$multiImg_name_gen);
            $multiImg_url = 'upload/property/multi-image/'.$multiImg_name_gen;
            MultiImage::insert([
                'property_id' => $property_id,
                'photo_name' => $multiImg_url,
                'created_at' => Carbon::now(),
            ]);
        } // End Foreach

        /// End Multiple Image Upload From Here ///

        /// Facility Add From Here ///

        $facilities = Count($request->facility_name);
        if ($facilities != NULL) {
            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount-> property_id = $property_id;
                $fcount-> facility_name = $request->facility_name[$i];
                $fcount-> distance = $request->distance[$i];
                $fcount->save();
            }
        }

        /// End Facility Add From Here ///

        $notification = array(
            'message' => 'Property Inserted Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);
    } // End Method
}
