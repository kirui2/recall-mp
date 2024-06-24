@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Recall Your MP - {{ $mp->name }}</h1>

        <form action="{{ route('mps.recall-store', $mp->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Full Name" required>
            </div>

            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email Address" required>
            </div>

            <div class="form-group">
                <label for="reason">Reason for Recall</label>
                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="signature_image">Your Signature Image</label><br>
                <input type="file" name="signature_image" id="signature_image" class="form-control-file" required>
            </div>

            <div class="form-group">
                <label for="id_card">National ID</label>
                <input type="text" name="id_card" id="id_card" class="form-control" placeholder="Enter Your National ID Number" required>
            </div>

            <div class="form-group">
                <label for="county_id">County</label>
                <select name="county_id" id="county_id" class="form-control" required>
                    <option value="">Select Your County</option>
                    @foreach($counties as $county)
                        <option value="{{ $county->id }}">{{ $county->county_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="constituency_id">Constituency</label>
                <select name="constituency_id" id="constituency_id" class="form-control" required>
                    <option value="">Select Your Constituency</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ward">Ward</label>
                <select name="ward" id="ward" class="form-control" required>
                    <option value="">Select Ward</option>
                </select>
            </div>

            <div class="form-group">
                <label for="polling_station">Polling Station</label>
                <input type="text" name="polling_station" id="polling_station" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="polling_center">Polling Center</label>
                <input type="text" name="polling_center" id="polling_center" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="polling_station_number">Polling Station Number</label>
                <input type="text" name="polling_station_number" id="polling_station_number" class="form-control" required>
            </div>

            <input type="hidden" name="mp_id" value="{{ $mp->id }}">

            <button type="submit" class="btn btn-primary">Recall MP</button>
        </form>
    </div>

    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Fetch constituencies based on selected county
            $('#county_id').change(function () {
                console.log('County changed'); // Check if this message appears in the console

                var countyId = $(this).val();
                if (countyId) {
                    $.ajax({
                        url: '{{ route("fetch.constituencies", ":countyId") }}'.replace(':countyId', countyId),
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            console.log('Data received:', data); // Check if data is received correctly

                            $('#constituency_id').empty();
                            $('#constituency_id').append('<option value="">Select Constituency</option>');
                            $.each(data, function (key, value) {
                                $('#constituency_id').append('<option value="' + value.id + '">' + value.constituency_name + '</option>');
                            });
                            // Trigger change to load wards for the first constituency
                            $('#constituency_id').trigger('change');
                        },
                        error: function (error) {
                            console.log('Error fetching constituencies:', error);
                        }
                    });
                } else {
                    $('#constituency_id').empty();
                    $('#ward').empty();
                }
            });

            // Fetch wards based on selected constituency
            $('#constituency_id').change(function () {
                var constituencyId = $(this).val();
                if (constituencyId) {
                    $.ajax({
                        url: '{{ route("fetch.wards", ":constituencyId") }}'.replace(':constituencyId', constituencyId),
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#ward').empty();
                            $('#ward').append('<option value="">Select Ward</option>');
                            $.each(data, function (key, value) {
                                $('#ward').append('<option value="' + value.id + '">' + value.ward_name + '</option>');
                            });
                        },
                        error: function (error) {
                            console.log('Error fetching wards:', error);
                        }
                    });
                } else {
                    $('#ward').empty();
                }
            });
        });
    </script>
@endsection
