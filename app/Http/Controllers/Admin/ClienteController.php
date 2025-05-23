<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = User::where('role', 'cliente')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'celular' => 'nullable|string|max:20',
            'password' => 'required|string|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'celular' => $request->celular,
            'password' => Hash::make($request->password),
            'role' => 'cliente',
        ]);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(User $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, User $cliente)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cliente->id,
            'celular' => 'nullable|string|max:20',
        ]);

        $cliente->update($request->only('name', 'email', 'celular'));

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(User $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado.');
    }
}
