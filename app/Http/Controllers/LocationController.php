<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Imports\LocationImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $locations = Location::all();
        return view('location.locationList' , compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }       

    public function store(Request $request)
    {
        $import = new LocationImport;

        Excel::import($import, $request->file('file'));

        if (!empty($import->invalidRows)) {
            session(['invalid_rows' => $import->invalidRows]);
            return redirect()->route('location.downloadInvalid');
        }

        return back()->with('success', 'Locations imported successfully.');

    }


    public function downloadInvalid()
    {
        $invalidRows = session('invalid_rows');

        if (!$invalidRows) {
            return back()->with('error', 'No invalid rows to download.');
        }

        $fileName = 'invalid_inbound_data.csv';
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
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::find($id);
        return view('location.locationEdit', compact('location'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
        ]);

        $location = Location::find($id);

        $location->update([
            'warehouse_name' => $validatedData['warehouse_name'],
            'code' => $validatedData['code'],
        ]);
        return redirect()->route('location.list')->with('success', 'Location updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
    }
}
