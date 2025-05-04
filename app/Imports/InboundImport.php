<?php

namespace App\Imports;

use App\Models\Inbound;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InboundImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $insertedCount = 0;
    public $invalidRows = [];

    public function model(array $row)
    {    if (empty($row['sku'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: sku']);
        return null; 
    }

    if (empty($row['item_name'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: item_name']);
        return null; 
    }
    if (empty($row['description'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: description']);
        return null; 
    }  

    if (empty($row['purchase_price'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: purchase_price']);
        return null; 
    }

    if (empty($row['quantity'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: quantity']);
        return null; 
    }

    if (empty($row['received_by'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: received_by']);
        return null;
    }

    if (empty($row['expire_date'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: expire_date']);
        return null;
    }

    if (empty($row['received_date'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: received_date']);
        return null; 
    }

    if (empty($row['sell_price'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: sell_price']);
        return null; 
    }

    if (empty($row['supplier'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: supplier']);
        return null; 
    }

    if (empty($row['warehouse_name'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: warehouse_name']);
        return null; 
    }

    if (empty($row['location'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: location']);
        return null; 
    }

    if (empty($row['voucher_number'])) {
        $this->invalidRows[] = array_merge($row, ['reason' => 'Missing required fields: voucher_number']);
        return null; 
    }  
        $this->insertedCount++;

        return new Inbound([
            'sku'            => $row['sku'],           
            'item_name'      => $row['item_name'],     
            'description'    => $row['description'],       
            'purchase_price' => $row['purchase_price'],  
            'quantity'       => $row['quantity'],         
            'expire_date'    => $this->parseDate($row['expire_date']),
            'received_date'  => $this->parseDate($row['received_date']), 
            'received_by'    => $row['received_by'],  
            'sell_price'     => $row['sell_price'],      
            'supplier'       => $row['supplier'],        
            'warehouse_name' => $row['warehouse_name'],  
            'location'       => $row['location'],         
            'voucher_number' => $row['voucher_number'],  
            'remarks'        => $row['remarks'],         
        ]);
    }
    private function parseDate($date)
    {
        if (is_numeric($date)) {
            $excelBaseDate = Carbon::createFromDate(1900, 1, 1);
            return $excelBaseDate->addDays($date - 2)->format('d m Y'); 

        return null;
    }
    }
}
