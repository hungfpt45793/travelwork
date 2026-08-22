<div class="col-lg-3 col-md-3 col-sm-12 col-12 sideUser sidebarHome" id="sidebarCategory">
    <div class="sidebar-left">
        <div class="titleSideBar">
            Danh mục đề thi
        </div>
        <ul class="sidebar-menu MenuSideHome">
            <li class="has-child pdleft active">
                <a href="/"><i class="fa fa-list-alt" aria-hidden="true"></i>Đề thi chung</a>
            </li>
            <li class="has-child pdleft active2">
                <a href="{{ route('getTestAllExam') }}"><i class="fa fa-list-alt" aria-hidden="true"></i>Đề thi thử</a>
            </li>
            @foreach(\App\Entity\CategoriesExam::getCategories_exam() as $cate_exam)
                <?php $childs = \App\Entity\CategoriesExam::getChilren($cate_exam->id_cate_exam)?>
                <li class="has-child pdleft active{{$cate_exam['id_cate_exam']}} parent{{$cate_exam['parent_cate_exam']}}">
                    <a href="{{ route('getAllExam',['id_cate_exam' => $cate_exam['id_cate_exam'] ]) }}" class="">
                        {!!   isset($cate_exam['icon']) ? $cate_exam['icon'] : '<i class="fa fa-caret-right" aria-hidden="true"></i>' !!}
                        {{ isset($cate_exam['name_cate_exam']) ? $cate_exam['name_cate_exam'] : '' }} </a>
                    @if(!empty($childs) && count($childs) > 0)
                        <ul class="menu-sub menusub2">
                            @foreach( $childs as $child)
                                <li class="has-child pdleft active{{$child['id_cate_exam']}} parent{{$child['parent_cate_exam']}}">
                                    <a href="{{ route('getchildrenExam',['id_cate_exam' => $child['id_cate_exam'] ]) }}"
                                       class="">  {!!   isset($child['icon']) ? $child['icon'] : '<i class="fa fa-caret-right" aria-hidden="true"></i>' !!}{{ isset($child['name_cate_exam']) ? $child['name_cate_exam'] : '' }}
                                    </a>
                                    <?php $childs2 = \App\Entity\CategoriesExam::getChilren($child->id_cate_exam)?>
                                    @if(!empty($childs2) && count($childs2) > 0)
                                        <ul class="menu-sub menusub3">
                                            @foreach($childs2 as $child2)
                                                <li class="active{{$child2['id_cate_exam']}} parent{{$child2['parent_cate_exam']}}"><a
                                                            href="{{ route('getchildren2Exam',['id_cate_exam' => $child2['id_cate_exam'] ]) }}"
                                                            class="">{!!   isset($child2['icon']) ? $child2['icon'] : '<i class="fa fa-caret-right" aria-hidden="true"></i>' !!}{{ isset($child2['name_cate_exam']) ? $child2['name_cate_exam'] : '' }}
                                                    </a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach

        </ul>


    </div>
    <script>
        // $(document).ready(function(){
        //     $('.sidebarHome .sidebar-menu li.has-child .icon').click(function(e){
        //         e.preventDefault();
        //         // $(this).parent().parent().toggleClass('menu-open');
        //         // $('.sidebarHome .sidebar-menu li.has-child .menusub2 .menu-sub').hide();
        //         // $(this).next('ul').hide();
        //         $(this).toggleClass('menu-open').next('ul').slideToggle();
        //
        //     });
        // })
    </script>
</div>