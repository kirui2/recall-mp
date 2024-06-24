<?php

namespace App\Http\Controllers;

use App\Models\Mp;
use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'id_card' => 'required|string|unique:signatures',
            'signature_image' => 'required|image',
            'county_id' => 'required|integer',
            'constituency_id' => 'required|integer',
            'ward' => 'required|string',
            'polling_station' => 'required|string',
            'polling_center' => 'required|string',
            'polling_station_number' => 'required|string',
            'mp_id' => 'required|integer',
        ]);

        $signature = new Signature($request->all());
        $signature->signature_image = $request->file('signature_image')->store('signatures', 'public');
        $signature->save();

        $mp = Mp::find($request->mp_id);
        $mp->recall_count += 1;
        $mp->save();

        return redirect()->route('mps.show', $mp->id);
    }
}
