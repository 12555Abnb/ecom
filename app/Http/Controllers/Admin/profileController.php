<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Traits\ApiResponse;

class ProfileController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' .
                Auth::User()->id,
            //'password' => 'required|string|min:6|confirmed',
            'image' => 'mimes:jpeg,png,jpg,gif|max:5120', // max 5 MB
            'address' => 'required|string|max:255',
            'github' => 'string|max:255',
            'website' => 'string|max:255',
        ]);

        // Handle validation failure
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 200, []);

            // return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
        }

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image_name = 'images/' . $request->name . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/'), $image_name);
        } else {
            $image_name = Auth::User()->image;
        }

        // Update or create the user
        $user = User::updateOrCreate(
            ['id' => Auth::user()->id],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'image' => $image_name, // Use the generated image name or null if not uploaded
                'address' => $request->address,
                'github' => $request->github,
                'website' => $request->website,
            ]
        );

        // return response()->json(['status' => 200, 'message' => 'Successfully Submitted']);
        return $this->success([], 'Successfully Submitted');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}