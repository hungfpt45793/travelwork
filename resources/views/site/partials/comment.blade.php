<div class="commentBox" id="commentBox">
    <?php $userCheck = \Illuminate\Support\Facades\Auth::check() ?>

    <form class="commentComment" action="" method="post" onsubmit="return commentSubmit(this);">

        <img class="avatar lazy"
             src="{{ $userCheck ? asset(\Illuminate\Support\Facades\Auth::user()->image) : asset('site/images/no_person.png') }}" alt="avatar">
        <input type="hidden" class="username"
               value="{{ $userCheck ? \Illuminate\Support\Facades\Auth::user()->name : 'Ẩn Danh' }}">
        <div class="message form-group" >
            {{ csrf_field() }}
            <input type="hidden"  class="parent" value="0" />
            <input type="hidden" name="post_id" class="post_id" value="{{ $post_id }}" />
            <textarea class="form-control messageContent" name="message" required></textarea>
            @if (!$userCheck)
            <div class="informationCommentMother">
                <p class="evaluate">
                    <b>Đánh giá</b>:
                    <select class='ratingSelect' id='rating_<?= $post_id ?>' data-id='rating_<?= $post_id; ?>'>
                        <option value="1" >1</option>
                        <option value="2" >2</option>
                        <option value="3" >3</option>
                        <option value="4" >4</option>
                        <option value="5" selected>5</option>
                    </select>
                    <input type="hidden" value="5" name="rate" class="rating" />
                </p>
                <div class="form-group row">
                    <div class="col-xs-12 col-md-6">
                        <input type="text" class="form-control custormer_name" name="custormer_name" placeholder="Tên mẹ là gì?" required/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-xs-12 col-md-6">
                        <input type="number" class="form-control custormer_phone" name="custormer_phone" placeholder="Số điện thoại của mẹ ?" required/>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label>* Đây là thông tin bắt buộc, SĐT của mẹ luôn được bảo mật.</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-xs-12 col-md-6">
                        <input type="email" class="form-control custormer_email" name="custormer_email" placeholder="Nhập địa chỉ email của các mẹ nữa nhé!" required/>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label>* Cập nhật thông báo phản hồi qua email.</label>
                    </div>
                </div>
            </div>
            @endif
            <input type="submit" class="submit btn btn-primary" value="Bình luận" />
        </div>
    </form>
        
    <div class="commentShow">
        <?php $commentDb = new \App\Entity\Comment();?>
        <p class="numberComment">Hiện có {{  $commentDb->getCountComment($post_id) }} bình luận</p>
        <?php $orderUsers = \App\Entity\Order::getUserOrderProduct($post_id);
            $commentParents = $commentDb->getAllComment($post_id);
        ?>
        @foreach($commentParents as $id => $comment)
        <div class="item">
            <p class="evaluate">
                <b>Đánh giá</b>:
                <select class='ratingProduct' id='rating_<?php echo $post_id; ?>' data-id='rating_<?php echo $post_id; ?>' >
                    <option value="1" {{ ($comment['rating'] >= 0.5) ? 'selected' : '' }}>1</option>
                    <option value="2" {{ ($comment['rating'] >= 1.5) ? 'selected' : '' }}>2</option>
                    <option value="3" {{ ($comment['rating'] >= 2.5) ? 'selected' : '' }}>3</option>
                    <option value="4" {{ ($comment['rating'] >= 3.5) ? 'selected' : '' }}>4</option>
                    <option value="5" {{ ($comment['rating'] >= 4.5) ? 'selected' : '' }}>5</option>
                </select>
                <input type="hidden" value="{{ $comment['rating'] }}" name="rate" class="rating" />
            </p>
            @foreach ($orderUsers as $orderUser)
               <?php if ( ($orderUser['user_id'] == $comment['user_id']  || $orderUser['shipping_phone'] == $comment['customer_phone'])
                    && (strtotime($orderUser['created_at']) > strtotime($comment['created_at']))) {
                   echo '<p style="color: #9aa438" ><i class="fa fa-shield" aria-hidden="true"></i> Chứng nhân đã mua hàng</p>';
                }?>
            @endforeach
            <div class="parent">
				<div class="avatar">
                    <img class="lazy" src="{{ empty($comment['user_image']) ? asset('site/images/no_person.png') : asset($comment['user_image']) }}" alt="avatar">
				</div>
                <div class="content">
                    <p><span class="username">{{ empty($comment['user_full_name']) ? $comment['customer_name'] : $comment['user_full_name'] }}</span>:
                        <span class="mainContent">{{ $comment['content'] }}</span></p>
                        <?php $date=date_create($comment['created_at']); ?>
                    <p><span class="reply" onclick="return repComment(this);">Trả lời</span> . <span class="date">{{ date_format($date,"d-m-Y") }}</span></p>
                </div>
                <div class="editComment">
                    <form class="commentComment" action="" method="post" onsubmit="return commentEditSubmit(this);">
                        <img class="avatar lazy"
                             src="{{ $userCheck ? asset(\Illuminate\Support\Facades\Auth::user()->image) : asset('site/images/no_person.png') }}" alt="avatar">
                        <div class="message form-group">
                            {{ csrf_field() }}
                            <input type="hidden" class="comment_id" name="comment_id" value="{{ $comment['comment_id'] }}"/>
                            <textarea class="form-control messageContent" name="message" required>{{ $comment['content'] }}</textarea>
                            <input type="submit" value="Chỉnh sửa" class="submit btn btn-primary" />
                        </div>
                    </form>
                </div>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role) || \Illuminate\Support\Facades\Auth::user()->id == $comment['user_id'] )
                        <div class="dropdown">
                            <i class="fa fa-cog" aria-hidden="true" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                            <input type="hidden" class="comment_id" value="{{ $comment['comment_id'] }}"/>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#" onclick="return editComment(this)">Chỉnh sửa</a></li>
                                <li>
                                    <a href="#" aria-hidden="true"  data-toggle="modal" data-target="#myModalDelete" onclick="return submitDeleteComment(this);">xóa</a></li>
                            </ul>
                        </div>
                    @endif
                @endif
            </div>
            @if(!empty($comment['childrenComments']))               
                @foreach($comment['childrenComments'] as $child)
                <div class="children">
                    <div class="avatar">
                        <img class="lazy" src="{{ empty($child->user_image) ? asset('site/images/no_person.png') : asset($child->user_image) }}" alt="avatar">
                    </div>
                    <div class="content">
                        <p><span class="username">{{ empty($child->user_full_name) ? $child->customer_name : $child->user_full_name }}</span>:
                            <span class="mainContent">{{ $child->content }}</span></p>
                        <?php $date=date_create($child->created_at); ?>
                        <p><span class="reply" onclick="return repComment(this);">Trả lời</span> . <span class="date">{{ date_format($date,"d-m-Y") }}</span></p>
                    </div>
                    <div class="editComment">
                        <form class="commentComment" action="" method="post" onsubmit="return commentEditSubmit(this);">
                            <div class="message form-group">
                                {{ csrf_field() }}
                                <input type="hidden" class="comment_id" name="comment_id" value="{{ $child->comment_id }}"/>
                                <textarea class="form-control messageContent" name="message" required>{{ $child->content }}</textarea>
                                <input type="submit" value="Chỉnh sửa" class="submit btn btn-primary" />
                            </div>
                        </form>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role) || \Illuminate\Support\Facades\Auth::user()->id == $comment['user_id'] )
                            <div class="dropdown">
                                <i class="fa fa-cog" aria-hidden="true" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                                <input type="hidden" class="comment_id" value="{{ $child->comment_id }}"/>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#" onclick="return editComment(this)">Chỉnh sửa</a></li>
                                    <li>
                                        <a href="#" aria-hidden="true"  data-toggle="modal" data-target="#myModalDelete" onclick="return submitDeleteComment(this);">xóa</a></li>
                                </ul>
                            </div>
                        @endif
                    @endif
                </div>
                @endforeach
            @endif
        </div>

        <form class="commentComment child" action="" method="post" onsubmit="return commentChildSubmit(this);">
            <img class="avatar lazy"
                 src="{{ $userCheck ? asset(\Illuminate\Support\Facades\Auth::user()->image) : asset('site/images/no_person.png') }}" alt="avatar">
            <input type="hidden" class="username"
                   value="{{ $userCheck ? \Illuminate\Support\Facades\Auth::user()->name : 'Ẩn Danh' }}">
            <div class="message form-group">
                {{ csrf_field() }}
                <input type="hidden" class="parent" value="{{ $comment['comment_id'] }}" />
                <input type="hidden" name="post_id" class="post_id" value="{{ $post_id }}" />
                <textarea class="form-control messageContent" name="message" required></textarea>
                @if (!$userCheck)
                <div class="informationCommentMother">
                    <div class="form-group row">
                        <div class="col-xs-12 col-md-6">
                            <input type="text" class="form-control custormer_name" name="custormer_name" placeholder="Tên mẹ là gì?" required/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-12 col-md-6">
                            <input type="number" class="form-control custormer_phone" name="custormer_phone" placeholder="Số điện thoại của mẹ ?" required/>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label>* Đây là thông tin bắt buộc, SĐT của mẹ luôn được bảo mật.</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-12 col-md-6">
                            <input type="email" class="form-control custormer_email"  name="custormer_email" placeholder="Nhập địa chỉ email của các mẹ nữa nhé!" required/>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label>* Cập nhật thông báo phản hồi qua email.</label>
                        </div>
                    </div>
                </div>
                @endif
                <input type="submit" value="Bình luận" class="submit btn btn-primary" />
            </div>
        </form>
        @endforeach
        {{ $commentParents->links() }}
    </div>
</div>
<script>
    function goToByScroll(id){
        // Remove "link" from the ID
        id = id.replace("link", "");
        // Scroll
        $('html,body').animate({
                scrollTop: $("#"+id).offset().top},
            'slow');
    }

    $( document ).ready(function() {
        @if (isset($_GET['page']))
            goToByScroll('commentBox');
        @endif
    });
    function commentSubmit(e) {
        var image = $(e).find('.avatar').attr('src');
        var username = $(e).find('.username').val();
        var message = $(e).find('.messageContent').val();
        var postId = $(e).find('.post_id').val();
        var parent =  $(e).find('.parent').val();
        var token =  $(e).find('input[name=_token]').val();
        var customerName = $(e).find('.custormer_name').val();
        var customerPhone = $(e).find('.custormer_phone').val();
        var customerEmail = $(e).find('.custormer_email').val();
        var rating = $(e).find('.rating').val();

        $.ajax({
            type: "POST",
            url: '{!! route('comment') !!}',
            data: {
                post_id: postId,
                parent: parent,
                message: message,
                customerName: customerName,
                customerPhone: customerPhone,
                customerEmail: customerEmail,
                rating: rating,
                _token: token
            },
            success: function(data){
                var obj = jQuery.parseJSON( data);
                
                var html =
                '<div class="item">' +
                    '<div class="parent">' +
                        '<img class="avatar" src="'+ obj.user_image +'" alt="avatar">'+
                        '<div class="content">' +
                            '<p><span class="username">'+ obj.user_full_name + '</span>: <span class="mainContent">'+ message +'</span></p>' +
                            '<p><span class="reply" onclick="return repComment(this);">Trả lời</span>'
                                + ' <span class="date">'+ obj.day + 'tháng ' + obj.month + ' năm ' + obj.year + '</span></p>' +
                        '</div>' +
                        '<div class="editComment">' +
                            '<form class="commentComment" action="" method="post" onsubmit="return commentEditSubmit(this);">' +
                            '<div class="message form-group">' +
                            '{{ csrf_field() }}' +
                            '<input type="hidden" class="comment_id" name="comment_id" value="'+obj.comment_id+'"/>' +
                            '<textarea class="form-control messageContent" name="message" required>'+ message +'</textarea>' +
                            '<input type="submit" value="Chỉnh sửa" class="submit btn btn-primary" />' +
                            '</div>' +
                            '</form>' +
                        '</div>' +
                       '<div class="dropdown">' +
                            '<i class="fa fa-cog" aria-hidden="true" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>' +
                            '<input type="hidden" class="comment_id" value="'+obj.comment_id+'"/>' +
                            '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                '<li><a href="#" onclick="return editComment(this)">Chỉnh sửa</a></li>' +
                                '<li>' +
                                    '<a href="#" aria-hidden="true"  data-toggle="modal" data-target="#myModalDelete" onclick="return submitDeleteComment(this);">xóa</a>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                ' <form class="commentComment child" action="" method="post" onsubmit="return commentChildSubmit(this);">' +
                    '<img class="avatar" src="'+ obj.user_image +'" alt="avatar">' +
                    '<input type="hidden" class="username" value="'+obj.user_full_name+'">' +
                    '<div class="message form-group">' +
                        '{!! csrf_field() !!}' +
                        '<input type="hidden"  class="parent" value="'+obj.comment_id+'" />' +
                        '<input type="hidden" name="post_id" class="post_id" value="'+obj.post_id+'" />' +
                        '<textarea class="form-control messageContent" name="message" required></textarea>' +
                        '<button class="submit btn btn-primary">Bình luận</button>' +
                    '</div>' +
                '</form>'

                $(e).parent().parent().find('.messageContent').val('');
                $('.commentShow').prepend(html);
            }
        });
        $(e).find('.informationCommentMother').hide();
        return false;
    }

    function commentChildSubmit(e) {
        var image = $(e).find('.avatar').attr('src');
        var username = $(e).find('.username').val();
        var message = $(e).find('.messageContent').val();
        var postId = $(e).find('.post_id').val();
        var parent =  $(e).find('.parent').val();
        var customerName = $(e).find('.custormer_name').val();
        var customerPhone = $(e).find('.custormer_phone').val();
        var customerEmail = $(e).find('.custormer_email').val();
        var token =  $(e).parent().parent().find('input[name=_token]').val();
        var rating = $(e).find('.rating').val();
        
        $.ajax({
            type: "POST",
            url: '{!! route('comment') !!}',
            data: {
                post_id: postId,
                parent: parent,
                message: message,
                customerName: customerName,
                customerPhone: customerPhone,
                customerEmail: customerEmail,
                rating: rating,
                _token: token
            },
            success: function(data){
                var obj = jQuery.parseJSON( data);

                var html =
                    '<div class="children">' +
                        '<img class="avatar" src="'+  obj.user_image  +'" alt="avatar">' +
                        '<div class="content">' +
                            '<p><span class="username">'+  obj.user_full_name  + '</span>: <span class="mainContent">'+ message +'</span></p>' +
                            '<p><span class="reply" onclick="return repComment(this);">Trả lời</span> . <span class="date">'+ obj.day + 'tháng ' + obj.month + ' năm ' + obj.year + '</span></p>' +
                        '</div>' +
                        '<div class="editComment">' +
                            '<form class="commentComment" action="" method="post" onsubmit="return commentEditSubmit(this);">' +
                            '<div class="message form-group">' +
                            ' {{ csrf_field() }}' +
                            '<input type="hidden" class="comment_id" name="comment_id" value="'+obj.comment_id+'"/>' +
                            '<textarea class="form-control messageContent" name="message" required>'+ message +'</textarea>' +
                            '<input type="submit" value="Chỉnh sửa" class="submit btn btn-primary" />' +
                            '</div>'+
                            '</form>' +
                        '</div>' +
                        '<div class="dropdown">' +
                            '<i class="fa fa-cog" aria-hidden="true" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>' +
                            '<input type="hidden" class="comment_id" value="'+obj.comment_id+'"/>' +
                            '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                '<input type="hidden" class="comment_id" value="'+obj.comment_id+'"/>' +
                                '<li><a href="#" onclick="return editComment(this)">Chỉnh sửa</a></li>' +
                                '<li>' +
                                    '<a href="#" aria-hidden="true"  data-toggle="modal" data-target="#myModalDelete" onclick="return submitDeleteComment(this);">xóa</a></li>' +
                             '</ul>' +
                        '</div>' +
                    '</div>'

                    ;

                $(e).find('.messageContent').val('');
                $(e).prev().append(html);
            }
        });
        $(e).find('.informationCommentMother').hide();
        return false;
    }

    function repComment(e) {
        $(e).parent().parent().parent().parent().next().show();
    }
    $('.messageContent').click(function(e) {
        $(this).parent().find('.informationCommentMother').show();
    })
    $(document).ready(function(){

        $('.ratingSelect').barrating({
        theme: 'fontawesome-stars',
        onSelect: function(value, text, event) {
            // Get element id by data-id attribute
            var el = this;
            var el_id = el.$elem.data('id');

            // rating was selected by a user
            if (typeof(event) !== 'undefined') {

                var split_id = el_id.split("_");

                var postid = split_id[1]; // postid

            }
            $('.rating').val(value);
        }
        });
    });

    // edit comment
    function editComment(e) {
       $(e).parent().parent().parent().parent().find('.content').hide();
       $(e).parent().parent().parent().parent().find('.editComment').show();

       return false;
    }

    function commentEditSubmit(e) {
        var commentId = $(e).find('.comment_id').val();
        var message = $(e).find('.messageContent').val();
        var token =  $(e).parent().parent().find('input[name=_token]').val();
        $(e).parent().parent().find('.content').hide();
        
        $.ajax({
            type: "POST",
            url: '{!! route('edit_comment') !!}',
            data: {
                comment_id: commentId,
                message: message,
                _token: token
            },
            success: function(data){
                $(e).parent().parent().find('.mainContent').empty();
                $(e).parent().parent().find('.mainContent').html(message);
                $(e).parent().parent().find('.content').show();
            },
            error: function () {
                $(e).parent().parent().find('.content').show();
            }
        });
        
        $(e).parent().hide();
        return false;
    }
</script>
@include('site.partials.popup_delete_comment')
