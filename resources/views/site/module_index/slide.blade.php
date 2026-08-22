<div class="slider1 owl-carousel owl-theme">
    @foreach (\App\Entity\SubPost::showSubPost('slide-trang-chu') as $slide)
        <div class="item">
            <a href="{{ isset($slide['tro-den']) ? $slide['tro-den'] : '' }}">
                <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" width="100%">
            </a>
        </div>
    @endforeach

</div>