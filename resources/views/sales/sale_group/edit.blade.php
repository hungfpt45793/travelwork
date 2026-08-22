@extends('admin.layout.admin')

@section('title', 'Cập nhật danh mục gói bán hàng ' . $saleGroup->list_sales_packages_name)

@section('content')
    <section class="content-header">
        <h1>
            Cập nhật danh mục gói bán hàng {{$saleGroup->list_sales_packages_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bán hàng</a></li>
            <li><a href="#">Danh mục gói bán hàng</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('saleGroup.update',['list_sales_packages_id'=>$saleGroup->list_sales_packages_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12 col-lg-8">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhóm gói bán hàng</label>
                                <input type="text" class="form-control" name="sale_group_name" placeholder="Nhóm gói bán hàng"
                                       value="{{$saleGroup->list_sales_packages_name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="Mô tả">{{$saleGroup->description}}</textarea>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection