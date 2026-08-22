<!-- Styles -->
<link rel="stylesheet" type="text/css" href="{{ asset('comments/css/jquery-comments.css') }}">

<!-- Data -->
<script type="text/javascript" src="{{ asset('comments/data/comments-data.js') }}"></script>

<!-- Libraries -->
<script type="text/javascript" src="{{ asset('comments/js/jquery.textcomplete.js') }}"></script>
<script type="text/javascript" src="{{ asset('comments/js/jquery-comments.js') }}"></script>

<?php $commentDb = new \App\Entity\Comment(); ?>
<?php
    $orderUsers = \App\Entity\Order::getUserOrderProduct($post_id);
    $commentParents = $commentDb->getAllComment($post_id);
?>
<!-- Dữ liệu comment truyền vào -->
<script type="text/javascript">
    var commentsArray = [
        @foreach ($commentParents as $commentParent)
        {
            "id": {!! $commentParent['comment_id'] !!},
            "parent": null,
            "created": "{{ $commentParent['created_at'] }}",
            "content": "{{ $commentParent['content'] }}",
            "creator": {{ $commentParent['user_id'] }},
            "fullname": "{{ $commentParent['user_full_name'] }}",
            "profile_picture_url": "{{ empty($commentParent['user_image']) ? asset('comments/images/user-icon.png') : asset($commentParent['user_image']) }}"
        },
        @if(!empty($commentParent['childrenComments']))
            @foreach($commentParent['childrenComments'] as $child)
                {
                    "id": {!! $child->comment_id !!},
                    "parent": {!! $child->parent !!},
                    "created": "{{ $child->created_at }}",
                    "content": "{{ $child->content }}",
                    "creator": {{ $child->user_id }},
                    "fullname": "{{ $child->user_full_name }}",
                    "profile_picture_url": "{{ empty($child->user_image) ? asset('comments/images/user-icon.png') : asset($child->user_image) }}"
                },
            @endforeach
        @endif
        @endforeach
    ]

    var usersArray = [
        @foreach (\App\Entity\User::getUserComment() as $user)
        {
            id: {!! $user->id !!},
            fullname: "{{ $user->name }}",
            email: "{{ $user->email }}",
            profile_picture_url: "{{ empty($user->image) ? asset('comments/images/user-icon.png') : asset($user->image) }}"
        },
        @endforeach
    ]
</script>

<?php $userCheck = \Illuminate\Support\Facades\Auth::check() ?>

<!-- Init jquery-comments -->
<script type="text/javascript">
    $(function() {
        function isEmpty( el ){
            return !$.trim(el)
        }

        var saveComment = function(data) {
            // Convert pings to human readable format
            $(data.pings).each(function(index, id) {
                var user = usersArray.filter(function(user){return user.id == id})[0];
                data.content = data.content.replace('@' + id, '@' + user.fullname);
            });

            $.ajax({
                type: "GET",
                url: '{!! route('comment') !!}',
                data: {
                    post_id: '{{ $post_id }}',
                    parent: isEmpty(data.parent) ? 0 : data.parent ,
                    message: data.content,
                    comment_id: data.id,
                    user_id: '{{ $userCheck ? \Illuminate\Support\Facades\Auth::user()->id : 0 }}',
                },
                async: false,
                success: function(success){
                    var obj = jQuery.parseJSON( success);
                    data.id = obj.comment_id;

                   return data;
                }
            });

            console.log(data);

            return data;
        }

        var deleteComment = function(data) {
            $.ajax({
                type: "GET",
                url: '{!! route('delete_comment') !!}',
                data: {
                    comment_id: data.id,
                },
                success: function(data){
                },
                error: function () {
                }
            });

            return data;
        }

        $('#comments-container').comments({
            profilePictureURL: '{{ $userCheck ? asset(\Illuminate\Support\Facades\Auth::user()->image) : asset('comments/images/user-icon.png') }}',
            currentUserId: '{{ $userCheck ? \Illuminate\Support\Facades\Auth::user()->id : 0 }}',
            roundProfilePictures: true,
            textareaRows: 1,
            enableAttachments: false,
            enableHashtags: true,
            enablePinging: true,
            user_has_upvoted: false,
            enableUpvoting: false,
            textareaPlaceholderText: 'Đánh giá sản phẩm của chúng tôi',
            newestText: 'Mới nhất',
            oldestText: 'Cũ hơn',
            popularText: 'Phổ biến',
            sendText: 'Bình luận',
            replyText: 'Trả lời',
            editText: 'Chỉnh sửa',
            saveText: 'Cập nhật',
            deleteText: 'Xóa',
            editedText: 'Đã chỉnh sửa',
            youText: "{!! $userCheck ? \Illuminate\Support\Facades\Auth::user()->name : 'Ẩn Danh' !!}",
            getUsers: function(success, error) {
                setTimeout(function() {
                    success(usersArray);
                }, 500);
            },
            getComments: function(success, error) {
                setTimeout(function() {
                    success(commentsArray);
                }, 500);
            },
            postComment: function(data, success, error) {
                setTimeout(function() {
                    success(saveComment(data));
                }, 500);
            },
            putComment: function(data, success, error) {
                setTimeout(function() {
                    success(saveComment(data));
                }, 500);
            },
            deleteComment: function(data, success, error) {
                setTimeout(function() {
                    success(deleteComment(data));
                }, 500);
            },
            upvoteComment: function(data, success, error) {
                setTimeout(function() {
                    success(data);
                }, 500);
            },
            uploadAttachments: function(dataArray, success, error) {
                setTimeout(function() {
                    success(dataArray);
                }, 500);
            },
        });
    });
</script>


<h3 style="margin-bottom: 20px;
    text-transform: uppercase;
    font-weight: 700;">Bình luận</h3>
<div id="comments-container"></div>