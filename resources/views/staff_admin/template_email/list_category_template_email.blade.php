@extends('staff_admin.layouts.master')
@section('title', 'Mẫu Email theo danh mục '.$category_template_email->name_cate_tem )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('list_category_template_email', ['id' => $category_template_email]) }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                    {{ $template_email->links() }}
                                số bản ghi của một trang:
                                <span class="input-submit">
                                    <form action="" class="inline">
                                        <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                        <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                        <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                        <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                        <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                        <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    </form>
                                </span>
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $template_email->total() }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table id="locker" class="custom-table tableFixHead table-bordered table-striped" data-fl-scrolls style="overflow: scroll;height:100vh;display:block;table-layout:fixed;"></table>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_1"><p style="width:32px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_2"><p style="width:257px">Tên mẫu<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:277px">Tiêu đề khi gửi mail<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_4"><p style="width:103px">Gửi email cho<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width:97px">Trạng thái<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_6"><p style="width:71px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($template_email as $email )
                                            <tr>
                                                <td class="lid_1">
                                                    {{ $email->id_tem }}
                                                </td>
                                                <td class="lid_2">
                                                    {{ $email->name_tem }}
                                                </td>
                                                <td class="lid_3">{{ $email->subject_tem }}</td>
                                                <td class="lid_4">
                                                    @if($email->status_people == 1)
                                                        <span style="color: red">1.Ứng viên</span>
                                                    @endif
                                                    @if($email->status_people == 2)
                                                            <span style="color: red">2.Nhà tuyển dụng</span>
                                                    @endif
                                                    @if($email->status_people == 3)
                                                            <span style="color: red">3.Giáo viên</span>
                                                    @endif
                                                        @if($email->status_people == 4)
                                                            <span style="color: red">4.Quản trị viên</span>
                                                    @endif
                                                </td>
                                                <td class="lid_5">
                                                    @if($email->status_tem == 1)
                                                        <span style="background: green;color: #fff;padding: 3px 5px">Đang sử dụng</span>
                                                    @else
                                                        <span style="background: red;color: #fff;padding: 3px 5px">Không sử dụng</span>
                                                    @endif
                                                </td>
                                                <td class="lid_6 text-center">
                                                    <a href="{{ route('edit_category_template_email',['id_tem'=> $email->id_tem]) }}">
                                                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"
                                                                                           aria-hidden="true"></i></button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
