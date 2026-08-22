@extends('admin.layout.admin')

@section('title', 'Bình luận tài liệu')
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
            Bình luận
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"> Bình luận </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    @if(!empty($voucher_comments))
                        <div class="box-body">
                     
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID Bình luận</th>
                                    <th>Tài liệu</th>
                                    <th>Nội dung bình luận</th>
                                    <th>User bình luận</th>
                                    <th>Thời gian bình luận</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($voucher_comments as $id => $comment )
                                    <tr>
                                        <td>{{ $comment['id_voucher_cm'] }}</td>
                                        <td width="30%">
                                            <?php
                                            $voucherId = \App\Entity\Voucher::getID($comment['id_voucher']);
                                            echo $voucherId->name_voucher;
                                            ?>
                                        </td>
                                        <td width="40%">{{ $comment['content_voucher_cm'] }}</td>

                                        <td>
                                            <?php
                                            $user_comment = \App\Entity\User::getIdUser($comment['user_id']);
                                            if(!empty($user_comment))
                                                {
                                                    echo $user_comment->name;
                                                }
                                                else

                                                    {
                                                        echo 'khong xac dinh';
                                                    }
                                            ?>

                                        </td>
                                        <td>
                                            <?php
                                            $date = date_create($comment['day_comment']);
                                            ?>
                                            <span><i class="far fa-calendar-times"></i> <?php echo date_format($date, "d/m/Y")?></span>
                                            </br>
                                            <span><i class="far fa-clock"></i> <?php echo date_format($date, "H:i") ?></span>


                                        </td>
                                        <td>
                                            <?php
                                            $anser_voucher = \App\Entity\VoucherComment::getPanentId($comment['id_voucher_cm']);
                                            ?>
                                            @if(!empty($anser_voucher))
                                                <span style="color: green">Đã trả lời</span>
                                                @else
                                                <span style="color: red">Chưa trả lời</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('voucher-comment.edit', ['id_voucher_cm' => $comment['id_voucher_cm']]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                                   aria-hidden="true"></i></button>
                                            </a>
                                            <a href="{{ route('voucher-comment.destroy', ['id_voucher_cm' => $comment['id_voucher_cm']]) }}"
                                               class="btn btn-danger btnDelete" data-toggle="modal"
                                               data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">{{ $voucher_comments->links() }}</div>

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
                @endif
                <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            $('#category_voucher').change(function () {
                $('#submitForm').submit();
            });
        });

    </script>
    @include('admin.partials.popup_delete')
@endsection

