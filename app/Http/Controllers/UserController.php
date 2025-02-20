<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->whereHas('role', function ($query) {
            $query->where('name', '!=', 'Pelanggan');
        })->paginate(10);
        
        $roles = Role::where('name', '!=', 'Pelanggan')->get();
        
        return view('pages.admin.akun', compact('users', 'roles'))->with(['title' => 'User Management']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.akun')->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ];

        // Only update password if it's provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.akun')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(Request $request, User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun Anda sendiri'
                ], 403);
            }
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        // Delete the user
        $user->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.akun')->with('success', 'User berhasil dihapus');
    }
}