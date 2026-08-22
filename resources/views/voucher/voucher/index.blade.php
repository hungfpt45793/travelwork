@extends('admin.layout.admin')

@section('title', 'Tài liệu')

@section('content')
    <style>
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 34px;
            user-select: none;
            -webkit-user-select: none;
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
             Tài liệu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"> Tài liệu </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('voucher.create') }}"><button class="btn btn-primary">Thêm mới  tài liệu</button> </a>

                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif



                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="" method="GET" id="submitForm">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chọn danh mục</label>
                                    <?php
                                    $id_cate_child = isset($_GET['category_voucher']) ?$_GET['category_voucher'] : '';
                                    ?>
                                    <select class="form-control select2" data-placeholder="Chọn danh mục"
                                            style="width: 100%;height: 35px;" name="category_voucher" id="category_voucher">
                                        <option value="0" selected >Chọn danh mục</option>
                                        @foreach($categories_voucher as $category)
                                            <option value="{{ $category->id_cate_child }}" @if($id_cate_child ==  $category->id_cate_child) selected @endif>{{ $category->name_cate_child }}</option>
                                            @endforeach

                                    </select>
                                </div>
                                {{----}}
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nhập tên tài liệu</label>
                                    <?php
                                    $name_voucher = isset($_GET['name_voucher']) ?$_GET['name_voucher'] : '';
                                    ?>
                                    <input type="text" class="form-control w100" name="name_voucher"
                                           placeholder="Tên tài liệu" value="{{ $name_voucher }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chia sẻ bài viết</label>
                                    <?php
                                    $sale_money_get = isset($_GET['sale_money']) ?$_GET['sale_money'] : '';
                                    ?>
                                        <select class="form-control select2" data-placeholder="chia sẻ bài viết"
                                                style="width: 100%;height: 35px;" name="sale_money" id="category_voucher">
                                            <option value="0" selected >Chia sẻ bài viết</option>

                                                <option value="0" @if($sale_money_get ==  '0') selected @endif>Không</option>
                                                <option value="1" @if($sale_money_get ==  '1') selected @endif>Có</option>


                                        </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-center" style="margin-top: 10px;margin-bottom: 15px;">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>

                        </form>

                        <p class=""><span style="color: red ">Có tất cả {{ $total }} tài liệu</span></p>
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên  tài liệu</th>
                                <th>Link tài liệu</th>
                                <th>Slug  tài liệu</th>
                                <th>File tài liệu</th>
                                <th>Ảnh mô tả</th>
                                <th>Chia sẻ bài viết</th>

                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vouchers as $id => $voucher )
                                <tr>
                                    <td>{{ $voucher->id_voucher }}</td>
                                    <td>{{ $voucher->name_voucher }}</td>
                                    <td><a href="{{ route('getVoucher',['slug_voucher'=>$voucher->slug_voucher]) }}">Link</a></td>
                                    <td>{{ $voucher->slug_voucher }}</td>
                                    <td>{{ $voucher->link_dowload_voucher }}</td>

                                    <td><img src="{{ $voucher->image_voucher }}" style="width: 50px"> </td>
                                    <td>
                                        @if($voucher->sale_money == 0)
                                            <span class="red">Không</span>
                                        @endif
                                        @if($voucher->sale_money == 1)
                                            <span class="green">Có</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('voucher.edit', ['id_voucher' => $voucher->id_voucher]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('voucher.destroy', ['id_voucher' => $voucher->id_voucher]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">{{ $vouchers->links() }}</div>

                        {{--<script type="text/javascript">--}}
                            {{--$(document).ready(function() {--}}
                                {{--$('#voucher').DataTable( {--}}
                                    {{--"language": {--}}
                                        {{--"url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"--}}
                                    {{--}--}}
                                {{--} );--}}
                            {{--} );--}}
                        {{--</script>--}}

                        {{--<div>{{ $vouchers->links() }}</div>--}}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <script>
        $( document ).ready(function() {
            $('#category_voucher').change(function(){
                $('#submitForm').submit();
            });
        });

    </script>
    @include('admin.partials.popup_delete')
@endsection

