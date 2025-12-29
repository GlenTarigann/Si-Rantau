<!DOCTYPE html>
<html>

<head>
    <title>Meal Plan Itinerary</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1A237E;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #1A237E;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f8f9fa;
            color: #1A237E;
            padding: 10px;
            border: 1px solid #dee2e6;
            text-transform: uppercase;
            font-size: 10px;
        }

        td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            background: #eee;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>MEAL PLAN</h2>
        <p>Personal Assistant Mahasiswa Rantau</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Menu Masakan</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meals as $index => $m)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($m->planned_date)->translatedFormat('d F Y') }}</td>
                <td><span class="badge">{{ $m->meal_time }}</span></td>
                <td class="text-left"><strong>{{ $m->recipe_name }}</strong></td>
                <td class="text-left">{{ $m->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i') }}
    </div>
</body>

</html>