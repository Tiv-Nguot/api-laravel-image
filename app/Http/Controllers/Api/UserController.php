<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $users = User::all();
    //     // Add image URL to each user data
    //     $users->each(function ($user) {
    //         $user->image_url = asset('images/' . $user->image);
    //     });
    //     $users = UserResource::collection($users);
    //     return response()->json(
    //         [
    //             'success' => true,
    //             'data' => $users
    //         ]
    //     );
    // }
    
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get(); // Order users by id in descending order
        // Add image URL to each user data
        $users->each(function ($user) {
            $user->image_url = asset('images/' . $user->image);
        });
        $users = UserResource::collection($users);
        return response()->json(
            [
                'success' => true,
                'data' => $users
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::store($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'User created successfully'
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Not found ID " . $id
                ]
            );
        }

        // Add image URL to the user data
        $user->image_url = asset('images/' . $user->image);

        return response()->json(
            [
                'success' => true,
                'data' => $user
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Not found ID " . $id
                ]
            );
        }

        $user = User::store($request, $id);
        return response()->json(
            [
                'success' => true,
                'message' => "User updated successfully ID " . $id
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Not fount to delete ID " . $id
                ]
            );
        }
        $user->delete();
        return response()->json(
            [
                'success' => true,
                'message' => "User deleted successfully with ID " . $id
            ]
        );
    }
}
