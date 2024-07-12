<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            width: 100%;
            position: fixed;
            text-align: center;
        }
        .header {
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }
        .header .title-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            text-align: center;
            margin-bottom: 30px; /* Adjust the margin as needed */
        }
        .header img {
            height: 50px; /* Adjust the height as needed */
        }
        .footer {
            bottom: 0;
            font-size: 12px;
        }
        .content {
            margin-top: 150px; /* Adjusted margin to create space between header and table */
            margin-bottom: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Added margin to create space below "Print on" */
            margin-bottom: 20px;
            font-size: 12px; /* Reduced font size */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title-container">
            <img src="{{ asset('images/esd.png') }}" alt="Left Image">
            <h1>User Report</h1>
        </div>
    </div>
    
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->email }}</td>
                    <td>{{ $record->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        <p>QR-ADM-24-K056 (Rev-00) | Print on: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s') }}</p>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                if ($PAGE_COUNT > 1) {
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $size = 12;
                    $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                    $y = 15;
                    $x = 520;
                    $pdf->text($x, $y, $pageText, $font, $size);
                }
            ');
        }
    </script>
</body>
</html>
