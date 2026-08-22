<div class="item">
    @if(\Illuminate\Support\Facades\Auth::check())
        <?php
        $user = \Illuminate\Support\Facades\Auth::user();
        $id_user = $user->id;
        $role = $user->role;
        $static = $user->status_teacher_sc;
        ?>
    @else
        <?php
        $user = '';
        ?>
    @endif
    @if(!\Illuminate\Support\Facades\Auth::check())
        @include('site.sidebar_site.item')
    @endif
    {{--//ứng viên--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 1 )
        @include('site.sidebar_site.item_employee')
    @endif
    {{--nhà tuyển dung--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 2 )
        @include('site.sidebar_site.item_employer')
    @endif
    {{--giáo viên--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 3 && (\Illuminate\Support\Facades\Auth::user()->status_teacher_sc) == 0)
        @include('site.sidebar_site.item_teacher')
    @endif

    {{--giáo viên truong hoc--}}
    @if (\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 3 && (\Illuminate\Support\Facades\Auth::user()->status_teacher_sc) == 1)
        @include('site.sidebar_site.item_teacher_school')
    @endif
</div>
