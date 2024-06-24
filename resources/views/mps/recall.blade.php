@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Recall Your MP - {{ $mp->name }}</h1>

        <form action="{{ route('mps.recall-store', $mp->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="reason">Reason for Recall</label>
                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Recall MP</button>
        </form>
    </div>
@endsection
