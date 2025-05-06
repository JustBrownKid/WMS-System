<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Outbound;
use App\Models\Inbound;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OutboundImport implements ToModel, WithHeadingRow
{
    public $insertedCount = 0;
    public $invalidRows = [];

    public function model(array $row)
    {
        // Basic validation
         $requiredFields = [
            'sku',
            'item_name',
            'description',
            'quantity',
            'dispatch_date',
            'dispatched_by',
            'recipient',
            'destination',
            'from_warehouse',  
            'from_location',
            'status',
            'reference_number',
            'remarks',
        ];
        foreach ($requiredFields as $field) {
            if (empty($row[$field])) {
                $this->invalidRows[] = array_merge($row, ['reason' => "Missing required fields: $field"]);
                return null;
            }
        }

        // Find inbound stock
        $inbound = Inbound::where('sku', $row['sku'])
            ->where('warehouse_name', $row['from_warehouse'])
            ->where('location', $row['from_location'])
            ->first();

        if (!$inbound) {
            $this->invalidRows[] = array_merge($row, ['reason' => 'SKU not found in warehouse/location']);
            return null;
        }

        if ($inbound->quantity < $row['quantity']) {
            $this->invalidRows[] = array_merge($row, ['reason' => 'Insufficient stock']);
            return null;
        }

        // Update stock
        $inbound->quantity -= $row['quantity'];
        $inbound->save();

        $this->insertedCount++;

        // Convert dispatch_date (with fallback)
        $dispatchDate = $this->parseDate($row['dispatch_date']);

        return new Outbound([
            'sku'              => $row['sku'],
            'item_name'        => $row['item_name'] ?? null,
            'description'      => $row['description'] ?? null,
            'quantity'         => $row['quantity'],
            'dispatch_date'    => $dispatchDate,
            'dispatched_by'    => $row['dispatched_by'] ?? null,
            'recipient'        => $row['recipient'] ?? null,
            'destination'      => $row['destination'] ?? null,
            'from_warehouse'   => $row['from_warehouse'],
            'from_location'    => $row['from_location'],
            'status'           => $row['status'] ?? 'Dispatched',
            'reference_number' => $row['reference_number'] ?? null,
            'remarks'          => $row['remarks'] ?? null,
        ]);
    }

    private function parseDate($value)
{
    if (!$value) return null;

    try {
        // If Excel date is numeric (like 45996), convert from Excel's date format
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        // Otherwise assume it's a standard string date like "12/1/2025"
        return Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
    } catch (\Exception $e) {
        return null;
    }
}

}
