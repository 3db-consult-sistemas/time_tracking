<?php

namespace App\Http\Controllers;

use App\User;
use App\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(['auth', 'checkrole:super_admin,admin']);

        $this->userRepository = $userRepository;
    }

    /**
     * Visualizo la vista de usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->fetch();

        return view('users.index', compact('users'));
    }

    /**
     * Visualizo la edicion de usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Actualizo el perfil del usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:user,admin,super_admin',
		]);

		if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($user->id == auth()->id()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['You cannot update your own role.']);
        }

        $user->role = $request['role'];
        $user->save();

        return redirect('users');
    }
}
