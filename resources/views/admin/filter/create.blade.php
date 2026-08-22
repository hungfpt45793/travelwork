@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa Filter')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Bộ lọc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Thêm mới Bộ lọc</a></li>
        </ol>
    </section>
    <form role="form" action="{{ route('filter.store') }}" method="post">
        {!! csrf_field() !!}
        {{ method_field('POST') }}
    <section class="content">
        <div class="container">
            <div class="form-group">
                <label for="email">Nhóm bộ lọc:</label>
                <input type="text" class="form-control" id="name" placeholder="Nhập nhóm bộ lọc" name="name">
            </div>
        </div>
        <table id="filter" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <td class="required"><h3>Tên bộ lọc</h3></td>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <td style="background: #f4f4f4"><button type="button" onclick="addFilterRow();" data-toggle="tooltip" title="Add Filter" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
            </tr>
            </tfoot>
        </table>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
    </section>



    <script type="text/javascript">
        var filter_row = 0;

        function addFilterRow() {
            html  = '<tr id="filter-row' + filter_row + '">';
            html += '  <td class="text-left" style="width: 90%;">';
            html += '  <div class="form-group">';
            html += '<input type="text" name="filter[]" value="" class="form-control" placeholder="Nhập tên bộ lọc" >'
            html += '  </div>';
            html += '  </td>';
            html += '  <td ><button type="button" onclick="$(\'#filter-row' + filter_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#filter tbody').append(html);

            filter_row++;
        }
    </script>
    </form>

@endsection