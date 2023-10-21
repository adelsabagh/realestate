<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function AllAmenities() {
        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));
    } // End Method

    public function AddAmenities() {

        return view('backend.amenities.add_amenities');
    } // End Method

    public function StoreAmenities(Request $request) {

        Amenities::insert([
            'amenities_name' => $request->amenities_name,
        ]);

        $notification = array(
            'message' => 'Amenities Created Successfully!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.amenities')->with($notification);

    } // End Method

    public function EditAmenities($id) {

        $amenities = Amenities::findOrfail($id);
        return view('backend.amenities.edit_amenities', compact('amenities'));
    } // End Method

    public function UpdateAmenities(Request $request) {

        $ame_id = $request->id;

        Amenities::findOrfail($ame_id)->update([
            'amenities_name' => $request->amenities_name,
        ]);

        $notification = array(
            'message' => 'Amenities Updated Successfully!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.amenities')->with($notification);

    } // End Method

    public function DeleteAmenities($id) {

        Amenities::findOrfail($id)->delete();

        $notification = array(
            'message' => 'Property Type Deleted Successfully!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } // End Method
}
