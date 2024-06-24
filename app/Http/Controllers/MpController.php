<?php

namespace App\Http\Controllers;

use App\Models\Mp;
use App\Models\County;
use App\Models\Ward;
use App\Models\Constituency;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use PDF;

class MpController extends Controller
{
    public function index()
    {
        $mps = Mp::where('voted_yes', true)->get();
        $counties = County::all(); // Fetch all counties to pass to the view
        return view('mps.index', compact('mps', 'counties'));
    }
	
    public function recallForm(Mp $mp)
    {
        $counties = County::all();
        // Load constituencies and wards for the first county and first constituency initially (if needed)
        $constituencies = [];
        $wards = [];
        if (!empty($counties[0])) {
            $constituencies = Constituency::where('county_id', $counties[0]->id)->get();
            if (!empty($constituencies[0])) {
                $wards = Ward::where('constituency_id', $constituencies[0]->id)->get();
            }
        }
        return view('mps.recall', compact('mp', 'counties', 'constituencies', 'wards'));
    }

    public function fetchConstituencies($countyId)
    {
        $constituencies = Constituency::where('county_id', $countyId)->get();
        return response()->json($constituencies);
    }
    

    public function fetchWards($constituencyId)
    {
        $wards = Ward::where('constituency_id', $constituencyId)->get();
        return response()->json($wards);
    }
    


    public function show(Mp $mp)
    {
        $counties = County::all();
        $signatures = $mp->signatures()->get();
        $signaturesCount = $signatures->count();
        $recallRate = ($signaturesCount / 1000000) * 100;

        return view('mps.show', compact('mp', 'signatures', 'recallRate','counties'));
    }
	
	public function showSignatures(Mp $mp)
	{
        $counties = County::all();
		$mp->load('signatures'); 
		$signaturesCount = $mp->signatures->count();
		$recallRate = ($signaturesCount / 1000000) * 100;

		return view('mps.show', compact('mp', 'recallRate', 'signaturesCount','counties'));
	}


    public function downloadPdf(Mp $mp)
    {
        // Fetch data or customize PDF content as needed
        $signatures = $mp->signatures()->get();

        // Generate PDF content using Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml(view('mps.pdf', compact('mp', 'signatures')));

        // (Optional) Set options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // (Optional) Setup the paper size and orientation
        $pdf->setOptions($options);
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important for large PDFs)
        $pdf->render();

        // Download PDF with custom filename
        return $pdf->stream('mp_recall_report.pdf');
    }
	
}
