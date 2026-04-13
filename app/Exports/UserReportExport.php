<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserReportExport implements FromCollection, withHeadings, withMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Email',
            'Password',
            'Tanggal Dibuat',
        ];
    }
   public function map($user): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $user->name,
            $user->email,
            $user->is_password_modified 
                ? 'This account already edited the password' 
                : $user->generateDefaultPassword(),
            $user->created_at->format('F d, Y'),
        ];
    }
}
