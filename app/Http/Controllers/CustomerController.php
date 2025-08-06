<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customers = [
        ['id' => 1, 'name' => 'Hassan Mahmoud', 'city' => 'Cairo', 'country' => 'Egypt', 'phone' => '1000000000'],
        ['id' => 2, 'name' => 'Ahmed Ali', 'city' => 'Alex', 'country' => 'Egypt', 'phone' => '1000000001'],
        ['id' => 3, 'name' => 'Eman Ahmed', 'city' => 'Giza', 'country' => 'Egypt', 'phone' => '1000000002'],
        ['id' => 4, 'name' => 'Jailan Yousef', 'city' => 'Giza', 'country' => 'Egypt', 'phone' => '1000000002'],
        ['id' => 5, 'name' => 'Yara Mostafa', 'city' => 'Cairo', 'country' => 'Egypt', 'phone' => '1000000003'],
        ['id' => 6, 'name' => 'Maged Ali', 'city' => 'Alex', 'country' => 'Egypt', 'phone' => '1000000004'],
        ['id' => 7, 'name' => 'Ali Ibrahim', 'city' => 'Giza', 'country' => 'Egypt', 'phone' => '1000000005'],
        ['id' => 8, 'name' => 'Hassan Ali', 'city' => 'Cairo', 'country' => 'Egypt', 'phone' => '1000000006'],
        ['id' => 9, 'name' => 'Mohamed Ahmed', 'city' => 'Alex', 'country' => 'Egypt', 'phone' => '1000000007'],
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index', ['customers' => $this->customers]);
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
        //
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
