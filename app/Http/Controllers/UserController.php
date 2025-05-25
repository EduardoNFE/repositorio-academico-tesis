<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Hash; // Para encriptar la contraseña si se añade creación de usuario


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Opcional: Añadir búsqueda de usuarios por nombre o email
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }

        // Paginación para los usuarios
        $users = $query->paginate(10); // Mostrar 10 usuarios por página
        $users->appends($request->only(['search'])); // Mantener la búsqueda en la paginación

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Opcional: Si quieres permitir al admin crear usuarios manualmente
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Opcional: Lógica para almacenar un nuevo usuario
        // Esto es más si el admin va a crear usuarios manualmente
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user', // Valida que el rol sea 'admin' o 'user'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Podrías usar esto para ver el perfil de un usuario, si es necesario
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        // Podrías pasar los roles disponibles si tienes una lista dinámica
        $roles = ['admin', 'user']; // Roles hardcodeados por ahora
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,user', // Valida que el rol sea 'admin' o 'user'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Opcional: Impedir que un admin se elimine a sí mismo o que se elimine el último admin
        // if ($user->id === auth()->id()) {
        //     return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        // }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
