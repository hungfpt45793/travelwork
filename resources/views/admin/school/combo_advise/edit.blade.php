@extends('admin.layout.admin')

@section('title', 'Cập nhật gói hỗ trợ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật gói hỗ trợ : {{ $combo->combo_title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('combo_advise.update',['combo_ad_id'=> $combo->combo_ad_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên gói hỗ trợ</label>
                                <input type="text" class="form-control" name="combo_title" placeholder="Tên giáo viên" value="{{ !empty($combo->combo_title) ? $combo->combo_title : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá (VND)</label>
                                <input type="text" class="form-control formatPrice" name="combo_price" placeholder="Giá sản phẩm" min="1" value="{{ !empty($combo->combo_price) ? $combo->combo_price : '' }}">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả gói</label>
                                <textarea class="editor" name="combom_des" id="editor">{!! !empty($combo->combom_des) ? $combo->combom_des : ''  !!}</textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection