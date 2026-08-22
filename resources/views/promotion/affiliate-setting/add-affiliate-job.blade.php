@extends('admin.layout.admin')

@section('title', 'Khuyến mại theo từng việc làm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Khuyến mại theo từng việc làm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khuyến mại theo từng việc làm</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('affiliate-group.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Khuyến mại theo từng việc làm</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên chương trình</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên đợi phát hành" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea class="form-control" id="content" name="content" rows="3" cols="80"/></textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                <input type="date" class="form-control" name="title" placeholder="Tên đợi phát hành" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày kết thúc</label>
                                <input type="date" class="form-control" name="title" placeholder="Tên đợi phát hành" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Độ ưu tiên</label>
                                <select class="form-control">
                                    <option>Số 1 (cao nhất)</option>
                                    <option>Số 2</option>
                                    <option>Số 3</option>
                                    <option>Số 4</option>
                                    <option>Số 5</option>
                                </select>
                                <p>Độ ưu tiên được tính từ 1 tới 5. Hệ thống sẽ tự động áp dụng chương trình có độ ưu tiên cao nhất.</p>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

                <!-- /.box -->
                <div class="col-xs-12 col-md-12">
                    <div class="box box-header">
                        <h3>Sản phẩm</h3>

                        <div class="col-xs-8">
                            <label>Sản phẩm (*)</label>
                            <input class="form-control" value="" />
                        </div>

                    </div>

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-body">
                            <table id="jobs" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã việc làm</th>
                                        <th>Tên việc làm</th>
                                        <th>Giá</th>
                                        <th>Nhóm việc làm</th>
                                        <th>Chiết khấu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>232</td>
                                        <td>12 CUỐN SÁCH NGẮN GỌN, DỄ HIỂU BỒI DƯỠNG KỸ NĂNG GIAO TIẾP; KỸ NĂNG SỐNG</td>
                                        <td>754.000</td>
                                        <td>
                                            <select>
                                                <option>-nhóm việc làm-</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"/>
                                            <select>
                                                <option>Tiền mặt</option>
                                                <option>Phần trăm %</option>
                                            </select>
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>232</td>
                                    <td>12 CUỐN SÁCH NGẮN GỌN, DỄ HIỂU BỒI DƯỠNG KỸ NĂNG GIAO TIẾP; KỸ NĂNG SỐNG</td>
                                    <td>754.000</td>
                                    <td>
                                        <select>
                                            <option>-nhóm việc làm-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"/>
                                        <select>
                                            <option>Tiền mặt</option>
                                            <option>Phần trăm %</option>
                                        </select>
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </td>
                                </tr>
                                </tbody>

                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>232</td>
                                    <td>12 CUỐN SÁCH NGẮN GỌN, DỄ HIỂU BỒI DƯỠNG KỸ NĂNG GIAO TIẾP; KỸ NĂNG SỐNG</td>
                                    <td>754.000</td>
                                    <td>
                                        <select>
                                            <option>-nhóm việc làm-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"/>
                                        <select>
                                            <option>Tiền mặt</option>
                                            <option>Phần trăm %</option>
                                        </select>
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </td>
                                </tr>
                                </tbody>


                            </table>
                            <div class="box-footer">
                                <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </form>
        </div>
    </section>
@endsection

