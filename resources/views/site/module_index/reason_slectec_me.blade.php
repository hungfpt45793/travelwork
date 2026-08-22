<div class="righttil lineHeight25">Vì sao nên chọn chúng tôi?</div>
<ul class="proviso">
    @foreach (\App\Entity\SubPost::showSubPost('vi-sao-chon-chung-toi') as $id => $reason)
    <li class="hoverBgrTimn">
        <a href="javascript:;" class="hoverBlack">
            <div>
                <b>{{ ($id + 1) }}</b>
            </div>
            <span class="CutText3">{{ $reason->title }}</span>
        </a>
    </li>
    @endforeach
</ul>