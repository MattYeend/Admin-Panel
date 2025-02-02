<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use App\Mail\WelcomeNewUserMail;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use DateTimeZone;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admins and editors to view all
        $this->authorize('viewAny', User::class);

        $sortedUsers = User::orderBy('created_at', 'desc')->get();

        $currentPage = request('page', 1);
        $perPage = 10;
        $paginatedUsers = new LengthAwarePaginator(
            $sortedUsers->forPage($currentPage, $perPage),
            $sortedUsers->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.users.index', ['users' => $paginatedUsers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated() + [
            'created_by' => Auth::user()->id,
        ];
        
        $user = new User($validatedData);
        $user->password = bcrypt($request->password);

        $id = $user->id;
        Log::log(Log::ACTION_CREATE_USER, ['user' => $user], null, $id);
        $user->save();

        return redirect()->route('admin.user.index')->with('success', __('users.created_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedData = $request->validated() + [
            'updated_by' => Auth::user()->id,
        ];

        // If password is provided, hash and update
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        } else {
            unset($validatedData['password']);
        }

        // Update user with validated data
        $user->fill($validatedData);

        $user->save();
        $id = $user->id;
        Log::log(Log::ACTION_UPDATE_USER, ['user' => $user], null, $id);
        return redirect()->route('user.index')->with('success', __('users.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        $id = $user->id;
        Log::log(Log::ACTION_DELETE_USER, ['user' => $user], null, $id);
        return redirect()->route('users.index')->with('success', __('users.deleted_success'));
    }
}
