<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Location List</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen">
<nav class="bg-gray-800 text-white shadow  px-20">
  <div class="container mx-auto px-4 py-4 flex items-center justify-between">

    <!-- Breadcrumb -->
    <ol class="flex text-sm font-medium space-x-2 text-gray-300">
      <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors duration-200">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </li>
      <li class="flex items-center">
        <a href="{{ route('location.list') }}"  class="hover:text-white transition-colors duration-200">Location List</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </li>
      <li class="flex items-center text-gray-500" aria-current="page">
        Location Edit
      </li>
    </ol>
    <div class="flex justify-end ">
    <a href="{{ route('location.list') }}" 
   class="inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition duration-200 shadow-md">
    Back to Location List
</a>

</div>
  </div>
</nav>

<div class="max-w-xl mx-auto mt-10 mb-10 px-6 py-8 bg-gray-800 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-center text-white mb-6">Edit Location</h1>

    <form action="{{ route('location.update', $location->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Warehouse Name -->
        <div class="mb-5">
            <label for="warehouse_name" class="block text-sm font-medium text-gray-300 mb-1">Warehouse Name</label>
            <input 
                type="text" 
                id="warehouse_name" 
                name="warehouse_name" 
                value="{{ $location->warehouse_name }}" 
                required
                class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-white focus:ring focus:ring-blue-500 focus:outline-none"
            >
        </div>

        <!-- Location Code -->
        <div class="mb-5">
            <label for="code" class="block text-sm font-medium text-gray-300 mb-1">Location Code</label>
            <input 
                type="text" 
                id="code" 
                name="code" 
                value="{{ $location->code }}" 
                required
                class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-white focus:ring focus:ring-blue-500 focus:outline-none"
            >
        </div>

        <!-- Created At (Read-only) -->
        <div class="mb-6">
            <label for="created_at" class="block text-sm font-medium text-gray-300 mb-1">Created At</label>
            <input 
                type="text" 
                id="created_at" 
                name="created_at" 
                value="{{ $location->created_at ? $location->created_at->format('Y-m-d') : '' }}" 
                disabled
                class="w-full px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-400"
            >
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-200"
        >
            Update Location
        </button>

        <!-- Cancel Link -->
        <div class="text-center mt-4">
            <a href="{{ route('location.list') }}" class="text-sm text-blue-400 hover:text-blue-500">
                Cancel
            </a>
        </div>
    </form>
</div>

</body>
</html>
