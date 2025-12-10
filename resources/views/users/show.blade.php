@extends('layouts.master')

@section('title', 'User - View Profile')
@section('page_title', 'View Profile')

@section('breadcrumb')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@push('css')
<style>
    .container-custom {
        max-width: 900px;
        margin: 0 auto;
    }

    .card-box {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .detail-table td {
        padding: 12px 16px;
        border: 1px solid #dfdfdf;
        font-size: 16px;
    }

    .label-col {
        font-weight: bold;
        background: #f7f7f7;
        width: 35%;
    }

    .img-preview {
        max-width: 350px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }

    @media print {
        .no-print, nav, header, footer, .breadcrumb {
            display: none !important;
        }

        body {
            margin: 0;
            padding: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="container-custom">
    <div class="card-box">

        {{-- ACTION BUTTONS: only if installation exists --}}
        @if ($user->installation)
        <div class="d-flex justify-content-end gap-2 no-print mb-3">

            {{-- DOWNLOAD FULL USER PROFILE PDF --}}
            <a href="{{ route('users.pdf', $user->id) }}" class="btn btn-success">
                <i class="bi bi-download"></i> Download PDF
            </a>

            {{-- PRINT PAGE --}}
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Print
            </button>

        </div>
        @endif


        {{-- Basic Details --}}
        <h4>Basic Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Ward</td>
                <td>{{ $user->ward->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label-col">Clinic Name</td>
                <td>{{ $user->clinic_name }}</td>
            </tr>
            <tr>
                <td class="label-col">Internet Status</td>
                <td>{{ $user->internet_status }}</td>
            </tr>
            <tr>
                <td class="label-col">Internet Speed</td>
                <td>{{ $user->internet_speed }}</td>
            </tr>
            <tr>
                <td class="label-col">Bandwidth</td>
                <td>{{ $user->bandwidth }}</td>
            </tr>
            <tr>
                <td class="label-col">Latitude</td>
                <td>{{ $user->latitude ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label-col">Longitude</td>
                <td>{{ $user->longitude ?? 'N/A' }}</td>
            </tr>
        </table>


        {{-- Communication Details --}}
        <h4 class="mt-4">Communication Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Name</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label-col">Phone</td>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <td class="label-col">Email</td>
                <td>{{ $user->email }}</td>
            </tr>
        </table>


        {{-- Installation Details --}}
        @if ($user->installation)
        <h4 class="mt-4">Installation Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Installed On</td>
                <td>{{ \Carbon\Carbon::parse($user->installation->installed_on)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="label-col">Expires On</td>
                <td>{{ \Carbon\Carbon::parse($user->installation->installed_on)->addMonths(6)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="label-col">Comments</td>
                <td>{{ $user->installation->comments ?? '—' }}</td>
            </tr>
            @if ($user->installation->routes)
            <tr>
                <td class="label-col">Routes Provided</td>
                <td>{{ $user->installation->routes }}</td>
            </tr>
            @endif
            @if ($user->installation->cables)
            <tr>
                <td class="label-col">Cables Provided</td>
                <td>{{ $user->installation->cables }}</td>
            </tr>
            @endif
        </table>

        {{-- Installation Image --}}
        @if ($user->installation->image)
        <h4 class="mt-4">Installation Image</h4>
        <div class="text-center">
            <img src="{{ asset('storage/' . $user->installation->image) }}" class="img-preview">
        </div>
        @endif

        @endif

    </div>
</div>
@endsection
