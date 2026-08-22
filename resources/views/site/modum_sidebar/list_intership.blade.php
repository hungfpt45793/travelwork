@if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 2)
    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
        <div class="title">
            <h5 class="fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">
                Hồ sơ thực tập
            </h5>
        </div>
        <hr class="mgt10 mgb10">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    @if(session('suscess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                             style="margin-top: 15px;width: 100%">
                            <strong>{{ session('suscess') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('erorr'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert"
                             style="margin-top: 15px;width: 100%">
                            <strong>{{ session('erorr') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(!empty($errors->all()))
                        @foreach($errors->all() as $erorr)
                            <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                        @endforeach
                    @endif


                    <div class="col-md-12 mgt20">
                        <table id="jobfb" class="table table-hover table-bordered text-center">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ngày ứng tuyển</th>
                                <th>Tên ứng viên</th>
                                <th>Tỉnh / TP</th>
                                <th>Quận / Huyện</th>
                                <th>Trạng thái(thực tập)</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($intership as $id => $inter)
                                <tr>
                                    <td>{{ $id + 1 }}</td>
                                    <td><?php
                                        $date = date_create($inter->create_up);
                                        echo date_format($date, "d/m/Y");
                                        ?></td>
                                        <td>{{ !empty($inter->employee_name) ? $inter->employee_name : '' }}</td>
                                        <td>
                                            <?php $province_star = \App\Entity\Province::getId($inter['province']) ?>
                                            @if(isset($province_star->province_name))
                                                {{ $province_star->province_name }}
                                            @endif
                                        </td>
                                        <td>
                                            <?php $distinct_star = \App\Entity\District::getId($inter['district']) ?>
                                            @if(isset($distinct_star->district_name))
                                                {{ $distinct_star->district_name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($inter->status_intership == 1)
                                                <a data-toggle="modal" data-target="#updateIntership{{$id}}"
                                                   style="background-color: green;color: #fff;padding: 5px 10px;cursor: pointer"> <i
                                                            class="fas fa-pencil-alt"></i> Đã nhận</a>
                                            @else
                                                <a data-toggle="modal" data-target="#updateIntership{{$id}}"
                                                   style="background-color: red;color: #fff;padding: 5px 10px;cursor: pointer"> <i
                                                            class="fas fa-pencil-alt"></i> Chưa nhận</a>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ route('show_emplooyee_intership',['employee_id'=>$inter->employee_id]) }}"
                                               class="btnOrange" style="padding: 5px 10px" target="_blank">Chi tiết ứng viên</a>
                                         
                                            <a data-toggle="modal" data-target="#deleteIntership{{$id}}"
                                               title="Xóa"
                                               style="background-color: red;color: #fff;padding: 5px 10px;cursor: pointer"><i
                                                        class="far fa-trash-alt"></i> Loại hồ sơ</a>
                                        </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>

                </div>


            </div>
        </div>
    </div>
@else


@endif

<!-- Modal -->
@foreach($intership as $id => $inter)
    <div class="modal fade" id="updateIntership{{$id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <form action="{{ route('update_status_intership') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật trạng thái</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body gruopRadio">


                        <label for="exampleFormControlTextarea1">Hồ sơ thực tập : </label>
                        <br>
                        <div class="radio">
                            <label><input type="radio" value="1" name="status_intership"
                                          @if($inter->status_intership == 1) checked @endif style="width: 20px;
    height: 20px;
    margin-right: 6px;
    margin-bottom: 10px;">Nhận hồ sơ</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="0" name="status_intership"
                                          @if($inter->status_intership == 0) checked @endif style="width: 20px;
    height: 20px;
    margin-right: 6px;
    margin-bottom: 10px;">Không nhận hồ sơ</label>
                        </div>

                        <input type="hidden" name="intership_id" value="{{ $inter->intership_id }}">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<style>
    .radio label {
        position: relative;
        margin-left: 25px;
    }

    .radio label input {
        position: absolute;
        left: -25px;
    }
</style>


@foreach($intership as $id => $inter)
    <div class="modal fade" id="deleteIntership{{$id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <form action="{{ route('delete_intership') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Loại hồ sơ thực tập</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="intership_id" value="{{ $inter->intership_id }}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Loại hồ sơ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
