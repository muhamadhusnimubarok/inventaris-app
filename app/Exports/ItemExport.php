<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemExport implements FromCollection, withHeadings, withMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
    {
        return Item::all();
    }

     public function headings(): array
    {
        return [
            'Kategori',
            'Nama Barang',
            'Total',
            'Perbaikan Total',
            'Update terakhir'
        ];
    }
     public function map($item): array
    {
      
        return [
            $item->category->name,
            $item->name,
            $item->total ,
            $item->repair > 0 ? $item->repair : '-',
            $item->updated_at->format('F d, Y'),
        ];
    }



}
