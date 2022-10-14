<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use Symfony\Component\Routing\RouteCompiler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listings
// create - Show form to crete new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

// All Listings
Route::get('/', [ListingController::class, "index"]);

// Show Create form
Route::get('/listings/create', [ListingController::class, "create"])->middleware("auth");

// Store Listing Data
Route::post("/listings", [ListingController::class, "store"])->middleware("auth");

// Show Edit form
Route::get("/listings/{listing}/edit", [ListingController::class, "edit"])->middleware("auth");

// Update Listing Data
Route::put("/listings/{listing}", [ListingController::class, "update"])->middleware("auth");

// Delete Listing Data
Route::delete("/listings/{listing}", [ListingController::class, "destroy"])->middleware("auth");

// Manage Listings
Route::get("/listings/manage", [ListingController::class, "manage"])->middleware("auth");

// Single Listing
Route::get("/listings/{listing}", [ListingController::class, "show"]);

// Show Register/Create Form
Route::get("/register", [UserController::class, "create"])->middleware("guest");

// Create New User
Route::post("/users", [UserController::class, "store"]);

// Log User Out
Route::post("/logout", [UserController::class, "logout"])->middleware("auth");

// Show Login Form
Route::get("/login", [UserController::class, "login"])->name("login")->middleware("guest");

// Log User In
Route::post("/users/authenticate", [UserController::class, "authenticate"]);
