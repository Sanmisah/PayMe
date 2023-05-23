<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class CandidatesImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $candidate = Candidate::create([
            'user_id' => Auth::id(),
            'ref_no' => \Illuminate\Support\Str::uuid(),
            'application_date' => $row['application_date'],
            'check_id' => $row['check_id'],
            'name' => $row['candidate_name'],
            'father_name' => $row['father_name'],
            'dob' => $row['dob_ddmmyyyy'],
            'pos' => $row['pos'],
            'address' => $row['address'],
            'pincode' => $row['pincode'],
            'city' => $row['city'],
            'state' => $row['city'],
            'district' => $row['state'],
            'verification_date' => $row['verification_date'],
            'status' => 'Green'
        ]);

        // return $candidate;
    }
}
