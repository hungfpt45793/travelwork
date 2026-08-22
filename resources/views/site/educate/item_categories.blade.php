<div class="News Voucher">
    <div class="itemVoucher">
        <div class="CropImg">
            {{--getVoucher--}}
            <a href="{{ route('detail_edu_class',['slug'=> $cate_class['edu_class_slug']])}}" class="thumbs"
               title="{{ isset($cate_class['edu_class_name']) ? $cate_class['edu_class_name'] : '' }}" >

                <img class="lazy" src="{{ isset($cate_class['educate_class_image']) ? asset($cate_class['educate_class_image']) : '' }}" alt="{{ isset($cate_class['edu_class_name']) ? $cate_class['edu_class_name'] : '' }}" width="100%" title="{{ isset($cate_class['edu_class_name']) ? $cate_class['edu_class_name'] : '' }}">

            </a>
        </div>
        <div class="info">
            <h5 class="maxTitleVoucher"><a href="{{ route('detail_edu_class',['slug'=> $cate_class['edu_class_slug']])}}"
                                           class="f18 hvBlueDN blueDN CutText2">{{ isset($cate_class['edu_class_name']) ? \App\Ultility\Ultility::textLimit($cate_class['edu_class_name'], 10) : '' }}
                     </a>
            </h5>
        </div>
        <p class="mgb10 fw7">Giáo viên : <a class="clhome f16" target="_blank" href="{{ isset($cate_class->teacher_link) ? $cate_class->teacher_link : '#' }}">{{ isset($cate_class->teacher_name) ? $cate_class->teacher_name : '' }}</a> </p>
        <p class="mgb5">
             <span class="dsInline text-left clred f16 fw7">
                 Thời gian học : <?php
            $date_end=date_create($cate_class->edu_date_end);
            echo date_format($date_end,"d/m/Y");
            ?>
             </span>

            <?php
            $total_employee_class = \App\Entity\Educate_employees_class::get_total_employee_class($cate_class->edu_class_id);
            ?>
            <span class="dsBlock text-right fRight clgreen f14 fw7 mgBottom5">
                <i class="far fa-user"></i> {{ !empty($total_employee_class) ? $total_employee_class : 0 }}/{{ isset($cate_class->edu_total_employee) ? $cate_class->edu_total_employee : '' }}
            </span>
        </p>




    </div>
</div>