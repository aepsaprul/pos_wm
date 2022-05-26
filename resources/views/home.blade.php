
@if (Auth::user()->employee->shop->category == "toko")
    <script>window.location = "{{ URL::route('dashboard.shop') }}";</script>
@else
    <script>window.location = "{{ URL::route('dashboard.index') }}";</script>
@endif

