<?php

namespace App\Http\Controllers\Adverts;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertController extends Controller
{
    public function showAdverts()
    {
        $adverts = DB::table('adverts')->orderBy('created_at', 'desc')->paginate(10);
        return view('adverts.adverts_list', ['adverts' => $adverts]);
    }

    public function showAddAdvert()
    {
        return view('adverts.add_advert');
    }

    public function addNewAdvert(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'endDateTime' => 'required|date_format:Y-m-d\TH:i|after:now',
            'image' => 'required|mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('advertImages'), $imageName);

        $advert = new Advert();
        $advert->title = $request['title'];
        $advert->description = $request['description'];
        $advert->endDateTime = $request['endDateTime'];
        $advert->image = $imageName;


        // Attempt to save the advert to the database
        if (!$advert->save()) {
            // Handle database save failure
            return redirect()->back()->with('error', 'Failed to save advert.');
        }

        return redirect()->back()->with('success', 'New advert Saved successfully');
    }

    public function viewAdvertDetail(Request $request)
    {
        $advertId = $request->advertId;

        $advert = DB::table('adverts')->find($advertId);

        if (!$advert) {
            return redirect()->back()->with('error', 'Advert not found');
        } else {
            return view('adverts.edit_advert', ['advert' => $advert]);
        }
    }

    public function updateAdvert(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'endDateTime' => 'required',
            'image' => 'mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $id = $request->id;

        $advert = Advert::find($id);

        if (!$advert) {
            return redirect()->back()->with('error', 'Advert not found');
        } else {

            $advert->title = $request['title'];
            $advert->description = $request['description'];
            $advert->endDateTime = $request['endDateTime'];

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($advert->image) {
                    unlink(public_path('advertImages/' . $advert->image));
                }

                // Store new image
                $imageName = time() . '.' . $request->image->extension();
                $advert->image = $imageName;
                $request->image->move(public_path('advertImages'), $imageName);
            }

            $advert->save();

            return redirect('/view-adverts')->with('success', 'Advert updated successfully');
        }
    }

    public function showDeletePage(Request $request)
    {
        $id = $request->advertId;

        $advert = Advert::find($id);

        return view('adverts.delete_advert', ['advert' => $advert]);
    }

    public function deleteAdvert(Request $request)
    {
        $id = $request->advertId;

        $advert = Advert::find($id);

        if (!$advert) {
            return redirect()->back()->with('error', 'Advert not found');
        } else {
            // Delete the advert's image if it exists
            if ($advert->image) {
                unlink(public_path('advertImages/' . $advert->image));
            }

            // Delete the advert from the databases
            $advert->delete();

            return redirect('/view-adverts')->with('success', 'Advert deleted successfully');
        }
    }
}
