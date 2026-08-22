{{--<ul>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('management_account') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-users"></i><span>Thông tin tài khoản</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('show_file_job_facebook') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-id-card "></i><span>Quản lý hồ sơ</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--@if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 2 )--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('getAllJobs') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-list-alt"></i><span>Danh sách tin từ nhà tuyển dụng</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('list_Job_Candidate_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-address-book"></i><span>Danh sách ứng viên ứng tuyển từ nhà tuyển dụng</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('getAllUser') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fab fa-facebook-square"></i><span>Danh sách tin từ tuyển dụng facebook</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('list_Candidate_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fab fa-facebook-square"></i><span>Danh sách ứng viên ứng tuyển từ facebook</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('show_employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-users"></i><span>Danh sách ứng viên của sanketoan</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('show_intership') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-user-graduate"></i><span>Cổng thực tập</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--@endif--}}

{{--check quyen ung vien--}}
{{--@if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 1)--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('list_Jobs_Save_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-download"></i><span>Việc làm đã lưu  </span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('list_Jobs_Submit_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-share-square"></i><span>Việc làm đã nộp hồ sơ </span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('jobs_Like_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-heart"></i><span>Việc làm mong muốn từ nhà tuyển dụng </span>--}}
{{--</a>--}}
{{--</li>--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('job_Like_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-heart"></i><span>Việc làm mong muốn từ facebook</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--@endif--}}

{{--@if (\Illuminate\Support\Facades\Auth::check() && ((\Illuminate\Support\Facades\Auth::user()->role) == 2 || (\Illuminate\Support\Facades\Auth::user()->role) == 3))--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('showExam') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-question-circle"></i><span>Đề thi của bạn</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('showAllExam') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-university"></i><span>Ngân hàng đề thi </span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('room.index') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fab fa-chromecast"></i><span>Danh sách phòng thi </span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('getAllRomResultExam') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-crown"></i><span>Kết quả phòng thi </span>--}}
{{--</a>--}}
{{--</li>--}}

{{--@endif--}}

{{--@if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 3)--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('teacher_learn_employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-chalkboard-teacher"></i><span>Ứng viên đăng ký khóa học</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--@endif--}}
{{--@if(!\Illuminate\Support\Facades\Auth::check())--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('list_Jobs_Save_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-download"></i><span>Việc làm đã lưu  </span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('list_Jobs_Submit_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-share-square"></i><span>Việc làm đã nộp hồ sơ </span>--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('jobs_Like_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-heart"></i><span>Việc làm mong muốn từ nhà tuyển dụng </span>--}}
{{--</a>--}}
{{--</li>--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('job_Like_Employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-heart"></i><span>Việc làm mong muốn từ facebook</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--@endif--}}

{{--@if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 1)--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('listlearn') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-chalkboard-teacher"></i><span>Khoá học đã đăng ký</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{ route('post_sale_employee') }}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-donate"></i><span>Kiếm tiền từ chia sẻ bài</span>--}}
{{--</a>--}}
{{--</li>--}}
{{--@endif--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{route('show_user_job_facebook')}}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>--}}
{{--</a>--}}
{{--</li>--}}

{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{route('logoutHome')}}" class="block hvWhite pd8-20">--}}
{{--<i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>--}}
{{--</li>--}}
{{--<li class="hvbgrBlueN">--}}
{{--<a href="{{route('logoutHome')}}" class="block hvWhite pd8-20">--}}
{{--<i class="far fa-bell"></i><span>Thông báo</span></a>--}}
{{--</li>--}}

{{--</ul>--}}