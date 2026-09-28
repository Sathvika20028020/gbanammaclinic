<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Installation Details</title>

    <style>
        @page {
            size: A4;
            margin: 10mm; /* Reduced margin to gain space */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px; /* Slightly smaller font */
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.2;
        }

        .header {
            margin-bottom: 10px;
            border-bottom: 2px solid #444;
            padding-bottom: 8px;
        }

        .header img {
            width: 100px; /* Smaller logo */
            vertical-align: middle;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-left: 10px;
            vertical-align: middle;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px; /* Reduced spacing between tables */
        }

        td {
            border: 1px solid #999;
            padding: 6px 10px; /* Compact padding */
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 30%;
            background: #f5f5f5;
        }

        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin: 8px 0 4px;
            color: #000;
            text-transform: uppercase;
            border-left: 3px solid #444;
            padding-left: 8px;
        }

        .img-preview {
            max-width: 100%;
            width: auto;
            max-height: 380px; /* Strict height limit to keep it on one page */
            border-radius: 4px;
            border: 1px solid #aaa;
            display: block;
        }

        .img-container {
            text-align: left;
            padding: 5px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('storage/mcware-logo.png') }}">
        <span class="header-title">
            GBA NAMMA CLINIC - INTERNET SERVICES
        </span>
    </div>

    {{-- USER DETAILS --}}
    <div class="section-title">User Information</div>
    <table>
        <tr>
            <td class="label">Clinic</td>
            <td>{{ $installation->user->clinic_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Ward</td>
            <td>{{ $installation->user->ward->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Name</td>
            <td>{{ $installation->user->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Phone</td>
            <td>{{ $installation->user->phone ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>{{ $installation->user->email ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- INSTALLATION DETAILS --}}
    <div class="section-title">Installation Information</div>
    <table>
        <tr>
            
            <td>
                {{ $installation->installed_on
                    ? \Carbon\Carbon::parse($installation->installed_on)->format('d M Y')
                    : 'N/A' }}
            </td>
        </tr>
        <tr>
            <td class="label">Validity</td>
            <td>6 Months</td>
        </tr>
        <tr>
           
            <td>{{ $installation->comments ?: '—' }}</td>
        </tr>
    </table>

    {{-- INSTALLATION IMAGE --}}
    @if ($installation->image)
        <div class="section-title">Installation Image</div>
        <table>
            <tr>
                <td class="img-container">
                    <img 
                        src="{{ public_path('storage/' . $installation->image) }}" 
                        class="img-preview"
                    >
                </td>
            </tr>
        </table>
    @endif

</body>
</html>