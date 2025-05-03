<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * Return the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get the relevant data from the User model
        return User::all(['name', 'email', 'created_at']);  // Or use 'updated_at' if needed
    }

    /**
     * Return the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',  // Header for the first column
            'Email',  // Header for the second column
            'Created At',  // Header for the third column (or use 'Updated At' if applicable)
        ];
    }
}
