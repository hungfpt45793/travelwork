@extends('admin.layout.admin')

@section('title', 'Thêm mới subcribe email')

@section('content')
    <section class="content-header">
        <h1>
            Thêm mới subcribe email
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Subcribe Email</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('subcribe-email.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>

                        <div class="box-body">


                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhóm (đặt theo slug nhóm ở ngoài danh sách)</label>
                                <input type="text" class="form-control" name="slug_gruop" placeholder="Nhóm (đặt theo slug nhóm ở ngoài danh sách)" />
                            </div>



                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

