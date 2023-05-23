<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Http\Resources\Candidate as CandidateResource;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

/**
 * @group Candidate
 *
 * API endpoints for managing candidates
 */
class CandidateController extends Controller
{
    /**
     * Request Candidate Status
     *
     * @bodyParam   application_date    string  required    dd/mm/yyyy format.      Example: 10/04/2022
     * @bodyParam   codes               string  required    Codes for the Candidate.   Example: ACT152ACT3
     * @bodyParam   name                string  required    Name of the Candidate.   Example: Amar
     * @bodyParam   father_name         string  required    Candidate Father name.   Example: Guddu
     * @bodyParam   dob                 string  required    dd/mm/yyyy format.   Example: 16/04/1981
     * @bodyParam   address             string  required    Candidate Address.   Example: Parvathi Nilaya, 1st Main, Z Block, Sharma Nagar, Delhi - 100001
     *
     * @response {
     * "status": true,
     * "message": "Candidate found successfully!",
     * "data": {
     * "application_date": "13/04/2023",
     * "ref_no": "b0260c4d-699f-4149-ab3b-478d346fd44c",
     * "codes": "Sanmisha",
     * "name": "Sanjeev",
     * "father_name": "Jayant",
     * "dob": "16/04/1981",
     * "address": "Dombivali",
     * "status": "Pending"
     * }
     * }
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $input['ref_no'] = \Illuminate\Support\Str::uuid();
        $input['user_id'] = Auth::id();
        $input['status'] = 'Pending';

        $validator = Validator::make($input, [
            'application_date' => 'required|date_format:d/m/Y',
            'check_id' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'dob' => 'required|date_format:d/m/Y',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => "Candidate can not created!",
                'data' => $validator->errors()
            ], 404);
        }

        $candidate = Candidate::create($input);

        return response()->json([
            'status' => true,
            'message' => "Candidate Created successfully!",
            'data' => new CandidateResource($candidate)
        ], 201);
    }

    /**
     * Display Candidate Status
     *
     * @queryParam   refNo    string  required    Referenect No of the Candidate.      Example: b0260c4d-699f-4149-ab3b-478d346fd44c
     *
     * @response {
     * "status": true,
     * "message": "Candidate found successfully!",
     * "data": {
     * "application_date": "13/04/2023",
     * "ref_no": "b0260c4d-699f-4149-ab3b-478d346fd44c",
     * "codes": "Sanmisha",
     * "name": "Sanjeev",
     * "father_name": "Jayant",
     * "dob": "16/04/1981",
     * "address": "Dombivali",
     * "status": "Pending"
     * }
     * }
     */
    public function show($refNo)
    {
        $candidate = Candidate::where('ref_no', $refNo)->first();

        if (is_null($candidate)) {
            return response()->json([
                'status' => false,
                'message' => "Unable to Find Candidate",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Candidate found successfully!",
            'data' => new CandidateResource($candidate)
        ], 201);
    }
}
