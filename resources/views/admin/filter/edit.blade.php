@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$filterGroup->group_name )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa bộ lọc {{$filterGroup->group_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bộ lọc</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('filter.update', ['group_filter_id' => $filterGroup->group_filter_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <section class="content">
                    <div class="container">
                        <div class="form-group">
                            <label for="email">Nhóm bộ lọc:</label>
                            <input type="text" class="form-control" id="name" value="{{ $filterGroup->group_name }}" placeholder="Nhập nhóm bộ lọc" name="name">
                        </div>
                    </div>
                    <table id="filter" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="required"><h3>Tên bộ lọc</h3></td>
                        </tr>
                        </thead>
                        <tbody>
							<?php $filterRow = 0; ?>
                            @foreach($filterElements as $filterElement)
								
                                <script type="text/javascript">
                                        var html  = '<tr id="filter-row' + {!! $filterRow !!} + '">';
                                        html += '  <td class="text-left" style="width: 90%;">';
                                        html += '  <div class="form-group">';
                                        html += '<input type="text" name="filter[]" value="{{ $filterElement->name_filter }}" class="form-control" placeholder="Nhập tên bộ lọc" >';
                                        html += '  </div>';
                                        html += '  </td>';
                                        html += '  <td ><button type="button" onclick="$(\'#filter-row' + {!! $filterRow !!} + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                                        html += '</tr>';

                                        $('#filter tbody').append(html);
                                </script>
								<?php $filterRow++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td style="background: #f4f4f4"><button type="button" onclick="addFilterRow();" data-toggle="tooltip" title="Add Filter" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </section>



                <script type="text/javascript">
                    var filter_row = 0;

                    function addFilterRow() {
                        html  = '<tr id="filter-row' + filter_row + '">';
                        html += '  <td class="text-left" style="width: 90%;">';
                        html += '  <div class="form-group">';
                        html += '<input type="text" name="filter[]" value="" class="form-control" placeholder="Nhập tên bộ lọc" >';
                        html += '  </div>';
                        html += '  </td>';
                        html += '  <td ><button type="button" onclick="$(\'#filter-row' + filter_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                        html += '</tr>';

                        $('#filter tbody').append(html);

                        filter_row++;
                    }
                </script>

            </form>
        </div>
    </section>
@endsection

