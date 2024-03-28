<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();

        return Inertia::render('User',[
            'users' => UserResource::collection($users)
        ]);
    }
}
