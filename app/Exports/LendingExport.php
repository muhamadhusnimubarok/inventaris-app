<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LendingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Lending::with(['lendingDetails.item', 'createdBy'])->get();
    }

  
    public function map($lending): array
    {
        $rows = [];

       
        foreach ($lending->lendingDetails as $detail) {
            $rows[] = [
                $detail->item->name ?? 'Barang Terhapus', 
                $detail->qty,                         
                $lending->user_name,                   
                $lending->notes,                        
                $lending->loan_date ? \Carbon\Carbon::parse($lending->loan_date)->format('M d, Y') : '-', // Kolom Date
                $lending->return_date ? \Carbon\Carbon::parse($lending->return_date)->format('M d, Y') : '-', // Kolom Return Date
                $lending->createdBy->name ?? 'Admin',   
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Name',
            'Ket.',
            'Date',
            'Return Date',
            'Edited By',
        ];
    }
}