@extends('layouts.app')

@section('title', 'Edit User - Bloom English with Love')

@section('content')
<div class="py-8 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-6">✏️ Edit Akun Pengguna: {{ $user->name }}</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-purple-500">
                @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Alamat Email</label>
                <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-purple-500">
                @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Role / Peran Akses</label>
                <select name="role_id" required class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-purple-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->display_name }} ({{ $role->name }})
                        </option>
                    @endforeach
                </select>
                @error('role_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Kata Sandi Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-purple-500">
                <p class="text-[11px] text-slate-400 mt-1">*Isi hanya jika Anda ingin meriset kata sandi pengguna ini.</p>
                @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-purple-600 text-white font-bold text-sm shadow-md hover:bg-purple-700">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
