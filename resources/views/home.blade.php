<x-layout>
<div class="grid grid-cols-3 gap-4 mb-6">
  <div class="bg-gray-100 border border-gray-400 p-4 rounded-lg flex items-center space-x-3">
    <ion-icon name="people-outline" class="text-3xl text-blue-500"></ion-icon>
    <div>
      <p class="text-gray-500">Jumlah User</p>
      <p class="text-2xl font-bold">1635</p>
    </div>
  </div>

  <div class="bg-gray-100 border border-gray-400 p-4 rounded-lg flex items-center space-x-3">
    <ion-icon name="person-circle-outline" class="text-3xl text-green-500"></ion-icon>
    <div>
      <p class="text-gray-500">User Aktif</p>
      <p class="text-2xl font-bold">1635</p>
    </div>
  </div>

  <div class="bg-gray-100 border border-gray-400 p-4 rounded-lg flex items-center space-x-3">
    <ion-icon name="cash-outline" class="text-3xl text-orange-500"></ion-icon>
    <div>
      <p class="text-gray-500">Pendapatan Harian</p>
      <p class="text-2xl font-bold">Rp 12.500.000</p>
    </div>
  </div>
</div>


    <div class="bg-white p-4 shadow rounded-lg">
        <!-- Tempat Chart -->
        <canvas id="chart" class="w-full h-64"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [90, 95, 70, 105, 80, 85, 60, 30, 90, 50, 85, 40],
                    backgroundColor: '#10b981'
                }]
            },
        });
    </script>
</x-layout>
