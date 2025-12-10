<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>User Profile Details</title>

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.2;
            padding: 0;
            margin: 0;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .section {
            margin-bottom: 10px;
            padding: 8px 10px;
            border: 1px solid #999;
            border-radius: 4px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
            border-bottom: 1px solid #ccc;
        }

        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }

        img {
            max-width: 230px;
            max-height: 140px;
            border-radius: 6px;
            border: 1px solid #aaa;
            margin-top: 6px;
        }
    </style>
</head>

<body>

    <div class="title">User Profile Report</div>

    {{-- BASIC DETAILS --}}
    <div class="section">
        <div class="section-title">Basic Details</div>

        <p><span class="label">Name:</span> {{ $user->name }}</p>
        <p><span class="label">Clinic:</span> {{ $user->clinic_name }}</p>
        <p><span class="label">Ward:</span> {{ $user->ward->name ?? 'N/A' }}</p>
        <p><span class="label">Internet Status:</span> {{ $user->internet_status }}</p>
        <p><span class="label">Internet Speed:</span> {{ $user->internet_speed }}</p>
        <p><span class="label">Bandwidth:</span> {{ $user->bandwidth }}</p>
        <p><span class="label">Latitude:</span> {{ $user->latitude ?? 'N/A' }}</p>
        <p><span class="label">Longitude:</span> {{ $user->longitude ?? 'N/A' }}</p>
    </div>

    {{-- COMMUNICATION --}}
    <div class="section">
        <div class="section-title">Communication Details</div>

        <p><span class="label">Phone:</span> {{ $user->phone }}</p>
        <p><span class="label">Email:</span> {{ $user->email }}</p>
    </div>

    {{-- INSTALLATION --}}
    @if ($user->installation)
        <div class="section">
            <div class="section-title">Installation Details</div>

            <p><span class="label">Installed On:</span>
                {{ \Carbon\Carbon::parse($user->installation->installed_on)->format('d M Y') }}
            </p>

            <p><span class="label">Expires On:</span>
                {{ \Carbon\Carbon::parse($user->installation->installed_on)->addMonths(6)->format('d M Y') }}
            </p>

            @if ($user->installation->routes || $user->installation->cables)
                <p><span class="label">Routes Provided:</span> {{ $user->installation->routes ?? 'N/A' }}</p>
                <p><span class="label">Cables Provided:</span> {{ $user->installation->cables ?? 'N/A' }}</p>
            @endif

            @if ($user->installation->comments)
                <p><span class="label">Comments:</span> {{ $user->installation->comments }}</p>
            @endif

            @if ($user->installation->image)
                <div style="margin-top: 6px;">
                    <div class="section-title">Installation Image</div>
                    <img src="{{ public_path('storage/' . $user->installation->image) }}">
                </div>
            @endif
        </div>
    @endif

</body>

</html>
