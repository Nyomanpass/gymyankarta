<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Tambahkan Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <title>yankartagym</title>
</head>
<body>
<div class="flex h-screen bg-white" x-data="{ sidebarOpen: false }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen">

  <!-- Sidebar -->
  <x-sidebar/>

  <!-- Content wrapper -->
  <div class="flex-1 flex flex-col">

    <!-- Header -->
    <x-header />

    <!-- Main content -->
    <main class="flex-1 overflow-auto p-6">
      {{ $slot }}
    </main>
  </div>
</div>

</body>
</html>