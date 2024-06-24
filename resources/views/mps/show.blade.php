@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>MP Details - {{ $mp->name }}</h1>
        <p>Recall Rate: {{ $recallRate }}%</p>

        <h2>Signatures</h2>
        <ul class="list-group">
            @foreach ($mp->signatures as $signature)
                <li class="list-group-item">{{ $signature->name }} - {{ $signature->created_at->format('Y-m-d') }}</li>
                <!-- Display other signature details as needed -->
            @endforeach
        </ul>

        <!-- Link to Recall Form -->
        <a href="{{ route('mps.recall-form', $mp->id) }}" class="btn btn-primary mt-3">Recall Your MP</a>
        
        <!-- Add a button to download PDF file -->
        <a href="{{ route('mps.download-pdf', $mp->id) }}" class="btn btn-primary mt-3">Download PDF</a>
    </div>
@endsection
