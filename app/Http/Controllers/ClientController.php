<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::orderBy('date_profiled', 'desc')->get();
        return view('clients')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $client = new Client();
    //     $client->first_name = $request->input('first_name');
    //     $client->last_name = $request->input('last_name');
    //     $client->email = $request->input('email');
    //     $client->date_profiled = $request->input('date_profiled');
    //     $client->primary_legal_counsel = $request->input('primary_legal_counsel');
    //     $client->date_of_birth = $request->input('date_of_birth');
    //     $client->case_details = $request->input('case_details');
    //     $profile_image = $request->profile_image;
    //     if ($profile_image) {
    //         $image_name = 'profile-' . $client->first_name . ' ' . $client->last_name  . '.' . $profile_image->getClientOriginalExtension();
    //         $profile_image->move('img/', $image_name);
    //         $client->profile_image = $image_name;
    //     }
    //     $create = $client->save();
    //     //
    //     if ($create) {
    //         // Mail
    //         $welcome = ([
    //             'name' => $client->first_name . ' ' . $client->last_name,
    //         ]);
    //         Mail::to($client->email)->send(new WelcomeEmail($welcome));
    //         return response()->json($client);
    //     }
    // }
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'date_profiled' => 'required|date',
            'primary_legal_counsel' => 'required',
            'date_of_birth' => 'required|date',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'case_details' => 'required',
        ]);

        // Handle the profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
            $validatedData['profile_image'] = $imageName;
        }

        // Create the client
        $client = Client::create($validatedData);
        if ($client) {
            // Mail
            $welcome = ([
                'name' => $client->first_name . ' ' . $client->last_name,
            ]);
            Mail::to($client->email)->send(new WelcomeEmail($welcome));
            return response()->json($client);
        }

        // return response()->json($client);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
