<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Address::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'address' => 'required|min:3',
            'city' => 'required|min:3',
            'state' => 'required|min:3',
            'zip' => 'required|min:3',
            'country' => 'required|min:3',
        ]);
        $address = Address::create($credentials);
        return response()->json($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return response()->json($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $credentials = $request->validate([
            'address' => 'min:3',
            'city' => 'min:3',
            'state' => 'min:3',
            'zip' => 'min:3',
            'country' => 'min:3',
        ]);
        if($address->update($credentials)){
            return response()->json($address);
        }
        return response()->json(['message' => 'Update failed'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(['message' => 'Address deleted successfully']);
    }
}
