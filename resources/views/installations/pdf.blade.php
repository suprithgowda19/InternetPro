<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Installation Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 30px;
            background: #fff;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            border-radius: 6px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .row-item {
            margin-bottom: 6px;
        }

        .label {
            font-weight: bold;
        }

        img {
            max-width: 350px;
            border-radius: 6px;
            margin-top: 10px;
            border: 1px solid #ccc;
        }

        .watermark {
            position: fixed;
            top: 35%;
            left: 15%;
            opacity: 0.08;
            font-size: 80px;
            transform: rotate(-30deg);
        }
    </style>
</head>

<body>

    {{-- Optional Watermark --}}
    <div class="watermark">MCWARE REPORT</div>

    <div class="title">Installation Report</div>

    {{-- USER DETAILS --}}
    <div class="section">
        <div class="section-title">User Information</div>

        <div class="row-item"><span class="label">Name:</span> {{ $installation->user->name ?? 'N/A' }}</div>
        <div class="row-item"><span class="label">Clinic:</span> {{ $installation->user->clinic_name ?? 'N/A' }}</div>
        <div class="row-item"><span class="label">Ward:</span> {{ $installation->user->ward->name ?? 'N/A' }}</div>
        <div class="row-item"><span class="label">Phone:</span> {{ $installation->user->phone ?? 'N/A' }}</div>
        <div class="row-item"><span class="label">Email:</span> {{ $installation->user->email ?? 'N/A' }}</div>
    </div>

    {{-- INSTALLATION DETAILS --}}
    <div class="section">
        <div class="section-title">Installation Details</div>

        <div class="row-item">
            <span class="label">Installed On:</span>
            {{ $installation->installed_on ? \Carbon\Carbon::parse($installation->installed_on)->format('d M Y') : 'N/A' }}
        </div>

        <div class="row-item">
            <span class="label">Expires On:</span>
            {{ $installation->installed_on
                ? \Carbon\Carbon::parse($installation->installed_on)->addMonths(6)->format('d M Y')
                : 'N/A' }}
        </div>

        <div class="row-item">
            <span class="label">Comments:</span>
            {{ $installation->comments ?: '—' }}
        </div>
    </div>

    {{-- ITEMS PROVIDED --}}
    @if ($installation->routes || $installation->cables)
        <div class="section">
            <div class="section-title">Items Provided</div>

            <div class="row-item"><span class="label">Routes:</span> {{ $installation->routes ?? 'N/A' }}</div>
            <div class="row-item"><span class="label">Cables:</span> {{ $installation->cables ?? 'N/A' }}</div>
        </div>
    @endif

    {{-- IMAGE --}}
    @if ($installation->image)
        <div class="section">
            <div class="section-title">Installation Image</div>

            <img src="{{ public_path('storage/' . $installation->image) }}" alt="Installation Image">
        </div>
    @endif

</body>

</html>
