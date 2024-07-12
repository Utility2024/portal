<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ionizer Measurement Report</title>
    <style>
        @page {
            size: landscape;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
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
        }

        .footer {
            bottom: 0;
            font-size: 12px;
            border-top: 1px solid #dddddd;
            padding: 10px;
        }

        .footer p {
            margin: 0;
        }

        .content {
            margin-top: 80px;
            padding-bottom: 80px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
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
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-danger {
            background-color: #f44336;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        @media print {
            body {
                width: 100%;
                margin: 0;
            }
            .header, .footer {
                position: absolute;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ionizer Measurement Report</h1>
    </div>
    
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Register No</th>
                    <th>Area</th>
                    <th>Location</th>
                    <th>PM 1</th>
                    <th>PM 2</th>
                    <th>PM 3</th>
                    <th>C1</th>
                    <th>Judgement C1</th>
                    <th>C2</th>
                    <th>Judgement C2</th>
                    <th>C3</th>
                    <th>Judgement C3</th>
                    <th>Remarks</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->ionizer->register_no }}</td>
                    <td>{{ $record->ionizer->area }}</td>
                    <td>{{ $record->ionizer->location }}</td>
                    <td>
                        @if ($record->pm_1 == 'NO')
                            <button class="button-success">NO</button>
                        @else
                            <button class="button-danger">FLASH</button>
                        @endif
                    </td>
                    <td>
                        @if ($record->pm_2 == 'OK')
                            <button class="button-success">OK</button>
                        @else
                            <button class="button-danger">NO</button>
                        @endif
                    </td>
                    <td>
                        @if ($record->pm_3 == 'YES')
                            <button class="button-success">YES</button>
                        @else
                            <button class="button-danger">NO</button>
                        @endif
                    </td>
                    <td>{{ $record->c1 }}</td>
                    <td>
                        @if ($record->judgement_c1 == 'OK')
                            <button class="button-success">OK</button>
                        @else
                            <button class="button-danger">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->c2 }}</td>
                    <td>
                        @if ($record->judgement_c2 == 'OK')
                            <button class="button-success">OK</button>
                        @else
                            <button class="button-danger">NG</button>
                        @endif
                    </td>
                    <td>{{ $record->c3 }}</td>
                    <td>
                        @if ($record->judgement_c3 == 'OK')
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
