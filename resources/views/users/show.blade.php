@extends('layouts.master')

@section('title', 'User - View Profile')
@section('page_title', 'View')

@section('breadcrumb')
    <li class="breadcrumb-item">Profile</li>
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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .detail-table td {
            padding: 14px 18px;
            border: 1px solid #dfdfdf;
            font-size: 17px;
        }

        .label-col {
            font-weight: bold;
            background: #f7f7f7;
            width: 35%;
        }
    </style>
@endpush

@section('content')
    <div class="container-custom">
        <div class="card-box">

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
            </table>

            <h4 class="mt-3">Communications Details</h4>
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

            <h4 class="mt-3">Plan Details</h4>
            <table class="detail-table">
                <tr>
                    <td class="label-col">Internet Speed</td>
                    <td>{{ $user->internet_speed }}</td>
                </tr>
                <tr>
                    <td class="label-col">Bandwidth</td>
                    <td>{{ $user->bandwidth }}</td>
                </tr>
            </table>

        </div>
    </div>



@endsection
