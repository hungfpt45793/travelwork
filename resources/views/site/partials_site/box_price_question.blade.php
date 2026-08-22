<div class="row box_question">
    <div class="col-md-12  text-center box_title_question">
        <h2>Câu hỏi thường gặp</h2>
    </div>
    <div class="box_list_question col-md-12">
        @foreach(\App\Entity\SubPost::showSubPost('cac-cau-hoi-thuong-gap-dang-tin-mien-phi',10,'asc') as $id => $item_ques)
            <div class="box_item_ques">
                <p class="box_item_ques_title">{{ !empty($item_ques['title']) ? $item_ques['title'] : '' }}</p>
                <div class="box_item_ques_content">
                    {!! !empty($item_ques['content']) ? $item_ques['content'] : '' !!}
                </div>
            </div>
        @endforeach
    </div>
</div>