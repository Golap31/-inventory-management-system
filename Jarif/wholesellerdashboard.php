<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wholesaler Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Sidebar -->
  <div class="flex min-h-screen">
    <aside class="w-64 bg-white shadow-md p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">WholesalePro</h2>
      <nav class="space-y-4">
        <a href="#" class="block text-gray-700 hover:text-blue-600">Dashboard</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">Orders</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">Inventory</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">Clients</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">Settings</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <!-- Top Bar -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Dashboard</h1>
        <div class="flex items-center space-x-4">
          <input type="text" placeholder="Search..." class="border rounded-lg px-3 py-1">
          <img src="https://i.pravatar.cc/40" alt="User" class="rounded-full w-10 h-10">
        </div>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow">
          <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Orders</h3>
          <p class="text-2xl font-bold text-blue-600">1,245</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
          <h3 class="text-lg font-semibold text-gray-700 mb-2">Pending Shipments</h3>
          <p class="text-2xl font-bold text-yellow-500">53</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
          <h3 class="text-lg font-semibold text-gray-700 mb-2">Revenue</h3>
          <p class="text-2xl font-bold text-green-600">$89,300</p>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Orders</h2>
        <table class="w-full table-auto">
          <thead>
            <tr class="text-left bg-gray-100">
              <th class="p-2">Order ID</th>
              <th class="p-2">Client</th>
              <th class="p-2">Amount</th>
              <th class="p-2">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="p-2">#1234</td>
              <td class="p-2">ABC Retail</td>
              <td class="p-2">$1,200</td>
              <td class="p-2 text-green-600">Shipped</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">#1235</td>
              <td class="p-2">XYZ Traders</td>
              <td class="p-2">$980</td>
              <td class="p-2 text-yellow-500">Processing</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Inventory Summary -->
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Inventory Overview</h2>
        <ul class="space-y-2">
          <li class="flex justify-between text-gray-700">
            <span>Product A</span>
            <span class="font-semibold">320 units</span>
          </li>
          <li class="flex justify-between text-gray-700">
            <span>Product B</span>
            <span class="font-semibold">128 units</span>
          </li>
          <li class="flex justify-between text-gray-700">
            <span>Product C</span>
            <span class="font-semibold">450 units</span>
          </li>
        </ul>
      </div>
    </main>
  </div>
</body>
</html>
