<?php

namespace App\Http\Controllers;

use App\StoreClass\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('backend.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Kata sandi saat ini tidak cocok.'], 400);
        }

        DB::beginTransaction();
        try {
            $user->password = Hash::make($request->new_password);
            $user->save();
            DB::commit();
            LogAktivitas::log('Mengubah kata sandi', request()->path(), null, null, Auth::user()->id);

            return response()->json(['success' => true, 'message' => 'Kata sandi berhasil diperbarui.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui kata sandi. Silakan coba lagi.'], 500);
        }
    }
}
