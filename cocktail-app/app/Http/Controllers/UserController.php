<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Usuarios.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role_id'  => 'nullable|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
    public function editOwn()
    {
        $user = auth()->user();
        return view('Usuarios.edit-own', compact('user'));
    }

    public function updateOwn(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        $user->update($validated);
    
        return redirect()->route('perfil.edit')
               ->with('success', 'Perfil actualizado correctamente');
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('Usuarios.edit', [
            'user' => $usuario,
            'roles' => $roles
        ]);
    }
    public function update(Request $request, User $usuario)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($usuario->id)
        ],
        'role_id' => 'required|exists:roles,id',
        'password' => 'nullable|string|min:8|confirmed',
    ]);
    if (!empty($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    $usuario->update($validated);

    return redirect()->route('usuarios.index')
           ->with('success', 'Usuario actualizado correctamente');
}
}
