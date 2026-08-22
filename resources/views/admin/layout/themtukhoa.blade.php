{{-- chỉnh từ khóa --}}
<br>
<div class="form-group" >
    <label for="exampleInputEmail1">
        Từ khóa (tìm kiếm từ khóa rồi chọn)
        <div style="color: red;">
            Có thể chọn nhiều từ khóa
        </div>
    </label>
    <br>
    <label for="exampleInputEmail1">
        Từ khóa ngắn gọn càng tốt
    </label>
    <br>
    <select style="width: 100%;" name="tags[]" class="select22" multiple="multiple" id="select-tag" required>

        {{-- dùng cho bài viết --}}
        @if (isset($post->tags))
            @php
                $post_tags = explode(',',$post->tags)
            @endphp
            @foreach ($post_tags as $post_tag)
                <option value="{{ $post_tag }}" selected>
                    {{ $post_tag }}
                </option>
            @endforeach
        @endif
        {{-- END dùng cho bài viết --}}

        {{-- dùng cho công việc --}}
        @if (isset($job->tags))
            @php
                $job_tags = explode(',',$job->tags)
            @endphp
            @foreach ($job_tags as $job_tag)
                <option value="{{ $job_tag }}" selected>
                    {{ $job_tag }}
                </option>
            @endforeach
        @endif
        {{-- END dùng cho công việc --}}

        {{-- dùng cho công việc facebook --}}
        @if (isset($jobFacebook->tags))
            @php
                $job_tags = explode(',',$jobFacebook->tags)
            @endphp
            @foreach ($job_tags as $job_tag)
                <option value="{{ $job_tag }}" selected>
                    {{ $job_tag }}
                </option>
            @endforeach
        @endif
        {{-- END dùng cho công việc facebook --}}

        {{-- dùng cho tài liệu --}}
        @if (isset($voucher->tags))
            @php
                $job_tags = explode(',',$voucher->tags)
            @endphp
            @foreach ($job_tags as $job_tag)
                <option value="{{ $job_tag }}" selected>
                    {{ $job_tag }}
                </option>
            @endforeach
        @endif
        {{-- END dùng cho tài liệu --}}

        @foreach ($input_tags as $tag)
            <option value="{{ $tag['tag_title'] }}">
                {{ $tag['tag_title'] }}
            </option>
        @endforeach
    </select>
    <br>
    <br>    
    <label for="exampleInputEmail1">
        Không tìm thấy từ khóa ??
        <input type="button" 
            class="btn btn-primary" 
            data-toggle="modal" 
            data-target="#flipFlop"
            value="Thêm mới từ khóa">
    </label>
    {{-- modal thêm mới từ khóa --}}
    <div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabel">Thêm mới từ khóa</h4>
                </div>
                <div class="modal-body">
                    <!-- Nội dung thêm mới -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Từ khóa</label>
                        <input type="text" class="form-control" name="tag_title" placeholder="Tiêu đề">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mô tả</label>
                        <textarea type="text" class="form-control" name="tag_description" placeholder="Mô tả"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="tag_type" value="{{ $tag_type }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary LuuTuKhoa" data-dismiss="modal">Lưu từ khóa</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END modal thêm mới từ khóa --}}
</div>
<br>