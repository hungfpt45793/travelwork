@if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 1)
    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
        <div class="title">
            <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                Danh sách công ty mà bạn đã gửi hồ sơ thực tập
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
                        <table id="jobfb" class="table table-hover table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th>STT</th>
                                <th>Ngày nộp hồ sơ</th>
                                <th>Tên công ty</th>
                                <th>Email công ty</th>
                                <th>Số ĐT công ty</th>
                                <th>Địa chỉ</th>
                                <th>Link xem chi tiết</th>
                                <th>Nhà tuyển dụng xác nhận(hồ sơ)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($intership as $id => $inter)
                                <tr>
                                    <td>{{ $id + 1 }}</td>
                                    <td><?php
                                        $date=date_create($inter->created_at);
                                        echo date_format($date,"d/m/Y");
                                        ?></td>
                                    <td>{{ isset($inter->enterprise_name) ?$inter->enterprise_name : '' }}</td>

                                    <td> {{ isset($inter->email) ?$inter->email : '' }}</td>


                                    <td>{{ isset($inter->phone) ?$inter->phone : '' }}</td>
                                    <td>{{ isset($inter->address) ?$inter->address : '' }}</td>
                                    <td><a href="{{ route('detail_intership',['slug'=>$inter->slug]) }}" target="_blank">Link chi tiết NTD</a></td>
                                    <td>
                                        @if($inter->status_intership == 0)
                                            <span style="color: white;background-color: red;padding: 5px 10px">Chưa xác nhận</span>
                                            @else
                                            <span style="color: white;background-color: green;padding: 5px 10px">Đã xác nhận</span>
                                        @endif
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
@endif



