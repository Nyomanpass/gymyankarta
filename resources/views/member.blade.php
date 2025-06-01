@php
$members = [
    (object)[
        'name' => 'Pastika',
        'tanggal_aktif' => '2025-05-15',
        'status' => 'aktif'
    ],
    (object)[
        'name' => 'Rizky',
        'tanggal_aktif' => '2025-04-10',
        'status' => 'nonaktif'
    ],
    (object)[
        'name' => 'Sari',
        'tanggal_aktif' => '2025-06-01',
        'status' => 'aktif'
    ],
];
@endphp

<x-layout>
    <div class="bg-white">
        <!-- Table -->
        <div class="overflow-x-auto w-full">
        <div class="bg-white w-full">
            <div class="flex items-center space-x-3 mb-5 p-1">
                <input type="text" placeholder="Cari nama..." class="px-4 py-2 w-64 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                <select class="border px-3 py-2 rounded-lg text-sm shadow-sm">
                    <option>10 data</option>
                    <option>25 data</option>
                    <option>50 data</option>
                </select>
            </div>

            <h2 class="text-xl font-semibold mb-4 mt-4 p-1">Data Member</h2>

            <div class="p-1">
                <table class="w-full table-auto text-sm text-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-orange-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">User Name</th>
                            <th class="px-4 py-3 text-left">Tanggal Aktif</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($members as $member)
                        <tr class="border-b hover:bg-gray-50 transition duration-150">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $member->name }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($member->tanggal_aktif)->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $member->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 space-x-2 flex items-center">
                                <button title="Lihat"
                                    class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-full shadow-sm transition">
                                    <ion-icon name="eye-outline" class="text-lg"></ion-icon>
                                </button>
                                <button title="Edit"
                                    class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 p-2 rounded-full shadow-sm transition">
                                    <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                </button>
                                <button title="Hapus"
                                    class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-full shadow-sm transition">
                                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                </button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Example -->
            <!-- Pagination Example -->
        <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
            <div>
                {{-- Menampilkan {{ $members->firstItem() }} sampai {{ $members->lastItem() }} dari {{ $members->total() }} data --}}
                Menampilkan 1 sampai {{ count($members) }} dari {{ count($members) }} data
            </div>
            <div class="space-x-2">
                {{-- {{ $members->links() }} --}}
            </div>
        </div>

</div>

</div>


    </div>
</x-layout>
