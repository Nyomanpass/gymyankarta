<x-layout>
<div class="max-w-5xl mx-auto py-10 px-6 bg-gray-50 rounded-lg shadow-lg">
  <h1 class="text-3xl font-bold mb-8 text-gray-800">Input Pendapatan</h1>

  <form action="#" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="nama" required class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:border-blue-500" placeholder="Contoh: Gym Harian, Air Mineral">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
        <input type="number" name="jumlah" required class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:border-blue-500" placeholder="Contoh: 15000">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
      <textarea name="keterangan" rows="3" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:border-blue-500" placeholder="Contoh: Pembelian Air Mineral, Harian Gym, dll"></textarea>
    </div>

    <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded hover:bg-orange-700 transition duration-300 ease-in-out">Simpan</button>
  </form>

  <div class="mt-10 bg-green-50 border border-green-300 text-green-900 px-6 py-4 rounded-lg shadow-md flex items-center space-x-4">
    <ion-icon name="cash-outline" class="text-3xl"></ion-icon>
    <p class="font-extrabold text-xl">Total Pendapatan Hari Ini: <span class="text-green-700">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</span></p>
  </div>

  <div class="mt-8 bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-100 text-left text-gray-700 sticky top-0">
        <tr>
          <th class="px-6 py-3 font-semibold">No</th>
          <th class="px-6 py-3 font-semibold">Nama</th>
          <th class="px-6 py-3 font-semibold">Jumlah (Rp)</th>
          <th class="px-6 py-3 font-semibold">Keterangan</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse ($pendapatanHariIni as $index => $data)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">{{ $index + 1 }}</td>
            <td class="px-6 py-4">{{ $data->nama }}</td>
            <td class="px-6 py-4 font-mono">Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
            <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($data->keterangan, 140) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-6 text-center text-gray-500">Belum ada data hari ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

</x-layout>
