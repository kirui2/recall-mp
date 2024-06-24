@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>MPs Who Voted Yes for Finance Bill 2024</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>County</th>
                    <th>Constituency</th>
                    <th>Recall Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mps as $mp)
                    <tr>
                        <td><a href="{{ route('mps.show', $mp) }}">{{ $mp->name }}</a></td>
                        <td>{{ $mp->role }}</td>
                        <td>{{ $mp->county->name }}</td>
                        <td>{{ $mp->constituency->name }}</td>
                        <td>{{ $mp->recall_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
