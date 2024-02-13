<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function showPackages()
    {
        $packages = DB::table('packages')->orderBy('created_at', 'desc')->paginate(10);
        return view('packages.packages_list', ['packages' => $packages]);
    }

    public function showAddPackage()
    {
        return view('packages.add_package');
    }

    public function addNewPackage(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'dateRange' => 'required|string',
            'price' => 'required|string',
            'endDateTime' => 'required|date_format:Y-m-d\TH:i|after:now',
            'image' => 'required|mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('packageImages'), $imageName);

        $package = new Package();
        $package->title = $request['title'];
        $package->dateRange = $request['dateRange'];
        $package->price = $request['price'];
        $package->endDateTime = $request['endDateTime'];
        $package->image = $imageName;


        // Attempt to save the package to the database
        if (!$package->save()) {
            // Handle database save failure
            return redirect()->back()->with('error', 'Failed to save package.');
        }

        return redirect()->back()->with('success', 'New package Saved successfully');
    }

    public function viewPackageDetail(Request $request)
    {
        $packageId = $request->packageId;

        $package = DB::table('packages')->find($packageId);

        if (!$package) {
            return redirect()->back()->with('error', 'Package not found');
        } else {
            return view('packages.edit_package', ['package' => $package]);
        }
    }

    public function updatePackage(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'dateRange' => 'required|string',
            'price' => 'required|string',
            'endDateTime' => 'required',
            'image' => 'mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $id = $request->id;

        $package = Package::find($id);

        if (!$package) {
            return redirect()->back()->with('error', 'Package not found');
        } else {

            $package->title = $request['title'];
            $package->dateRange = $request['dateRange'];
            $package->endDateTime = $request['endDateTime'];
            $package->price = $request['price'];

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($package->image) {
                    unlink(public_path('packageImages/' . $package->image));
                }

                // Store new image
                $imageName = time() . '.' . $request->image->extension();
                $package->image = $imageName;
                $request->image->move(public_path('packageImages'), $imageName);
            }

            $package->save();

            return redirect('/view-packages')->with('success', 'package updated successfully');
        }
    }

    public function showDeletePackagePage(Request $request)
    {
        $id = $request->packageId;

        $package = Package::find($id);

        return view('packages.delete_package', ['package' => $package]);
    }

    public function deletePackage(Request $request)
    {
        $id = $request->packageId;

        $package = Package::find($id);

        if (!$package) {
            return redirect()->back()->with('error', 'Package not found');
        } else {
            // Delete the package's image if it exists
            if ($package->image) {
                unlink(public_path('packageImages/' . $package->image));
            }

            // Delete the package from the database
            $package->delete();

            return redirect('/view-packages')->with('success', 'Package deleted successfully');
        }
    }
}
