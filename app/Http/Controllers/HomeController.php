<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request; // Use the proper Request class for dependency injection
use App\Models\User; // Model for User
use App\Models\Role; // Model for Role
use Illuminate\Support\Facades\Storage; // For file handling
use Illuminate\Support\Facades\View; // For generating HTML views dynamically



class HomeController extends Controller
{
     
    /**
     * Display the index page with roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch roles from the database as an associative array (id => name)
        $roles = Role::pluck('name', 'id'); 

        // Pass the roles data to the 'welcome' view
        return view('welcome', compact('roles'));
    }


    /**
     * Handle the form submission to save user data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save()
    {
       
        $response   =   array();
        $status     =   'error';
        $formData   =   Request::all();
        // Validation rules
        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|regex:/^[6-9]\d{9}$/',
            'description'   => 'nullable|string',
            'role_id'       => 'required|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        // Custom validation messages
        $messages = [
            'name.required'             => 'Please enter your name.',
            'name.string'               => 'Name should be a valid string.',
            'name.max'                  => 'Name should not exceed 255 characters.',
            'email.required'            => 'Please enter your email address.',
            'email.email'               => 'Please enter a valid email address.',
            'email.unique'              => 'This email is already registered. Please use a different one.',
            'phone.required'            => 'Please enter your phone number.',
            'phone.regex'               => 'Please enter a valid Indian phone number. It should start with a digit between 6-9 and contain 10 digits.',
            'description.nullable'      => 'Description should be a valid text if provided.',
            'description.string'        => 'Description must be a valid string.',
            'role_id.required'          => 'Please select a role.',
            'role_id.exists'            => 'The selected role does not exist. Please select a valid role.',
            'profile_image.nullable'    => 'Profile image is optional.',
            'profile_image.image'       => 'Please upload a valid image file.',
            'profile_image.mimes'       => 'Profile image must be in JPG, PNG, GIF, or SVG format.',
            'profile_image.max'         => 'Profile image must not exceed 2MB.',
        ];

         // Validate the request
        $validator = Validator::make($formData, $rules, $messages);
        
        if ($validator->fails()) {
            $response['status'] = $status;
            $response['errors'] = $validator->errors();
        } else{
            
            // Handle image upload
            if (Request::hasFile('profile_image')) {
                 // Store the uploaded file in the 'profiles' directory within the public storage
                $path = Request::file('profile_image')->store('profiles', 'public');
            } else {
                $path = null;
            }

            // Create and save a new user record
            $obj                =   new User();
            $obj->name          =   ($formData['name']) ?? "" ;
            $obj->email         =   ($formData['email']) ?? "" ;
            $obj->phone         =   ($formData['phone']) ?? "" ;
            $obj->description   =   ($formData['description']) ?? "" ;
            $obj->role_id       =   ($formData['role_id']) ?? "" ;
            $obj->profile_image =   $path;
            $obj->save();

            // Prepare a successful response
            $response['status']         =   'success';
            $response['redirectUrl']    =   route("Home.index"); // Redirect URL after successful save

            // Generate an updated user table view dynamically
            $users      =   User::orderBy('id', 'desc')->get();
            $htmlView   =   View::make("user_list", compact('users'))->render();
            $response['userTableView']    =   $htmlView;

        }

        // Return the response as JSON
        return response()->json($response);
    }


 


}