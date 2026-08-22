@extends('admin.layout.admin')

@section('title', 'Thông tin website')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cấu hình giao dịch xu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Thông tin trang web</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('coin_information_employer.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}

                <div class="col-xs-12 col-md-8">

                    <!-- Nội dung thêm mới -->

                    <!-- /.box-header -->
                    @if(!empty($typeInformations))
                    @foreach($typeInformations as $typeinformation)
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $typeinformation->title }}</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <input type="hidden" value="{{ $typeinformation->slug }}" name="slug_type_input[]"/>

                                    @if ($typeinformation->type_input == 'one_line')
                                        <input type="text" class="form-control" name="content[]"
                                               placeholder="{{ $typeinformation->placeholder }}"
                                               value="{{ $typeinformation->information }}"/>
                                    @endif

                                    @if ($typeinformation->type_input == 'multi_line')
                                        <textarea rows="4" class="form-control" name="content[]"
                                                  placeholder="{{ $typeinformation->placeholder }}">{{ $typeinformation->information }}</textarea>
                                    @endif

                                    @if ($typeinformation->type_input == 'editor')
                                        <textarea class="editor" id="{{$typeinformation->slug}}" name="content[]"
                                                  rows="10" cols="80"
                                                  placeholder="{{ $typeinformation->placeholder }}"/>{{ $typeinformation->information }}</textarea>
                                    @endif

                                    @if ($typeinformation->type_input == 'image')
                                        <div>
                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                   size="20"/>
                                            <img class="lazy" src="{{ $typeinformation->information }}" width="80" height="70"/>
                                            <input name="content[]" type="hidden"
                                                   value="{{ $typeinformation->information }}"/>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                @endforeach

                    @endif
                <!-- /.box-body -->

                    <!-- /.box -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thông tin thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

