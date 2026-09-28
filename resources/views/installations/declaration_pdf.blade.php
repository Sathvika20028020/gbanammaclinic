<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Installation Declaration</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
        }

        .label {
            width: 30%;
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            max-height: 80px;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .signature-box {
            height: 40px;
        }
    </style>
</head>
<body>

@php
    $logoPath = public_path('storage/BBMPlogo.png');
@endphp

<div class="logo">
    @if (file_exists($logoPath))
        <img src="{{ $logoPath }}">
    @else
        <strong>Organization Logo</strong>
    @endif
</div>

<h2>Declaration of Internet Installation</h2>

<p>
    We hereby declare that the internet installation has been successfully completed
    at the specified location as per the approved requirements and agreed scope of work.
</p>

<p>
    The installation activities were carried out in a safe and professional manner.
    During the installation process, no harm, damage, or alteration was caused to the
    existing infrastructure, property, equipment, or environment.
</p>

<p>
    The internet connection, cabling, devices, and related components were installed
    and configured according to the technical requirements provided by the client.
    Post-installation checks were performed, and the internet service is functioning
    as expected.
</p>

<p>
    We confirm that the installation has been completed satisfactorily and in
    compliance with the stated requirements.
</p>

<p>
    Internet ID pass has been received from the technical team.
</p>

<table>
    <tr>
        <td class="label">Installation Location</td>
        <td>
            Ward:
            {{ optional(optional($installation->user)->ward)->name ?? 'N/A' }} <br>
            Latitude:
            {{ optional($installation->user)->latitude ?? 'N/A' }} <br>
            Longitude:
            {{ optional($installation->user)->longitude ?? 'N/A' }}
        </td>
    </tr>

    <tr>
        <td class="label">Installation Date</td>
        <td>
            {{ $installation->installed_on
                ? \Carbon\Carbon::parse($installation->installed_on)->format('d M Y')
                : 'N/A' }}
        </td>
    </tr>

    <tr>
        <td class="label">Doctor Name</td>
        <td>
            {{ optional($installation->user)->name ?? 'N/A' }}
        </td>
    </tr>
</table>

<table>
    <tr>
        <td class="label">Signature 1</td>
        <td class="signature-box"></td>
    </tr>
    <tr>
        <td class="label">Signature 2</td>
        <td class="signature-box"></td>
    </tr>
    <tr>
        <td class="label">Signature 3</td>
        <td class="signature-box"></td>
    </tr>
</table>

</body>
</html>
