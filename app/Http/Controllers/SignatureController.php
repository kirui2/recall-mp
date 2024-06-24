<?php

namespace App\Http\Controllers;

use App\Models\Mp;
use App\Models\Signature;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SignatureController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log request data for debugging
            Log::info('Store method called');
            Log::info('Request data', $request->all());

            // Validate the request data
            $validatedData = $request->validate([
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

            Log::info('Validation passed', $validatedData);

            // Wrap operations in a transaction
            DB::transaction(function () use ($request, $validatedData) {
                // Create new signature
                $signature = new Signature($validatedData);

                // Store the signature image
                if ($request->hasFile('signature_image')) {
                    $signature->signature_image = $request->file('signature_image')->store('signatures', 'public');
                }

                $signature->save();

                Log::info('Signature saved', ['signature_id' => $signature->id]);

                // Find the MP and increment the recall count
                $mp = Mp::find($request->mp_id);

                if ($mp) {
                    $mp->recall_count += 1;
                    $mp->save();

                    Log::info('MP updated', ['mp_id' => $mp->id, 'recall_count' => $mp->recall_count]);
                } else {
                    Log::error('MP not found', ['mp_id' => $request->mp_id]);
                }
            });

            // Flash success message
            session()->flash('success', 'MP recalled successfully');
        } catch (\Exception $e) {
            Log::error('Error storing signature', ['message' => $e->getMessage()]);
            // Flash error message
            session()->flash('error', 'Failed to recall MP. Please try again later.');
        }

        return redirect()->route('mps.show', $request->mp_id);
    }

    public function fetchConstituencies($countyId)
{
    $constituencies = \App\Models\Constituency::where('county_id', $countyId)->get();
    return response()->json($constituencies);
}

public function fetchWards($constituencyId)
{
    $wards = Ward::where('constituency_id', $constituencyId)->get();
    return response()->json($wards);
}
}
