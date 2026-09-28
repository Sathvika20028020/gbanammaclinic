<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GBA - Namma Clinic Report</title>

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .section {
            border: 1px solid #dcdcdc;
            margin-bottom: 15px;
        }

        .section-header {
            background: #f3f3f3;
            padding: 8px;
            font-weight: bold;
            color: #1a5a96;
            border-bottom: 1px solid #dcdcdc;
            text-transform: uppercase;
        }

        .section-body {
            padding: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            width: 110px;
            font-weight: bold;
            color: #555;
        }

        .value {
            border-bottom: 1px solid #eee;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a5a96;
        }

        .header-table td {
            vertical-align: middle;
            padding-bottom: 10px;
        }

        .report-title {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #1a5a96;
        }

        .installation-img {
            width: 350px;
            height: 220px;
            border: 1px solid #ccc;
        }

        .field-line {
            border-bottom: 1px solid #000;
            height: 18px;
            margin-top: 5px;
            margin-bottom: 12px;
        }

        .signature-box {
            margin-top: 60px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 90%;
            margin: auto;
            padding-top: 5px;
            font-size: 10px;
        }

        .two-column {
            width: 100%;
            border-collapse: collapse;
        }

        .two-column td {
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }
    </style>
</head>
<body>

@php
    $logoPath = public_path('storage/mcware-logo.png');
@endphp

<table class="header-table">
    <tr>
        <td width="35%">
            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" width="130">
            @endif
        </td>

        <td width="65%" class="report-title">
            CLINIC INSTALLATION REPORT
        </td>
    </tr>
</table>

<table class="two-column">
    <tr>
        <td>
            <div class="section">
                <div class="section-header">
                    Location Details
                </div>

                <div class="section-body">
                    <table class="data-table">
                        <tr>
                            <td class="label">Clinic</td>
                            <td class="value">{{ $user->clinic_name }}</td>
                        </tr>

                        <tr>
                            <td class="label">Ward</td>
                            <td class="value">{{ $user->ward->name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <td class="label">Constituency</td>
                            <td class="value">
                                {{ optional(optional($user->ward)->constituency)->name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="label">Lat/Long</td>
                            <td class="value">
                                {{ $user->latitude ?? '0' }},
                                {{ $user->longitude ?? '0' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>

        <td>
            <div class="section">
                <div class="section-header">
                    Point of Contact
                </div>

                <div class="section-body">
                    <table class="data-table">
                        <tr>
                            <td class="label">Name</td>
                            <td class="value">{{ $user->name }}</td>
                        </tr>

                        <tr>
                            <td class="label">Phone</td>
                            <td class="value">{{ $user->phone }}</td>
                        </tr>

                        <tr>
                            <td class="label">Email</td>
                            <td class="value">{{ $user->email }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="section">
    <div class="section-header">
        Service & Package Details
    </div>

    <div class="section-body">

        <table class="two-column">
            <tr>
                <td>
                    <table class="data-table">
                        <tr>
                            <td class="label">Internet</td>
                            <td class="value">
                                {{ $user->internet_speed }}
                            </td>
                        </tr>

                        <tr>
                            <td class="label">Bandwidth</td>
                            <td class="value">
                                {{ $user->bandwidth }}
                            </td>
                        </tr>
                    </table>
                </td>

                <td>
                    <table class="data-table">
                        <tr>
                            <td class="label">Hardware</td>
                            <td class="value">
                                Router, Cables, Adapter
                            </td>
                        </tr>

                        <tr>
                            <td class="label">Validity</td>
                            <td class="value">
                                6 Months
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</div>

@php
    $imagePath = null;

    if (optional($user->installation)->image) {
        $filename = basename($user->installation->image);
        $imagePath = storage_path('app/public/installation_images/' . $filename);
    }
@endphp

@if($imagePath && file_exists($imagePath))
    <div class="section">
        <div class="section-header">
            Installation Evidence (Photo)
        </div>

        <div class="section-body">
            <img src="{{ $imagePath }}" class="installation-img">
        </div>
    </div>
@endif

<table class="two-column">
    <tr>

        <td>
            <div class="section">
                <div class="section-header">
                    Doctor's Acknowledgement
                </div>

                <div class="section-body">

                    <strong>Name:</strong>
                    <div class="field-line"></div>

                    <strong>Designation:</strong>
                    <div class="field-line"></div>

                </div>
            </div>
        </td>

        <td>
            <div class="section">
                <div class="section-header">
                    Signature
                </div>

                <div class="section-body">

                    <div class="signature-box">
                        <div class="signature-line">
                            Authorized Signature
                        </div>
                    </div>

                </div>
            </div>
        </td>

    </tr>
</table>

</body>
</html>