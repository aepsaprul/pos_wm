{{-- @if (Auth::user()->employee)
    @if (Auth::user()->employee->shop->category == "toko")
        <script>window.location = "{{ URL::route('dashboard.shop') }}";</script>
    @else
        <script>window.location = "{{ URL::route('dashboard.index') }}";</script>
    @endif
@else
    <script>window.location = "{{ URL::route('dashboard.index') }}";</script>
@endif --}}

@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-4 text-center">
                    <h1 class="text-uppercase">Selamat Datang</h1>
                    <h1 class="text-uppercase">{{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection




