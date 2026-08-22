@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$domain->title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa domain {{ $domain->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Domains</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('domains.update', ['domain_id' => $domain->domain_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên domain</label>
                                <input type="text" class="form-control" name="name" placeholder="Tiêu đề"
                                       value="{{ $domain->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Đường dẫn</label>
                                <input type="text" class="form-control" name="url" placeholder="đường dẫn"
                                value="{{ $domain->url }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description" placeholder="">{{ $domain->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Chọn Theme</label>
                                <select class="form-control select2" name="theme_id">
                                    <option value="">---------------</option>
                                    @foreach($themes as $theme)
                                        <option value="{{ $theme->theme_id }}"
                                                @if($theme->theme_id == $domain->theme_id) selected @endif >{{ $theme->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Chọn User</label>
                                <select class="form-control select2" name="user_id">
                                    <option value="">---------------</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                                @if($user->id == $domain->user_id) selected @endif >{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Thời gian sử dụng:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <?php
                                    $date = new DateTime($domain->start_at);
                                    $useStart = $date->format('m/d/Y h:mm A');

                                    $date = new DateTime($domain->end_at);
                                    $useEnd = $date->format('m/d/Y h:mm A');
                                    ?>
                                    <input type="text" class="form-control pull-right" id="reservationtime" name="use_start_end"
                                           @if(!empty($product->discount_start)) value="{{ $useStart }} - {{ $useEnd }}" @endif/>
                                </div>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('url'))
                                    <label for="exampleInputEmail1">{{ $errors->first('url') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
                
            </form>
        </div>
    </section>
@endsection

