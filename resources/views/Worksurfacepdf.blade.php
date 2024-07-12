<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worksurface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content {
            margin: 20px;
            width: 6cm; /* Lebar tabel 6cm */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6px; /* Ukuran font lebih kecil */
        }
        td {
            border: 1px solid #dddddd;
            padding: 1px; /* Padding lebih kecil */
            text-align: center; /* Teks di tengah */
        }
        tr:nth-child(even) {
            background-color: #ffffff; /* Warna latar belakang putih */
        }
        .qr-code img {
            width: 20px; /* Ukuran QR Code sesuai tabel */
            height: 20px; /* Ukuran QR Code sesuai tabel */
        }
    </style>
</head>
<body>
    <div class="content">
        <table>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->register_no }}</td>
                    <td>{{ $record->area }}</td>
                    <td>{{ $record->location }}</td>
                    <td class="qr-code">
                        @php
                            $qrCode = base64_encode(QrCode::format('svg')->size(20)->generate($record->register_no));
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
