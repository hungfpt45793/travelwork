@extends('admin.layout.admin')

@section('title', 'Sửa yêu cầu NTD')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa yêu cầu NTD
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('employer_select_response.update', ['employer_select_response_id'=> $employer_select_response->employer_select_response_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung Sửa -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Sửa yêu cầu NTD</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Yêu cầu</label>
                                <input type="text" class="form-control" name="response" placeholder="Yêu cầu" value="{{ isset($employer_select_response->response) ? $employer_select_response->response : '' }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Sửa</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
