@extends('admin.layout.admin')

@section('title', 'Danh sách comment')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý thảo luận việc làm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách Bình luận</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        {{--<a  href="{{ route('comments.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>--}}
                        {{--<a  href="{{ route('randomComment') }}" title="Tạo bình luận từ bình luận sẵn có"><button class="btn btn-primary">Tự tạo bình luận</button> </a>--}}
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h3 class=" text-center">Thảo luận việc làm</h3>
                        <div class="messaging">
                            <div class="inbox_msg">
                                <div class="inbox_people">
                                    <div class="headind_srch">
                                        <div class="recent_heading">
                                            <h4>Mới nhất</h4>
                                        </div>
                                        <div class="srch_bar">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-bar" placeholder="Tìm kiếm" aria-describedby="basic-addon1">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inbox_chat">
                                        @foreach ($comments as $id => $comment)
                                            <a href="{{ route('comments.index', ['comment_id' => $comment->comment_id ]) }}">
                                                <div class="chat_list
                                                    @php
                                                        if (isset($_GET['comment_id'])) {
                                                            if ($_GET['comment_id'] == $comment->comment_id) {
                                                                echo 'active_chat';
                                                            }
                                                        }
                                                    @endphp
                                                     ">
                                                    <div class="chat_people">
                                                        <div class="chat_img">
                                                            <img src="{{ !empty($comment->image) ? asset($comment->image) : asset('adminstration/img/avatar.png') }}" />
                                                        </div>
                                                        <div class="chat_ib">
                                                            <h5>{{ !empty($comment->name) ? $comment->name : $comment->customer_name }}
                                                                <?php
                                                                $date = date_create($comment->created_at);
                                                                ?>
                                                                <span class="chat_date">{{ date_format($date,"d-m-Y H:i") }}</span>
                                                            </h5>
                                                            <p>
                                                                Việc làm: {{ \App\Ultility\Ultility::textLimit($comment->title, 7) }}
                                                            </p>
                                                            <p>
                                                                {{ \App\Ultility\Ultility::textLimit($comment->content, 7) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="mesgs">
                                    <div class="msg_history">
                                        <h4>{{ \App\Ultility\Ultility::textLimit($commentShow->title, 7) }}</h4>
                                        <p>{{ $commentShow->customer_name }}</p>
                                        <p>{{ $commentShow->customer_email }}</p>
                                        <p>{{ $commentShow->customer_phone }}</p>
                                        <div class="incoming_msg">
                                            <div class="incoming_msg_img"><img
                                                        src="{{ !empty($commentShow->image) ? asset($commentShow->image) : asset('adminstration/img/avatar.png') }}"
                                                        alt="sunil"></div>
                                            <div class="received_msg">
                                                <div class="received_withd_msg">
                                                    <p>{{ $commentShow->content }}</p>
                                                    <?php
                                                        $date = date_create($commentShow->created_at);
                                                    ?>
                                                    <span>{{ !empty($commentShow->name) ? $commentShow->name : $commentShow->customer_name }}</span>
                                                    <span class="time_date" style="float: right;">
                                                        {{ date_format($date,"d-m-Y H:i") }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach ($commentChildrens as $commentChildren)
                                            @if ($commentChildren->user_id == $commentShow->user_id)
                                                <div class="incoming_msg">
                                                    <div class="incoming_msg_img"><img
                                                                src="{{ !empty($commentChildren->image) ? asset($commentChildren->image) : asset('adminstration/img/avatar.png') }}"
                                                                alt="sunil"></div>
                                                    <div class="received_msg">
                                                        <div class="received_withd_msg">
                                                            <p>{{ $commentChildren->content }}</p>
                                                            <?php
                                                            $date = date_create($commentChildren->created_at);
                                                            ?>
                                                            <span>{{ $commentChildren->name }}</span>
                                                            <span class="time_date" style="float: right;">
                                                            {{ date_format($date,"d-m-Y H:i") }}
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="outgoing_msg">
                                                    <div class="sent_msg">
                                                        <p>
                                                            {{ $commentChildren->content }}
                                                        </p>
                                                        <?php
                                                            $date = date_create($commentChildren->created_at);
                                                        ?>
                                                        <span>{{ $commentChildren->name }}</span>
                                                        <span class="time_date" style="float: right;"> {{ date_format($date,"d-m-Y H:i") }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach



                                    </div>
                                    <div class="type_msg">
                                        <div class="input_msg_write">
                                            <form action="" method="post" onsubmit="return submitComment(this);">
                                                {!! csrf_field() !!}
                                                <input type="text" class="write_msg" name="content" placeholder="Aa" />
                                                <input type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}" name="user_id" />
                                                <input type="hidden" value="{{ $commentShow->job_id }}" name="job_id" />
                                                <input type="hidden" value="{{ $commentShow->comment_id }}" name="parent" />
                                                <button type="submit" class="msg_send_btn" >
                                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function submitComment(e) {
                                    var data = $(e).serialize();

                                    $.ajax({
                                        type: "POST",
                                        url: '{!!  route('comments.store') !!}',
                                        data: data,
                                        success: function(result){
                                            var obj = jQuery.parseJSON( result);

                                            if (obj.status == 200) {
                                                html = '<div class="outgoing_msg">';
                                                html +=     '<div class="sent_msg">';
                                                html +=         '<p>';
                                                html +=             obj.content
                                                html +=         '</p>';
                                                html +=         '<span class="time_date" style="float: right;">';
                                                html +=             'Vừa xong'
                                                html +=         '</span>';
                                                html +=     '</div>';
                                                html += '</div>';

                                                $('.msg_history').append(html);
                                                $('.write_msg').val(' ');

                                            }
                                        },
                                        error: function(error) {
                                            //alert('Lỗi gì đó đã xảy ra!')
                                        }

                                    });

                                    return false;
                                }
                            </script>

                        </div>
                        {{ $comments->links() }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')

@endsection


