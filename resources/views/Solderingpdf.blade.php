<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soldering</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content {
            margin: 20px;
            width: 10cm; /* Lebar tabel 10cm */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px; /* Ukuran font lebih kecil */
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 6px; /* Padding lebih kecil */
            text-align: center; /* Teks di tengah */
        }
        th {
            background-color: #f2f2f2; /* Warna latar belakang abu-abu muda */
        }
        tr:nth-child(even) {
            background-color: #ffffff; /* Warna latar belakang putih */
        }
        .header-row td {
            font-weight: bold; /* Font tebal untuk nama kolom */
            background-color: #f2f2f2; /* Warna latar belakang abu-abu muda */
        }
    </style>
</head>
<body>
    <div class="content">
        <table>
            <tbody>
                <tr class="header-row">
                    <td>Register No</td>
                    <td>Area</td>
                    <td>Location</td>
                    <td>QR Code</td>
                </tr>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->register_no }}</td>
                    <td>{{ $record->area }}</td>
                    <td>{{ $record->location }}</td>
                    <td>
                        @php
                            $qrCode = base64_encode(QrCode::format('svg')->size(50)->generate($record->register_no));
                        @endphp
                        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
