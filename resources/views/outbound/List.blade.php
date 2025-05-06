<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outbound List</title>

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
                Outbound List
            </li>
        </ol>
        <div class="flex justify-end">
            <a href="{{ route('outbounds.gg') }}"

               class="inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition duration-200 shadow-md">
               Go to Outbound Create
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
                <button onclick="this.closest('.alert').remove()" class="ml-auto text-green-400 hover:text-white">✕</button>
            </div>
        </div>
    @endif

    <!-- Search Input -->
    <div class="my-4">
        <input type="text" id="search" class="px-4 py-2 bg-gray-800 text-gray-200 border border-gray-600 rounded w-fix" placeholder="Search for items...">
    </div>

    <div class="overflow-x-auto max-h-[550px] bg-gray-800 shadow-lg rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-200 border-separate border-spacing-0">
            <thead class="bg-gray-800 text-xs uppercase tracking-wider sticky top-0 z-20">
                <tr>
                    @php
                        $headers = ['SKU', 'Item Name', 'Description', 'Quantity', 'Dispatch Date', 'Dispatched By', 'Recipient', 'Destination', 'From Warehouse', 'From Location', 'Status', 'Action'];
                        $searchableColumns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                    @endphp
                    @foreach ($headers as $index => $header)
                        <th class="px-4 py-2 {{ $index === 0 ? 'sticky left-0 bg-gray-800 z-10' : '' }} {{ $index === count($headers)-1 ? 'sticky right-0 bg-gray-800 z-10' : '' }} min-w-[150px] border-r border-gray-600">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
                <tr>
                    @for ($i = 0; $i < count($headers); $i++)
                        <th class="px-2 py-1 border-r border-gray-600 {{ $i === 0 ? 'sticky left-0 bg-gray-800 z-20' : '' }} {{ $i === count($headers)-1 ? 'sticky right-0 bg-gray-800 z-20' : '' }}">
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
            <tbody class="divide-y divide-gray-700">
                @forelse($outbounds as $outbound)
                    <tr class="hover:bg-gray-700 border-b border-gray-600">
                        <td class="px-6 py-4 sticky left-0 bg-gray-800 z-10 border-r border-gray-600">{{ $outbound->sku ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->item_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->description ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->quantity ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->dispatch_date ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->dispatched_by ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->recipient ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->destination ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->from_warehouse ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->from_location ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-r border-gray-600">{{ $outbound->status ?? 'N/A' }}</td>
                        <td class="px-6 py-4 sticky right-0 bg-gray-800 z-10 border-l border-gray-600">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('outbounds.list', $outbound->id) }}" class="text-xl text-yellow-400 hover:text-yellow-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-6 py-4 text-center text-gray-400">No Outbounds found.</td>
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

    document.getElementById('search').addEventListener('input', () => {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        tableRows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
    });
</script>

</body>
</html>
