<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function showPackages()
    {
        $packages = DB::table('packages')->orderBy('created_at', 'desc')->get();
        return view('packages.packages_list', ['packages' => $packages]);
    }

    public function showAddPackage()
    {
        return view('packages.add_package');
    }

    public function addNewPackage(Request $request)
    {
        $package = new Package();

        $category = $request->category;
        $type = $request->type;
        $standardPrice = $request->standardPrice;
        $economyPrice = $request->economyPrice;
        $title = $request->title;
        $packageDescription = $request->packageDescription;
        $dateRange = $request->dateRange;
        $packageImage = $request->packageImage;
        $services = $request->services;
        $endDateTime = $request->endDateTime;

        $packageImageName = time() . '.' . $packageImage->extension();
        $packageImage->move(public_path('packageImages'), $packageImageName);


        $package->category = $category;
        $package->type = $type;
        $package->standardPrice = $standardPrice;
        $package->economyPrice = $economyPrice;
        $package->title = $title;
        $package->description = $packageDescription;
        $package->dateRange = $dateRange;
        $package->endDateTime = $endDateTime;
        $package->packageImage = $packageImageName;

        // Attempt to save the package to the database
        if (!$package->save()) {
            // Handle database save failure
            return redirect()->back()->with('error', 'Failed to save package.');
        }

        foreach ($services as $service) {
            if (isset($service['description']) && $service['description'] != null) {
                $packageServiceImageName = uniqid() . '_' . time() . '.' . $service['images']->extension();
                $service['images']->move(public_path('packageImages'), $packageServiceImageName);
                $newService = new Service();
                $newService->name = $service['name'];
                $newService->description = $service['description'];
                $newService->image = $packageServiceImageName;
                $newService->packageId = $package->id;
                $newService->save();
            }
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
            'description' => 'required',
            'dateRange' => 'required|string',
            'endDateTime' => 'required',
            'image' => 'mimes:jpeg,png,jpg,svg|max:1048',
        ]);

        $id = $request->id;

        $package = Package::find($id);

        if (!$package) {
            return redirect()->back()->with('error', 'Package not found');
        } else {

            $package->title = $request['title'];
            $package->description = $request['description'];
            $package->dateRange = $request['dateRange'];
            $package->endDateTime = $request['endDateTime'];

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($package->packageImage) {
                    unlink(public_path('packageImages/' . $package->packageImage));
                }

                // Store new image
                $imageName = time() . '.' . $request->image->extension();
                $package->packageImage = $imageName;
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

        $services = Service::where("packageId",  $package->id)->get();

        if (!$package) {
            return redirect()->back()->with('error', 'Package not found');
        } else {
            // Delete the package's image if it exists
            if ($package->packageImage) {
                unlink(public_path('packageImages/' . $package->packageImage));
            }
            foreach ($services as $service) {
                unlink(public_path('packageImages/' . $service->image));
                $service->delete();
            }

            // Delete the package from the database
            $package->delete();

            return redirect('/view-packages')->with('success', 'Package deleted successfully');
        }
    }
}
