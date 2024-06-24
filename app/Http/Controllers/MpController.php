<?php

namespace App\Http\Controllers;

use App\Models\Mp;
use App\Models\County;
use App\Models\Constituency;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use PDF;

class MpController extends Controller
{
    public function index()
    {
        $mps = MP::where('voted_yes', true)->get();
        return view('mps.index', compact('mps'));
    }
	
	public function recallForm(Mp $mp)
    {
        return view('mps.recall', compact('mp'));
    }

    public function show(Mp $mp)
    {
        // Retrieve signatures associated with the MP using query builder
        $signatures = $mp->signatures()->get(); // Adjust according to your application logic

        // Calculate recall rate based on signatures count
        $signaturesCount = $signatures->count();
        $recallRate = ($signaturesCount / 1000000) * 100;

        return view('mps.show', compact('mp', 'signatures', 'recallRate'));
    }
	
	public function showSignatures(Mp $mp)
	{
		$mp->load('signatures'); 
		$signaturesCount = $mp->signatures->count();
		$recallRate = ($signaturesCount / 1000000) * 100;

		// Debugging statements
		dd(compact('mp', 'recallRate', 'signaturesCount'));

		return view('mps.show', compact('mp', 'recallRate', 'signaturesCount'));
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
