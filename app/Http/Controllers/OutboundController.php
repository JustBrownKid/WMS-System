<?php

namespace App\Http\Controllers;

use App\Models\Outbound;
use Illuminate\Http\Request;
use App\Imports\OutboundImport;
use Maatwebsite\Excel\Facades\Excel;

class OutboundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outbounds = Outbound::all();
        return view('outbound.List', compact('outbounds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('outbound.Create');

    }

    /**
     * Store a newly created resource in storage (Excel Upload).
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $import = new OutboundImport;

        Excel::import($import, $request->file('file'));

        if (!empty($import->invalidRows)) {
            session(['invalid_rows' => $import->invalidRows]);
            return redirect()->route('outbounds.downloadInvalid');
        }

        return back()->with('success', 'Outbound data imported successfully.');
    }

    /**
     * Download invalid rows if any.
     */
    public function downloadInvalid()
    {
        $invalidRows = session('invalid_rows');

        if (!$invalidRows) {
            return back()->with('error', 'No invalid rows to download.');
        }

        $fileName = 'invalid_outbound_rows.csv';
        $headers = array_keys($invalidRows[0]);

        $callback = function () use ($headers, $invalidRows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($invalidRows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        session()->forget('invalid_rows');

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Outbound $outbound)
    {
        return view('outbounds.show', compact('outbound'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outbound $outbound)
    {
        return view('outbounds.edit', compact('outbound'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outbound $outbound)
    {
        $validated = $request->validate([
            'sku' => 'required',
            'item_name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'dispatch_date' => 'required|date',
            'dispatched_by' => 'required',
            'recipient' => 'required',
            'destination' => 'required',
            'from_warehouse' => 'required',
            'from_location' => 'required',
            'status' => 'required',
            'reference_number' => 'required',
        ]);

        $outbound->update($validated);

        return redirect()->route('outbounds.index')->with('success', 'Outbound updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outbound $outbound)
    {
        $outbound->delete();
        return redirect()->route('outbounds.index')->with('success', 'Outbound deleted successfully.');
    }
}
