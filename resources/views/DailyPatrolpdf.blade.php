<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Patrol Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px; /* Ukuran font kecil */
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
        .button-warning {
            background-color: #ff9800;
            color: white;
            padding: 4px 8px; /* Padding lebih kecil */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px; /* Ukuran font tombol lebih kecil */
        }
        .image-column img {
            width: 100px; /* Lebar gambar */
            height: auto; /* Tinggi otomatis */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Patrol Report</h1>
    </div>
    
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description of Problem</th>
                    <th>Area</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Photo Before</th>
                    <th>Photo After</th>
                    <th>Corrective Action</th>
                    <th>Date of Corrective Action</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->description_problem }}</td>
                    <td>{{ $record->area }}</td>
                    <td>{{ $record->location }}</td>
                    <td>
                        @if ($record->status == 'OPEN')
                            <button class="button-danger">OPEN</button>
                        @elseif ($record->status == 'WAITING MATERIAL')
                            <button class="button-warning">WAITING MATERIAL</button>
                        @else
                            <button class="button-success">CLOSED</button>
                        @endif
                    </td>
                    <td class="image-column"><img src="{{ $record->photo_before }}" alt="Photo Before"></td>
                    <td class="image-column"><img src="{{ $record->photo_after }}" alt="Photo After"></td>
                    <td>{{ $record->corrective_action }}</td>
                    <td>{{ $record->date_corrective ? $record->date_corrective->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $record->created_at ? $record->created_at->format('Y-m-d') : 'N/A' }}</td>
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
