<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen">

    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-sm">
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

    </div>
   
<nav class="bg-gray-800 text-white shadow">
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
        Location Create
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

    <!-- Upload Form -->
    <div class="max-w-3xl mx-auto mt-20 bg-gray-800 p-6 rounded-lg shadow-lg">
        <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Dropzone -->
            <div 
                id="dropzone"
                class="border-2 border-dashed border-gray-500 rounded-md p-8 text-center transition hover:border-blue-500 hover:bg-gray-700 cursor-pointer"
                ondragover="event.preventDefault(); this.classList.add('border-blue-500', 'bg-gray-700');"
                ondragleave="this.classList.remove('border-blue-500', 'bg-gray-700');"
                ondrop="handleDrop(event)"
                onclick="document.getElementById('file-input').click()"
            >
                <input 
                    type="file" 
                    id="file-input" 
                    name="file"
                    class="hidden" 
                    accept=".xlsx, .csv"
                    onchange="handleFileSelect(this.files)"
                >

                <div class="flex flex-col items-center space-y-3">
                    <div class="p-3 bg-blue-900 rounded-full">
                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p><span class="text-blue-400">Click to upload</span> or drag & drop</p>
                    <p class="text-sm text-gray-400">XLSX, CSV (Max 5MB)</p>
                </div>
            </div>

            <!-- File Preview -->
            <div id="file-preview" class="hidden mt-4">
                <div class="flex items-center justify-between bg-gray-700 border border-gray-600 rounded p-3">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-900 rounded">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p id="filename" class="text-gray-100 font-medium truncate max-w-xs"></p>
                            <p id="filesize" class="text-xs text-gray-400"></p>
                        </div>
                    </div>
                    <button type="button" onclick="clearSelection()" class="text-gray-400 hover:text-red-400">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-right">
                <button 
                    id="upload-btn"
                    type="submit"
                    class="hidden px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Upload
                </button>
            </div>
        </form>
    </div>

    <script>
    function handleFileSelect(files) {
        if (files.length > 0) {
            processFile(files[0]);
        }
    }

    function handleDrop(event) {
        event.preventDefault();
        const dropzone = document.getElementById('dropzone');
        dropzone.classList.remove('border-blue-500', 'bg-gray-700');

        if (event.dataTransfer.files.length > 0) {
            processFile(event.dataTransfer.files[0]);
        }
    }

    function processFile(file) {
        // Validate file type
        const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'];
        if (!allowedTypes.includes(file.type)) {
            alert('Only .xlsx and .csv files are allowed.');
            return;
        }

        // Validate file size (5MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB.');
            return;
        }

        // Show file preview
        document.getElementById('filename').textContent = file.name;
        document.getElementById('filesize').textContent = `${(file.size / 1024).toFixed(2)} KB`;
        document.getElementById('file-preview').classList.remove('hidden');

        // Show upload button
        document.getElementById('upload-btn').classList.remove('hidden');
    }

    function clearSelection() {
        // Clear file input
        const fileInput = document.getElementById('file-input');
        fileInput.value = "";

        // Hide preview and upload button
        document.getElementById('file-preview').classList.add('hidden');
        document.getElementById('upload-btn').classList.add('hidden');
    }
</script>
