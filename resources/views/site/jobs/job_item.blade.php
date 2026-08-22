<li onclick="increaseView(this);">
    <a href="{{ route('job_detail', ['slug' => $job->slug]) }}">
		<input type="hidden" value="{{$job->job_id}}" class="jobID">
		<div class="row">
			<div class="imagesCompanys col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12 marginAuto">
				<img class="lazy" src="{{ !empty($job->image) ? asset($job->image) : asset($job->employer_image) }}" alt="{{ $job->title }}" class="imgListJobItem">
			</div>
			<div class="infomationCompany col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12" style="float:left;border:none">
				<h3>{{ $job->title }}</h3>
				<span class="mgb5">{{ $job->enterprise_name }} </span>
				<span class="mgr20 dsInBlock">
								  <i class="fas fa-map-marker-alt colorAddress"></i> {{ $job->district_name }} - {{ $job->province_name }}
								  </span>
				<span class="mgr20 dsInBlock">
								  <i class="fas fa-coins colorCoin"></i> Lương: {{ $job->salary_description }}
								  </span>
				<span class="mgr20 dsInBlock bulk">
								  <i class="fas fa-user-friends"></i> Số lượng:  {{ $job->number_recruit }}
								  </span>
				<span class="dsInBlock views">
								  <i class="far fa-eye"></i> {{ $job->views }}
								  </span>
			</div>
		</div>
    </a>
    <strong><a href="{{ route('apply_now', ['jobId' => $job->job_id ]) }}" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển
            ngay</a></strong>
</li>