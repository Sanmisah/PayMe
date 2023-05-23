<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Candidate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'application_date' => $this->application_date,
            'ref_no' => $this->ref_no,
            'check_id' => $this->check_id,
            'name' => $this->name,
            'father_name' => $this->father_name,
            'dob' => $this->dob,
            'pos' => $this->pos,
            'dob' => $this->dob,
            'address' => $this->address,
            'pincode' => $this->pincode,
            'city' => $this->city,
            'state' => $this->state,
            'district' => $this->district,
            'address' => $this->address,
            'verification_date' => $this->verification_date,
            'file_name' => $this->file_name,
            'status' => $this->status,
        ];
    }
}
