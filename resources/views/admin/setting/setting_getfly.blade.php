@extends('admin.layout.admin')

@section('title', 'Cài đặt thanh toán')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cài thanh toán
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cài đặt thanh toán</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <!-- Nội dung thêm mới -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cài đặt getfly</h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <form action="{{ route('updateSettingGetFly') }}" method="post">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <label>api key</label>
                                            <input type="text" class="form-control" name="api_key" value="{{ \App\Entity\SettingGetfly::getApiKey() }}"
                                                   placeholder="Mã api_key getfly cung cấp..." />
                                        </div>
                                        <div class="form-group">
                                            <label>Đường dẫn website</label>
                                            <input type="text" class="form-control" name="base_url" value="{{ \App\Entity\SettingGetfly::getBaseUrl() }}"
                                                   placeholder="https://vn3c.getflycrm.com/..." />
                                        </div>

                                        <div class="form-group">
                                            <label>Chiến dịch nhà tuyển dụng</label>
                                            <select class="form-control select2" name="campaign_employer" >
                                                @foreach ($campaigns['decode'] as $campaign)
                                                    <option value="{{ $campaign['token_api'].'-'.$campaign['campaign_id'] }}"
                                                            {{ ( \App\Entity\SettingGetfly::getCampaignEmployer() == $campaign['token_api']) ? 'selected' : '' }}
                                                    >{{ $campaign['campaign_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function changeMethod(e) {
                var val = $(e).val();
                if (val == 0) {
                    $('#smtp').removeClass('hide');
                    $('#api').addClass('hide');
                } else {
                    $('#smtp').addClass('hide');
                    $('#api').removeClass('hide');
                }
            }
        </script>
    </section>
    @include('admin.partials.popup_delete')
@endsection

