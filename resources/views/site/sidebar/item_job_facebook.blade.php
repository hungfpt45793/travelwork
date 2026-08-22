<div class="item">
    @if(!\Illuminate\Support\Facades\Auth::check())
        @include('site.sidebar.item')
    @endif
    {{--//ứng viên--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
        @include('site.sidebar.item_employee')
    @endif
    {{--nhà tuyển dung--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 2 )
        @include('site.sidebar.item_employer')
    @endif
    {{--giáo viên--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 3 && (\Illuminate\Support\Facades\Auth::user()->status_teacher_sc) == 0)
        @include('site.sidebar.item_teacher')
    @endif

    {{--giáo viên truong hoc--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 3 && (\Illuminate\Support\Facades\Auth::user()->status_teacher_sc) == 1)
        @include('site.sidebar.item_teacher_school')
    @endif
</div>
