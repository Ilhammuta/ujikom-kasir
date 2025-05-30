@extends('layouts.app')

@section('title', 'User')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <nav class="text-sm text-gray-500 mb-4">
            <a href="#" class="hover:underline">Home</a> / <span>User</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
            <h1 class="text-3xl font-bold text-gray-800">User</h1>
            <a href="{{ route('user.create') }}"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                Tambah User
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-gray-700">#</th>
                        <th class="px-6 py-3 text-gray-700">Email</th>
                        <th class="px-6 py-3 text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-gray-700">Role</th>
                        <th class="px-6 py-3 text-gray-700"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $index => $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $item->email }}</td>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->role }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('user.edit', $item->id) }}"
                                    class="bg-yellow-400 text-white px-4 py-1 rounded hover:bg-yellow-500 transition text-sm">
                                    Edit
                                </a>

                                @if ($item->role === 'admin')
                                    <button class="bg-red-500 text-white px-4 py-1 rounded cursor-not-allowed opacity-50" disabled>
                                        Hapus
                                    </button>
                                @else
                                    <button type="button"
                                        onclick="confirmDelete({{ $item->id }})"
                                        class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 transition text-sm">
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('user.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus akun ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endpush
