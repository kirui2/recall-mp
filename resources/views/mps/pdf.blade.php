<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mp->name }} Recall Report</title>
    <style>
        /* Define your PDF styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .signature-list {
            margin-top: 20px;
        }
        .signature-item {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>{{ $mp->name }} Recall Report</h1>
        <p>Recall Rate: {{ $recallRate }}%</p>
    </div>

    <div class="signature-list">
        <h2>Signatures</h2>
        <ul>
            @foreach ($signatures as $signature)
                <li class="signature-item">{{ $signature->name }} - {{ $signature->created_at->format('Y-m-d') }}</li>
                <!-- Add more signature details as needed -->
            @endforeach
        </ul>
    </div>
</body>
</html>
