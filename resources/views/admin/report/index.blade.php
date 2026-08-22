@extends('admin.layout.admin')

@section('title', 'Danh sách thông báo')

@section('content')
    <div class="list-group">
        <div class="list-group-item active">
            <b>TẤT CẢ THÔNG BÁO.</b>
        </div>
        @foreach($reports as $rp)
            <a href={{ $rp->URL }} id="each_notice" class="list-group-item @if($rp->status == 0 || $rp->status == 1) blue @else white @endif " ><b>{{ $rp->title }}</b> : {{ $rp->content }}</a>
        @endforeach
    </div>
@endsection