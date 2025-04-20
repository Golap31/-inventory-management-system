<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>user profile</title>
  <link rel="stylesheet" href="/Users/joti/Downloads/-inventory-management-system/joti/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
    <!-- Profile Header -->
    <div class="flex items-center space-x-6 mb-6">
      <img src="https://scontent.fjsr1-2.fna.fbcdn.net/v/t39.30808-6/472271876_1976197469524028_9074749207048187363_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeHTCGALwh0D4y_Staz6VYJyXl8tlTGh9rJeXy2VMaH2smCGWjAwHQTJu9xl45gnLSKZ9YhCxwEBY-ztkfCuLVnI&_nc_ohc=Hz6hAabQx3IQ7kNvwEfvwAA&_nc_oc=Adk6cPcV1h00XuAeQnNHYClChMKGGiDPX6DzagT_QLlZZwoEk28dVjEHU7jio6sfYsa1KGI8yoaZ8KDmE83kLk6M&_nc_zt=23&_nc_ht=scontent.fjsr1-2.fna&_nc_gid=Co0NFpSp8sByHdm3NGEXUg&oh=00_AfGttCTGsEqNrhIM8HkEGn1zrF4Eoe1CTMpA1EkwwImvcg&oe=6806F9A9" alt="Profile" class="w-24 h-24 rounded-full shadow-md">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Bangladesh Agri Co.</h1>
        <p class="text-gray-600">Admin | Agri Product Inventory Management</p>
        <button class="mt-2 px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit Profile</button>
      </div>
    </div>

    <!-- Business Information -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Business Details</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
        <div>
          <p class="font-medium">Business ID:</p>
          <p>WHLS-938472</p>
        </div>
        <div>
          <p class="font-medium">Industry:</p>
          <p>Agri Product</p>
        </div>
        <div>
          <p class="font-medium">Registered Since:</p>
          <p>March 2025</p>
        </div>
        <div>
          <p class="font-medium">Annual Revenue:</p>
          <p>$2.4M</p>
        </div>
      </div>
    </div>

    <!-- Contact Information -->
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
        <div>
          <p class="font-medium">Email:</p>
          <p>2320133@iub.edu.bd</p>
        </div>
        <div>
          <p class="font-medium">Phone:</p>
          <p>+880 1749-804854</p>
        </div>
        <div class="md:col-span-2">
          <p class="font-medium">Address:</p>
          <p>Bashundhara R/a, Dhaka</p>
        </div>
      </div>
    </div>

    <!-- Additional Info -->
    <div class="mb-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">About</h2>
      <p class="text-gray-700 leading-relaxed">
        Inventory Management and post harvest loss management System for Perishable Goods (e.g., vegetables and fruits)
      </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-4">
      <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Log Out</button>
      <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Home</button>
    </div>
  </div>

</body>
</html>
