@extends('layouts.master')

@section('title','View Internet Data')
@section('page_title', 'Internet Data')
@section('breadcrumb')
    <li class="breadcrumb-item active">show</li>
@endsection
@section('content')

<div class="card">
   

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th>Clinic Name</th>
                <td>Gbanamma Clinic</td>
            </tr>

            <tr>
                <th>Corporation</th>
                <td>BBMP</td>
            </tr>

            <tr>
                <th>Constituency</th>
                <td>Bommanahalli</td>
            </tr>

            <tr>
                <th>Ward</th>
                <td>Ward 189</td>
            </tr>

            <tr>
                <th>Contact Person</th>
                <td>Ramesh Kumar</td>
            </tr>

            <tr>
                <th>Contact Number</th>
                <td>9876543210</td>
            </tr>

            <tr>
                <th>ISP</th>
                <td>ACT</td>
            </tr>

            <tr>
                <th>Internet ID</th>
                <td>ACT123456</td>
            </tr>

            <tr>
                <th>Internet Password</th>
                <td>password123</td>
            </tr>

            <tr>
                <th>Last Recharge</th>
                <td>09-Jul-2026</td>
            </tr>

            <tr>
                <th>Expiry Date</th>
                <td>08-Aug-2026</td>
            </tr>

            <tr>
                <th>Plan Validity</th>
                <td>1 Month</td>
            </tr>

            <tr>
                <th>Status</th>
                <td><span class="badge bg-success">Active</span></td>
            </tr>

        </table>

        <h5 class="mt-5 mb-3">Recharge History (Total Recharges: 3)</h5>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Recharge Date</th>
                    <th>Expiry Date</th>
                    <th>Plan Validity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>3</td>
                    <td>09-Jul-2026</td>
                    <td>08-Aug-2026</td>
                    <td>1 Month</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>09-Jun-2026</td>
                    <td>08-Jul-2026</td>
                    <td>1 Month</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>09-May-2026</td>
                    <td>08-Jun-2026</td>
                    <td>1 Month</td>
                </tr>
            </tbody>
        </table>

       

    </div>
</div>

@endsection