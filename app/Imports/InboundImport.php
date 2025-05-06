<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Inbound;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InboundImport implements ToModel, WithHeadingRow
{
    public $insertedCount = 0;
    public $invalidRows = [];

    /**
     * This method parses the date and returns it in 'Y-m-d' format.
     * Handles both date formats and Excel-style numeric date values.
     */
    public function parseDate($value)
    {
        if (!$value || empty($value)) {
            // If the value is empty or null, return null
            return null;
        }

        // Try parsing as m/d/Y (e.g., 12/31/2025)
        try {
            return Carbon::createFromFormat('m/d/Y', trim($value))->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Return null if parsing fails
        }
    }

    /**
     * This method handles the row data and maps it to the Inbound model.
     */
    public function model(array $row)
    {
        // Check for required fields and other validations
        $requiredFields = [
            'sku',
            'item_name',
            'description',
            'purchase_price',
            'quantity',
            'received_by',
            'expire_date',
            'received_date',
            'sell_price',
            'supplier',
            'warehouse_name',
            'location',
            'status',
            'voucher_number',
            'remarks'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($row[$field])) {
                $this->invalidRows[] = array_merge($row, ['reason' => "Missing required fields: $field"]);
                return null;
            }
        }
        

        // Parse the dates if they are present, else set as null
        $expire_date = $this->parseDate($row['expire_date']);
        $received_date = $this->parseDate($row['received_date']);

        // Additional validations and logic here...

        // Increment inserted count for valid rows
        $this->insertedCount++;

        // Return new Inbound model
        return new Inbound([
            'sku'            => $row['sku'],           
            'item_name'      => $row['item_name'],     
            'description'    => $row['description'],       
            'purchase_price' => $row['purchase_price'],  
            'quantity'       => $row['quantity'],         
            'expire_date'    => $expire_date,   // This can now be null
            'received_date'  => $received_date,  // This can now be null
            'received_by'    => $row['received_by'],  
            'sell_price'     => $row['sell_price'],      
            'supplier'       => $row['supplier'],        
            'warehouse_name' => $row['warehouse_name'],  
            'location'       => $row['location'],         
            'status'         => $row['status'],         
            'voucher_number' => $row['voucher_number'],  
            'remarks'        => $row['remarks'],         
        ]);
    }
}
