@extends('layouts.guest')

@section('title', trans('app.welcome'))

@section('content')
<div class="jumbotron" style="background-color:#d9f676";>
    <h1>DompetKu</h1>
    <p class="lead">DompetKu adalah aplikasi web pembukuan pribadi, dibangun dengan Laravel 5. Ini dirancang untuk pembukuan yang mudah untuk pendapatan dan pengeluaran pribadi.</p>
    <p><a class="btn btn-lg btn-success" href="{{ route('register') }}" role="button">Daftar Sekarang</a></p>
</div>

<div class="row marketing">
    <div class="row">
        <div class="col-lg-4">
            <h4>Tujuan</h4>
            <p>Pembukuan mudah untuk pendapatan dan pengeluaran pribadi (jumlah uang).</p>
        </div>
        <!-- <div class="col-lg-8">
            <h4>Konsep</h4>
            <p>To aquire our objective, we need this features on the application:</p>
            <ul>
                <li>User can register.</li>
                <li>User can see transaction history by date.</li>
                <li>User add transactions for income and spending.</li>
                <li>User can categorize the transaction.</li>
                <li>User can see transaction summary on each month or a year.</li>
            </ul>
        </div> -->
    </div>
</div>
@endsection
<!-- {{ config('app.name', 'laravel') }} -->