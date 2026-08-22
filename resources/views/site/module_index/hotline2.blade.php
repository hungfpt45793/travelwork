<div class="row">

    
    <?php
    $locals = '';
    $locals = \App\Entity\LocationArea::getAll();
    ?>
    @if(!empty($locals))
        @foreach($locals as $local)
            <div class="col-lg-4 col-md-6">
                <div class="itemLocation">
                    <div class="titleLocaltion">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>{{ isset($local['title']) ? $local['title'] : '' }}</h3>
                    </div>
                    <?php
                    $local_branchs = '';
                    $local_branchs = \App\Entity\LocalBranch::getLocal_id($local['local_id']);
                    ?>
                    <div class="itemContent">
                        <form action="#">
                            <input type="text" class="form-control w100 js-search-name mb_border_left_0" js-content = "contentUl{{ isset($local['local_id']) ? $local['local_id'] : '' }}" js-data-localtion="{{ isset($local['local_id']) ? $local['local_id'] : '' }}"  placeholder="Tìm kiếm chi nhánh ...">
                            <button type="button" class="js-button" js-content = "contentUl{{ isset($local['local_id']) ? $local['local_id'] : '' }}" js-data-localtion="{{ isset($local['local_id']) ? $local['local_id'] : '' }}"><i class="fas fa-search"></i></button>
                        </form>
                        <ul class="contentUl{{ isset($local['local_id']) ? $local['local_id'] : '' }} js_max_height_hotline">
                            @foreach($local_branchs as $local_branch)
                                <li>
                                    <a href="{{ isset($local_branch['link']) ? $local_branch['link'] : '' }}" target="_blank"><i class="fas fa-circle" title="{{ isset($local_branch['title']) ? $local_branch['title'] : '' }}"></i>
                                        <span><b>{{ isset($local_branch['title']) ? $local_branch['title'] : '' }}</b></span>
                                        : {{ isset($local_branch['address']) ? $local_branch['address'] : '' }} - {{ isset($local_branch['phone']) ? $local_branch['phone'] : '' }}
                                    </a>

                                </li>
                            @endforeach
                            {{--<li><i class="fas fa-circle"></i>--}}
                            {{--<span><b>Chi nhánh Hà Đông</b></span>--}}
                            {{--: Đường Huỳnh Văn Nghệ, KĐT Sài Đồng, Long Biên, Hà Nội--}}
                            {{--</li>--}}
                            {{--<li><i class="fas fa-circle"></i>--}}
                            {{--<span><b>Chi nhánh Hà Đông</b></span>--}}
                            {{--: Đường Huỳnh Văn Nghệ, KĐT Sài Đồng, Long Biên, Hà Nội--}}
                            {{--</li>--}}
                            {{--<li><i class="fas fa-circle"></i>--}}
                            {{--<span><b>Chi nhánh Hà Đông</b></span>--}}
                            {{--: Đường Huỳnh Văn Nghệ, KĐT Sài Đồng, Long Biên, Hà Nội--}}
                            {{--</li>--}}
                            {{--<li><i class="fas fa-circle"></i>--}}
                            {{--<span><b>Chi nhánh Hà Đông</b></span>--}}
                            {{--: Đường Huỳnh Văn Nghệ, KĐT Sài Đồng, Long Biên, Hà Nội--}}
                            {{--</li>--}}
                            {{--<li><i class="fas fa-circle"></i>--}}
                            {{--<span><b>Chi nhánh Hà Đông</b></span>--}}
                            {{--: Đường Huỳnh Văn Nghệ, KĐT Sài Đồng, Long Biên, Hà Nội--}}
                            {{--</li>--}}
                            {{--<li><i class="fas fa-circle"></i>--}}
                            {{--<span><b>Chi nhánh Hà Đông</b></span>--}}
                            {{--: Đường Huỳnh Văn Nghệ, KĐT Sài Đồng, Long Biên, Hà Nội--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>


kinh nghiem cho ke toan
