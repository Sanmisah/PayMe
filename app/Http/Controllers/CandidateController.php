<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CandidatesImport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Sanmisha\Report;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = Candidate::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        return view('candidates.index', [
            'candidates' => $candidates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        return view('candidates.edit')->with([
            'candidate' => $candidate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'application_date' => 'required|date_format:d/m/Y',
            'check_id' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'dob' => 'required|date_format:d/m/Y',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($input)->with('error','Candidate can not be updated');
        }

        $candidate->fill($input);
        if($candidate->isDirty('status')) {
            $candidate->verification_date = date('d/m/Y');
        }
        $candidate->update();

        $watermarkReports = ['report_1', 'report_2'];
        $layout = Auth::user()->form_layout;
        $watermark = in_array($layout, $watermarkReports);

        $report = new Report();
        $report->generate($candidate, $layout, $watermark);

        return redirect()->route('candidates.index')->with('success','Candidate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        //
    }

    public function import(Candidate $candidate)
    {
        return view('candidates.import');
    }

    public function upload(Request $request)
    {
        Excel::import(new CandidatesImport, $request->file);

        return redirect()->route('candidates.index')->with('success', 'Candidates Imported Successfully');
    }

    public function download()
    {
        $zip = new ZipArchive;

        $fileName = 'candidate-reports.zip';

        if(\File::exists(public_path($fileName))) {
            \File::delete(public_path($fileName));
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            $path = public_path("reports/".Auth::user()->id);

            $files = \File::files($path);

            foreach ($files as $key => $value) {
                $file = basename($value);
                $zip->addFile($value, $file);
            }

            $zip->close();
        }

        return response()->download(public_path($fileName));
    }
}
