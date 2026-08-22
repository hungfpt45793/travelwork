<div class="row">
    <div class="col-lg-12">
        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 )
            <?php
            $employee_static = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
            $employee_coints_static = \App\Entity\Employee_coins::get_id($employee_static->employee_id);
            ?>
            <div class="content_money">
                <div class="title_money">
                    <h5>
                        Thống kê lượt chia sẻ và lượt xem
                    </h5>
                </div>
            </div>
            <div class="money_table">
                <div class="table-responsive ">
                    <table id="jobfb" class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            {{--<th class="text-center">STT</th>--}}
                            <th class="text-center"><a href="{{ route('list_post') }}#js_tab_link">Bài viết</a></th>
                            <th class="text-center"><a href="{{ route('list_course') }}#js_tab_link">Khóa học</a></th>
                            <th class="text-center"><a href="{{ route('list_voucher') }}#js_tab_link">Tài liệu</a></th>
                            <th class="text-center"><a href="{{ route('list_job') }}#js_tab_link">Tin tuyển dụng</a>
                            </th>
                            <th class="text-center"><a href="{{ route('list_intership') }}#js_tab_link">Tin thực tập</a>
                            </th>
                            <th class="text-center"><a href="#">Số xu dư</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                        <tr>
                            <td class="text-center">{{ isset($employee_coints_static->total_sale) ? number_format($employee_coints_static->total_sale) : 0 }}
                                <i class="fas fa-share"></i>
                                / {{ isset($employee_coints_static->total_view) ? number_format($employee_coints_static->total_view) : 0 }}
                                <i class="far fa-eye"></i></td>
                            <td class="text-center">{{ isset($employee_coints_static->total_sale_course) ? number_format($employee_coints_static->total_sale_course) : 0 }}
                                <i class="fas fa-share"></i>
                                / {{ isset($employee_coints_static->total_view_course) ? number_format($employee_coints_static->total_view_course) : 0 }}
                                <i class="far fa-eye"></i></td>
                            <td class="text-center">{{ isset($employee_coints_static->total_sale_voucher) ? number_format($employee_coints_static->total_sale_voucher) : 0 }}
                                <i class="fas fa-share"></i>
                                / {{ isset($employee_coints_static->total_view_voucher) ? number_format($employee_coints_static->total_view_voucher) : 0 }}
                                <i class="far fa-eye"></i></td>
                            <td class="text-center">{{ isset($employee_coints_static->total_sale_job) ? number_format($employee_coints_static->total_sale_job) : 0 }}
                                <i class="fas fa-share"></i>
                                / {{ isset($employee_coints_static->total_view_job) ? number_format($employee_coints_static->total_view_job) : 0 }}
                                <i class="far fa-eye"></i></td>
                            <td class="text-center">{{ isset($employee_coints_static->total_sale_employer) ? number_format($employee_coints_static->total_sale_employer) : 0 }}
                                <i class="fas fa-share"></i>
                                / {{ isset($employee_coints_static->total_view_employer) ? number_format($employee_coints_static->total_view_employer) : 0 }}
                                <i class="far fa-eye"></i></td>
                            <td class="text-center">
                            <span class="red">{{ !empty(Auth::check()) ? number_format(Auth::user()->user_coin) : 0 }}
                        xu </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="NoteTransaction">
    {!! isset($information_money['quy-dinh-chung-ve-rut-tien-va-doi-thuong']) ? $information_money['quy-dinh-chung-ve-rut-tien-va-doi-thuong'] : '' !!}
</div>

<hr>
