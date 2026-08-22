<section class="teacher" style='background: url("{{ asset('assets/image/bgr.jpg') }}") no-repeat;'>
    <div class="contentTeacher bgrGray pdt20 pdb20">
        <div class="infoTeacher container-fluid">
            <div class="row">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <?php $user = \Illuminate\Support\Facades\Auth::user()?>
                    @include('site.sidebar_site.sidebar_teacher',['user'=>$user])
                @endif
                <div class="col-xl-9 col-lg-8 infomartionTeacher">
                    <div class="classOfTeacher ">
                        <div class="Class">
                            <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5 text-center">
                                <h2 class="white fw7 textUpper mgb0 f20">Danh sách giáo viên</h2>
                            </div>
                            <div class="listTeachers bgrWhite pdl20 pdr20 pdb5">
                                <div class="row" style="border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;">
                                    <?php
                                    $list_teacher = \App\Entity\Teacher::get_teacher_course(8)
                                    ?>
                                    @if(!empty($list_teacher))
                                        @foreach($list_teacher as $tea)
                                            <div class="col-xl-3 col-lg-3 pd0 bdBottomGray bdRightGray hvbgrClick">
                                                @include('site.teacher_site.item_teacher')
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end mt-3 mgb15">
                                    <a href="{{ route('showTeacher') }}" class="mx-auto btn-viewmore">Xem tất cả giáo viên</a>
                                </div>
                            </div>
                            <!-- Class -->
                        </div>
                        <!-- classOfTeacher -->
                    </div>
                    <!-- col-lg-8 infomartionTeacher -->
                </div>
                {{--//sidebar khóa hoc--}}
                @if(!\Illuminate\Support\Facades\Auth::check())
                    @include('site.sidebar_site.sidebar_teacher_right');
                @endif
            <!-- row -->
            </div>
            <!-- infoTeacher -->
        </div>
        <!-- contentTeacher -->
    </div>
</section>