<?php

namespace App\Http\Controllers\MaqamExp;

use App\Http\Controllers\Controller;
use App\Models\MaqamEx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaqamExperienceController extends Controller
{
    public function showAddMaqamExp()
    {
        return view('maqam_experience.add_maqam_experience');
    }

    public function saveMaqamExp(Request $request)
    {
        $request->validate([
            'detail' => 'required|string',
            'description' => 'required|string',
            'videoLink' => 'required|string',
            'thumbnail' => 'required|mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $imageName = time() . '.' . $request->thumbnail->extension();
        $request->thumbnail->move(public_path('maqamExpImages'), $imageName);

        $experience = new MaqamEx();
        $experience->detail = $request['detail'];
        $experience->description = $request['description'];
        $experience->videoLink = $request['videoLink'];
        $experience->thumbnail = $imageName;


        // Attempt to save the advert to the database
        if (!$experience->save()) {
            // Handle database save failure
            return redirect()->back()->with('error', 'Failed to save experience.');
        }

        return redirect()->back()->with('success', 'New experience successfully');
    }

    public function showMaqamExperiences()
    {
        $maqamExp = DB::table('maqam_exes')->orderBy('created_at', 'desc')->get();
        return view('maqam_experience.maqam_experience_list', ['maqamExp' => $maqamExp]);
    }

    public function displayMaqamDetails(Request $request)
    {
        $expId = $request->expId;

        $exp = DB::table('maqam_exes')->find($expId);

        if (!$exp) {
            return redirect()->back()->with('error', 'Maqam Experiece not found');
        } else {
            return view('maqam_experience.edit_maqam_exp', ['exp' => $exp]);
        }
    }

    public function updateMaqamExperience(Request $request)
    {
        $request->validate([
            'detail' => 'required|string',
            'description' => 'required|string',
            'videoLink' => 'string',
            'thumbnail' => 'mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $id = $request->id;

        $maqamExp = MaqamEx::find($id);

        if (!$maqamExp) {
            return redirect()->back()->with('error', 'maqamExp not found');
        } else {

            $maqamExp->detail = $request['detail'];
            $maqamExp->description = $request['description'];
            $maqamExp->videoLink = $request['videoLink'];

            // Check if a new image is uploaded
            if ($request->hasFile('thumbnail')) {
                // Delete old image
                if ($maqamExp->thumbnail) {
                    unlink(public_path('maqamExpImages/' . $maqamExp->thumbnail));
                }

                // Store new image
                $imageName = time() . '.' . $request->thumbnail->extension();
                $maqamExp->thumbnail = $imageName;
                $request->thumbnail->move(public_path('maqamExpImages'), $imageName);
            }

            $maqamExp->save();

            return redirect('/maqam-experience-list')->with('success', 'Maqam Experience updated successfully');
        }
    }

    public function showDeletePage(Request $request)
    {
        $expId = $request->expId;

        $Mexperience = MaqamEx::find($expId);

        return view('maqam_experience.delete_maqam_exp', ['Mexperience' => $Mexperience]);
    }

    public function deleteMaqamExperience(Request $request)
    {
        $id = $request->expId;

        $experience = MaqamEx::find($id);

        if (!$experience) {
            return redirect()->back()->with('error', 'Maqam Experience not found');
        } else {
            // Delete the experience's image if it exists
            if ($experience->thumbnail) {
                unlink(public_path('maqamExpImages/' . $experience->thumbnail));
            }

            // Delete the experience from the databases
            $experience->delete();

            return redirect('/maqam-experience-list')->with('success', 'Maqam Experience deleted successfully');
        }
    }
}
