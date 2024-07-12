<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garment Measurement Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        @media print {
            @page {
                size: A4; /* Mengatur ukuran halaman potret */
                margin: 10mm; /* Mengatur margin halaman cetak */
            }
            body {
                margin: 0;
            }
        }
        .header, .footer {
            width: 100%;
            text-align: center;
            background-color: #ffffff;
        }
        .header {
            top: 0;
            padding: 10px;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            margin: 0;
            font-size: 16px; /* Mengecilkan ukuran font header */
        }
        .footer {
            bottom: 0;
            font-size: 10px; /* Mengecilkan ukuran font footer */
            border-top: 1px solid #dddddd;
            padding: 10px;
        }
        .footer p {
            margin: 0;
        }
        .content {
            margin-top: 20px; /* Mengurangi jarak antara header dan konten */
            padding-bottom: 50px;
        }
        .content p {
            font-size: 12px; /* Mengecilkan ukuran font teks di atas tabel */
            margin: 5px 0; /* Mengurangi jarak margin atas dan bawah pada teks */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; /* Mengecilkan margin tabel */
            font-size: 10px; /* Mengecilkan ukuran font tabel */
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 4px; /* Mengecilkan padding sel */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .button-ok {
            background-color: #4CAF50;
            color: white;
            padding: 4px 8px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            font-size: 10px; /* Mengecilkan ukuran font tombol */
        }
        .button-ng {
            background-color: #f44336;
            color: white;
            padding: 4px 8px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            font-size: 10px; /* Mengecilkan ukuran font tombol */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Garment Measurement Report</h1>
    </div>
    
    <div class="content">
        <p>D1 (Shirt Point to point): &lt; 1.00E+5 - 1.00E+11 ohm</p>
        <p>D2 (Pants to point): &lt; 1.00E+5 - 1.00E+11 ohm</p>
        <p>D3 (Cap to point): &lt; 1.00E+5 - 1.00E+11 ohm</p>
        <p>D4 (Hijab to point): &lt; 1.00E+5 - 1.00E+11 ohm</p>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>D1 Scientific</th>
                    <th>Judgement D1</th>
                    <th>D2 Scientific</th>
                    <th>Judgement D2</th>
                    <th>D3 Scientific</th>
                    <th>Judgement D3</th>
                    <th>D4 Scientific</th>
                    <th>Judgement D4</th>
                    <th>Remarks</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->garment->nik }}</td>
                    <td>{{ $record->garment->name }}</td>
                    <td>{{ $record->d1_scientific }}</td>
                    <td>
                        @if ($record->judgement_d1 == 'OK')
                            <button class="button-ok">OK</button>
                        @elseif ($record->judgement_d1)
                            <button class="button-ng">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->d2_scientific }}</td>
                    <td>
                        @if ($record->judgement_d2 == 'OK')
                            <button class="button-ok">OK</button>
                        @elseif ($record->judgement_d2)
                            <button class="button-ng">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->d3_scientific }}</td>
                    <td>
                        @if ($record->judgement_d3 == 'OK')
                            <button class="button-ok">OK</button>
                        @elseif ($record->judgement_d3)
                            <button class="button-ng">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->d4_scientific }}</td>
                    <td>
                        @if ($record->judgement_d4 == 'OK')
                            <button class="button-ok">OK</button>
                        @elseif ($record->judgement_d4)
                            <button class="button-ng">NG</button>
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
