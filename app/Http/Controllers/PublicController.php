<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MP;
use App\Models\Signature;

class PublicController extends Controller
{
    public function index() {
        $mps = MP::where('voted_yes', true)->get();
        return view('public.index', compact('mps'));
    }

    public function show(MP $mp) {
        return view('public.show', compact('mp'));
    }

    public function storeSignature(Request $request) {
        $data = $request->validate([
            'id_card' => 'required|unique:signatures',
            'name' => 'required',
            'signature_image' => 'required|image',
            'mp_id' => 'required|exists:mps,id',
            'county_id' => 'required',
            'constituency_id' => 'required',
            'ward' => 'required',
            'polling_station' => 'required',
            'polling_center' => 'required',
            'polling_station_number' => 'required',
        ]);

        Signature::create($data);

        // Update MP recall count
        $mp = MP::find($data['mp_id']);
        $mp->recall_count += 1;
        $mp->save();

        return redirect()->back()->with('success', 'Signature added successfully!');
    }

    public function recallStatus() {
        $mps = MP::where('voted_yes', true)->get();
        return view('public.recall_status', compact('mps'));
    }
}
