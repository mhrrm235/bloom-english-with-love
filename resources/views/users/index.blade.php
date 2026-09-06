@extends('layouts.app')

@section('title', 'Kelola User - Bloom English with Love')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">👥 Kelola Pengguna Platform</h1>
            <p class="text-sm text-slate-600 mt-1">Kelola data seluruh akun Administrator, Instructor, dan Student.</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="px-5 py-3 rounded-2xl bg-purple-600 text-white font-bold text-sm shadow-md hover:bg-purple-700 transition-all flex items-center space-x-2">
            <span>➕ Tambah User Baru</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Cari Nama / Email</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                    class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Filter Peran (Role)</label>
                <select name="role" class="block w-full px-4 py-2.5 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Semua Role --</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>
                            {{ $r->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800">
                    Filter & Cari
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- User Data Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6">Pengguna</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Role / Akses</th>
                        <th class="py-4 px-6">Terdaftar Pada</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-slate-100 font-bold text-slate-700 flex items-center justify-center text-xs">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-600 font-medium">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @if($user->isAdmin())
                                <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700 text-xs font-bold">
                                    👑 Administrator
                                </span>
                            @elseif($user->isInstructor())
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-100 text-indigo-700 text-xs font-bold">
                                    🎓 Instructor
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">
                                    ⭐ Student
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-500 font-medium">
                            {{ $user->created_at->format('d M Y - H:i') }} WIB
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200">
                                Edit
                            </a>
                            @if($user->id !== Auth::id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-700 text-xs font-bold hover:bg-rose-200">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-slate-400 font-medium">
                            Tidak ada pengguna yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
