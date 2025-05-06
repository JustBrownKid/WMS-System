<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-gray-200 ">

<nav class="bg-gray-800 fixed top-0 w-full text-white shadow z-20  px-20">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Breadcrumb -->
        <ol class="flex text-sm font-medium space-x-2 text-gray-300">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors duration-200">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li class="flex items-center text-gray-500" aria-current="page">
                Location List
            </li>
        </ol>
        <div class="flex justify-end">
            <a href="{{ route('location.store') }}" 
               class="inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition duration-200 shadow-md">
               Go to Location Create
            </a>
        </div>
    </div>
</nav>

<div class="container mx-auto mt-24 relative">
    @if(session('success'))
        <div class="alert fixed top-0 right-0 m-4 bg-green-800 border-l-4 border-green-500 text-green-200 p-4 rounded shadow z-50">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-3">{{ session('success') }}</span>
                <button onclick="this.closest('.alert').remove()" class="ml-auto text-green-400 hover:text-white">
                    ✕
                </button>
            </div>
        </div>
    @endif

    <div class="border border-gray-700 rounded-lg overflow-hidden mt-16 mx-20">
        <table class="min-w-full text-sm text-left text-gray-200">
            <thead class="bg-gray-700 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 w-10">No</th>
                    <th class="px-6 py-3 w-1/5">Name</th>
                    <th class="px-6 py-3 w-1/5">Location</th>
                    <th class="px-6 py-3 w-1/3">Created At</th>
                    <th class="px-6 py-3 w-1/5">Action</th>
                </tr>
            </thead>
        </table>

        <!-- Scrollable Body -->
        <div class="max-h-[400px] overflow-y-auto">
            <table class="min-w-full text-sm text-left text-gray-200">
                <tbody class="bg-gray-800">
                    @forelse($locations as $index => $location)
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-6 py-4 w-10">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 w-1/5">{{ $location->warehouse_name }}</td>
                            <td class="px-6 py-4 w-1/5">{{ $location->code }}</td>
                            <td class="px-6 py-4 w-1/3">{{ $location->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 w-1/5 flex items-center space-x-4">
                                <a href="{{ route('location.edit', $location->id) }}" class="flex items-center text-yellow-400 hover:text-yellow-300 transition space-x-2">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('location', $location->id) }}" method="POST" onsubmit="return confirm('Delete this location?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-red-500 hover:text-red-400 transition space-x-2">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>
</html>
