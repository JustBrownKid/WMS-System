<?php
namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel; 
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class LocationImport implements ToModel, WithHeadingRow
{
    public $insertedCount = 0;
    public $invalidRows = [];

    public function model(array $row)
    {
        if (empty($row['name'])) {
            $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: name']);
            return null;
        }
        
        if (empty($row['code'])) {
            $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: id']);
            return null;
        }
        
        if (Location::where('code', $row['code'])->exists()) {
            $this->invalidRows[] = array_merge($row, ['reason' => 'Duplicate location ID']);
            return null;
        }
        
        $this->insertedCount++;
        return new Location([
            'warehouse_name' => $row['name'],
            'code' => $row['code'],
        ]);
    }

    public function exportInvalidRows()
    {
        if (!empty($this->invalidRows)) {
            session(['invalid_rows' => $this->invalidRows]);
        }
    }
    
}
