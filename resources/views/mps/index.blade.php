@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>MPs who voted yes</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>County</th>
                    <th>Constituency</th>
                    <th>Recall Rate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mps as $mp)
                    <tr>
                        <td>{{ $mp->name }}</td>
                        <td>{{ $mp->role }}</td>
                        <td>{{ optional($mp->county)->name ?? 'N/A' }}</td>
                        <td>{{ optional($mp->subcounties)->name ?? 'N/A' }}</td>
                        <td>{{ (intval($mp->recall_count) / 1000000) * 100 }}%</td>
                        <td>
                            <a href="{{ route('mps.show', $mp->id) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('mps.show-signatures', $mp->id) }}" class="btn btn-primary btn-sm">View Signatures</a>
                            <a href="{{ route('mps.download-pdf', $mp->id) }}" class="btn btn-primary btn-sm">Download PDF</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
