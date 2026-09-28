<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clinic Complaints</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Data collected from whatsapp</h2>

<table>
    <thead>
        <tr>
            <th>Sl No.</th>
            <th>PHC</th>
            <th>Clinic Name</th>
            <th>Doctor</th>
            <th>Phone</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($complaints as $i => $c)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $c->phc }}</td>
                <td>{{ $c->clinic_name }}</td>
                <td>{{ $c->doctor_name ?? '—' }}</td>
                <td>{{ $c->phone }}</td>
                <td>{{ $c->lat }}</td>
                <td>{{ $c->lng }}</td>
                <td>{{ $c->created_at->format('d M Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
