<?php

namespace App\Http\Controllers;

use App\Models\Inbound;
use Illuminate\Http\Request;
use App\Imports\InboundImport;
use Maatwebsite\Excel\Facades\Excel;

class InboundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Inbounds = Inbound::all();
        return view('location.locationList' , compact('Inbounds'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $import = new InboundImport;


        Excel::import($import, $request->file('file'));

        if (!empty($import->invalidRows)) {
            session(['invalid_rows' => $import->invalidRows]);
            return redirect()->route('inbounds.downloadInvalid');
        }

        return back()->with('success', 'Locations imported successfully.');
        
    }

    public function downloadInvalid()
    {
        $invalidRows = session('invalid_rows');

        if (!$invalidRows) {
            return back()->with('error', 'No invalid rows to download.');
        }

        $fileName = 'invalid_data.csv';
        $headers = array_keys($invalidRows[0]);

        $callback = function () use ($headers, $invalidRows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($invalidRows as $row) {
                $headers = array_keys($invalidRows[0]);
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
    public function show(Inbound $inbound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inbound $inbound)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inbound $inbound)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inbound $inbound)
    {
        //
    }
}
