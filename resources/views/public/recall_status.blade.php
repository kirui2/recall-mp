@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Recall Status</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>County</th>
                    <th>Constituency</th>
                    <th>Recall Count</th>
                    <th>Recall Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mps as $mp)
                    <tr>
                        <td>{{ $mp->name }}</td>
                        <td>{{ $mp->role }}</td>
                        <td>{{ $mp->county->name }}</td>
                        <td>{{ $mp->constituency->name }}</td>
                        <td>{{ $mp->recall_count }}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ ($mp->recall_count / 1000000) * 100 }}%" aria-valuenow="{{ ($mp->recall_count / 1000000) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
