<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worksurface Measurement Report</title>
    <style>
        @page {
            size: landscape;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Ukuran font kecil */
            margin: 0;
            padding: 0;
        }
        .header, .footer {
            width: 100%;
            position: fixed;
            text-align: center;
            background-color: #ffffff;
        }
        .header {
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            margin: 0;
            font-size: 14px; /* Ukuran font header lebih kecil */
        }
        .footer {
            bottom: 0;
            font-size: 10px; /* Ukuran font footer lebih kecil */
            border-top: 1px solid #dddddd;
            padding: 10px;
        }
        .footer p {
            margin: 0;
        }
        .content {
            margin-top: 60px; /* Margin atas lebih kecil */
            padding-bottom: 60px; /* Padding bawah lebih kecil */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px; /* Ukuran font tabel lebih kecil */
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 6px; /* Padding lebih kecil */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .button-success {
            background-color: #4CAF50;
            color: white;
            padding: 4px 8px; /* Padding lebih kecil */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px; /* Ukuran font tombol lebih kecil */
        }
        .button-danger {
            background-color: #f44336;
            color: white;
            padding: 4px 8px; /* Padding lebih kecil */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px; /* Ukuran font tombol lebih kecil */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Worksurface Measurement Report</h1>
    </div>
    
    <div class="content">
        <p>A1 (Mat surface point to ground): &lt; 1.00E+9 ohm</p>
        <p>A2 (Mat surface static field voltage): &lt; 100 volts</p>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Register No</th>
                    <th>Area</th>
                    <th>Location</th>
                    <th>Item</th>
                    <th>A1 Scientific</th>
                    <th>Judgement A1</th>
                    <th>A2</th>
                    <th>Judgement A2</th>
                    <th>Remarks</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->worksurface->register_no }}</td>
                    <td>{{ $record->worksurface->area }}</td>
                    <td>{{ $record->worksurface->location }}</td>
                    <td>{{ $record->item }}</td>
                    <td>{{ $record->a1_scientific }}</td>
                    <td>
                        @if ($record->judgement_a1 == 'OK')
                            <button class="button-success">OK</button>
                        @else
                            <button class="button-danger">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->a2 }}</td>
                    <td>
                        @if ($record->judgement_a2 == 'OK')
                            <button class="button-success">OK</button>
                        @else
                            <button class="button-danger">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->remarks }}</td>
                    <td>{{ $record->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        <p>QR-ADM-24-K056 (Rev-00) | Print on: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
