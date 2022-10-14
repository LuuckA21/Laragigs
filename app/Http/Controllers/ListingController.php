<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show al listings
    public function index()
    {
        return view('listings.index', [
            "listings" => Listing::latest()->filter(request(["tag", "search"]))->paginate(6)
        ]);
    }

    // Show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            "listing" => $listing
        ]);
    }

    // Show Create form
    public function create()
    {
        return view("listings.create");
    }

    // Store Listing Data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            "title" => "required",
            "company" => ["required", Rule::unique("listings", "company")],
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email", Rule::unique("listings", "email")],
            "tags" => "required",
            "description" => "required",
        ]);

        if ($request->hasFile("logo")) {
            $formFields["logo"] = $request->file("logo")->store("logos", "public");
        }

        $formFields["user_id"] = Auth::id();

        Listing::create($formFields);

        return redirect("/")->with("message", "Listing Created Successfully");
    }

    // Show Edit Form
    public function edit(Listing $listing)
    {
        return view("listings.edit", [
            "listing" => $listing
        ]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing)
    {

        $request->session()->token();

        // Make sure logged in user is owner
        if ($listing->user_id != Auth::id()) {
            abort(403, "Unauthorized Action");
        }

        $formFields = $request->validate([
            "title" => "required",
            "company" => ["required"],
            "location" => "required",
            "website" => "required",
            "email" => ["required", "email"],
            "tags" => "required",
            "description" => "required",
        ]);

        if ($request->hasFile("logo")) {
            $formFields["logo"] = $request->file("logo")->store("logos", "public");
        }

        $listing->update($formFields);

        return redirect("/listings/$listing->id")->with("message", "Listing Updated Successfully");
    }

    // Delete Listing Data
    public function destroy(Listing $listing)
    {
        // Make sure logged in user is owner
        if ($listing->user_id != Auth::id()) {
            abort(403, "Unauthorized Action");
        }

        $listing->delete();
        return redirect("/")->with("message", "Listing Deleted Successfully");
    }

    // Manage Listings
    public function manage()
    {
        return view("listings.manage", [
            "listings" => Auth::user()->listings()->get()
        ]);
    }
}
