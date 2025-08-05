<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'johndoe@example.com', 'phone' => '1000000000', 'role' => 'admin'],
        ['id' => 2, 'name' => 'Jane Doe', 'email' => 'janedoe@example.com', 'phone' => '1000000001', 'role' => 'user'],
        ['id' => 3, 'name' => 'Alice Smith', 'email' => 'alicesmith@example.com', 'phone' => '1000000002', 'role' => 'manager'],
        ['id' => 4, 'name' => 'Bob Johnson', 'email' => 'bobjohnson@example.com', 'phone' => '1000000003', 'role' => 'user'],
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', ['users' => $this->users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
        ]);
        $this->users[] = $data;
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->users[$id] ?? null;
        if (!$user) {
            abort(404);
        }
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->users[$id] ?? null;
        if (!$user) {
            abort(404);
        }
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $this->users[$id] ?? null;
        if (!$user) {
            abort(404);
        }
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
        ]);
        $this->users[$id] = $data;
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->users[$id] ?? null;
        if (!$user) {
            abort(404);
        }
        unset($this->users[$id]);
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}