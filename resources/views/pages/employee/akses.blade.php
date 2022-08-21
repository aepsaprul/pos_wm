@extends('layouts.app')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex justify-content-between">
                        <h5 class="m-0 text-uppercase">Hak Akses <b>{{ $employee->full_name }}</b>  </h5>
                        <a href="{{ route('employee.index') }}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('employee.akses_store') }}" method="post">
                                @csrf
                                <table class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-indigo">Main</th>
                                            <th class="text-center text-indigo">Sub</th>
                                            <th class="text-center text-indigo">Button</th>
                                            <th class="text-center text-indigo">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nav_mains as $iteme)
                                            <tr>
                                                <td rowspan="{{ count($iteme->navigasiButton) }}" style="padding: 5px;">{{ $iteme->title }}</td>
                                                @foreach($iteme->navigasiSub as $item)
                                                        <td rowspan="{{ count($item->navigasiButton) }}" style="padding: 5px;">
                                                            @if ($item->title != $iteme->title)
                                                                {{ $item->title }}
                                                            @endif
                                                        </td>
                                                        @foreach ($item->navigasiButton as $item_nav_button)
                                                            <td style="padding: 5px;">
                                                                {{ $item_nav_button->title }}
                                                            </td>
                                                            <td class="text-center" style="padding: 5px;">
                                                                <input type="checkbox" id="button_check_{{ $item_nav_button->id }}" name="button_check[]" value="{{ $item_nav_button->id }}"
                                                                @foreach ($nav_access as $item_nav_access)
                                                                    @if ($item_nav_access->button_id == $item_nav_button->id)
                                                                        {{ checked }}
                                                                    @endif
                                                                @endforeach
                                                                >
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary" style="width: 130px;"><i class="fas fa-save"></i> Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

@endsection
