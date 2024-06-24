@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $mp->name }}</h1>
        <p>Role: {{ $mp->role }}</p>
        <p>County: {{ $mp->county->name }}</p>
        <p>Constituency: {{ $mp->constituency->name }}</p>
        <p>Recall Count: {{ $mp->recall_count }}</p>
    </div>
@endsection
