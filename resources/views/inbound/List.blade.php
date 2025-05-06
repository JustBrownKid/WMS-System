<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location List</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome (for icons) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-gray-200">

<!-- Navigation Bar -->
<nav class="bg-gray-800 fixed top-0 w-full px-20 text-white shadow z-20">
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
                Inbound List
            </li>
        </ol>
        <div class="flex justify-end">
            <a href="{{ route('inbounds') }}" 
               class="inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition duration-200 shadow-md">
               Go to Inbound Create
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container p-5 mt-12 relative">
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

    <!-- Search Input -->
    <div class="my-4">
        <input type="text" id="search" class="px-4 py-2 bg-gray-800 text-gray-200 border border-gray-600 rounded w-fix" placeholder="Search for items...">
    </div>

    <div class="overflow-x-auto max-h-[550px] bg-gray-800 shadow-lg rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-200 border-separate border-spacing-0">
            <!-- Table Header with sticky position and Filters -->
            <thead class="bg-gray-800 text-xs uppercase tracking-wider sticky top-0 z-20">
                <!-- Column Titles -->
                <tr>
                    <th class="px-4 py-2 sticky left-0 bg-gray-800 z-10 min-w-[150px] border-r border-gray-600">SKU</th>
                    <th class="px-4 py-2 min-w-[200px] border-r border-gray-600">Item Name</th>
                    <th class="px-4 py-2 min-w-[200px] border-r border-gray-600">Description</th>
                    <th class="px-4 py-2 min-w-[150px] border-r border-gray-600">Purchase Price</th>
                    <th class="px-4 py-2 min-w-[80px] border-r border-gray-600">Quantity</th>
                    <th class="px-4 py-2 min-w-[150px] border-r border-gray-600">Expire Date</th>
                    <th class="px-4 py-2 min-w-[150px] border-r border-gray-600">Received Date</th>
                    <th class="px-4 py-2 min-w-[150px] border-r border-gray-600">Sell Price</th>
                    <th class="px-4 py-2 min-w-[200px] border-r border-gray-600">Supplier</th>
                    <th class="px-4 py-2 min-w-[200px] border-r border-gray-600">Warehouse Name</th>
                    <th class="px-4 py-2 min-w-[150px] border-r border-gray-600">Location</th>
                    <th class="px-4 py-2 min-w-[100px] border-r border-gray-600">Status</th>
                    <th class="px-4 py-2 min-w-[100px] border-r border-gray-600">Voucher No.</th>
                    <th class="px-4 py-2 min-w-[200px] border-r border-gray-600">Remarks</th>
                    <th class="px-4 py-2 sticky right-0 bg-gray-800 z-10 min-w-[100]">Action</th>
                </tr>
                <tr>
    @for ($i = 0; $i < 15; $i++)
        @php
            // Define which columns should show inputs
            $searchableColumns = [0, 1, 5, 6, 8, 9, 10, 11, 12];
        @endphp
        <th class="
            px-2 py-1 border-r border-gray-600 
            {{ $i === 0 ? 'sticky left-0 bg-gray-800 z-20' : '' }} 
            {{ $i === 14 ? 'sticky right-0 bg-gray-800 z-20' : '' }}
        ">
            @if (in_array($i, $searchableColumns))
                <input 
                    type="text" 
                    class="column-search px-2 py-1 w-full bg-gray-700 text-gray-200 rounded border border-gray-600 text-xs" 
                    data-column="{{ $i }}" 
                    placeholder="Search"
                >
            @endif
        </th>
    @endfor
</tr>

            </thead>


            <!-- Table Body -->
            <tbody class="divide-y  divide-gray-700">
                @forelse($Inbounds as $index => $inbound)
                    <tr class="hover:bg-gray-700 border-b border-gray-600">
                        <td class="px-6 py-4 sticky left-0 bg-gray-800 z-10 border-r border-gray-600">{{ $inbound->sku ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->item_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->description ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->purchase_price ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->quantity ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->expire_date ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->received_date ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->sell_price ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->supplier ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->warehouse_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->location ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->status ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->voucher_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $inbound->remarks ?? 'N/A' }}</td>
                        <td class="px-6 py-4 sticky right-0 bg-gray-800 z-10 border-l border-gray-600">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('inbounds.edit', $inbound->id) }}" class="flex items-center text-xl text-yellow-400 hover:text-yellow-300 transition space-x-2">
                                    <i class="fas fa-edit"></i>
                                    <span></span>
                                </a>
                                <a href="{{ route('inbounds.edit', $inbound->id) }}" class="flex items-center text-xl text-yellow-400 hover:text-yellow-300 transition space-x-2">
                                <i class="fas fa-file-alt"></i>

                                    <span></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" class="px-6 py-4 text-center text-gray-400">No Inbound found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
     const columnInputs = document.querySelectorAll('.column-search');
    const tableRows = document.querySelectorAll('tbody tr');

    columnInputs.forEach(input => {
        input.addEventListener('input', () => filterTable());
    });

    function filterTable() {
        tableRows.forEach(row => {
            let match = true;

            columnInputs.forEach(input => {
                const columnIndex = parseInt(input.dataset.column);
                const filterValue = input.value.toLowerCase();
                const cell = row.cells[columnIndex];

                if (cell && filterValue && !cell.innerText.toLowerCase().includes(filterValue)) {
                    match = false;
                }
            });

            row.style.display = match ? '' : 'none';
        });
    }
    const filters = document.querySelectorAll('.filter');
    const rows = document.querySelectorAll('tbody tr');

    filters.forEach(select => {
        select.addEventListener('change', () => applyFilters());
    });

    document.getElementById('search').addEventListener('input', () => applyFilters());

    function applyFilters() {
        const searchTerm = document.getElementById('search').value.toLowerCase();

        rows.forEach(row => {
            let match = true;

            // Column filters
            filters.forEach(filter => {
                const colIndex = filter.dataset.column;
                const filterValue = filter.value.toLowerCase();
                const cellText = row.cells[colIndex].innerText.toLowerCase();

                if (filterValue && !cellText.includes(filterValue)) {
                    match = false;
                }
            });

            // Search box match
            if (searchTerm && !row.innerText.toLowerCase().includes(searchTerm)) {
                match = false;
            }

            row.style.display = match ? '' : 'none';
        });
    }
</script>

</body>
</html>
