<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = User::create([
                'last_name' => $row['nom'],
                'first_name' => $row['prenom'],
                'phone_number' => $row['telephone'],
                'email' => $row['email'],
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);

           Teacher::create([
                'user_id' => $user->id,
                'status' => $row['statut']
            ]);
        }
    }
}
