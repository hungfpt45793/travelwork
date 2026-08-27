<section class="filter_new filter_exam_hd">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12">
                <div class="filter_new_form">
                    <div class="filter_from_exam">
                        @php
                            $publicExam = \App\Entity\Category::getDetailCategory('cuoc-thi-trac-nghiem');
                            $publicTest = \App\Entity\Category::getDetailCategory('huong-dan-trac-nghiem');
                            $publicExamSlug = data_get($publicExam, 'slug');
                            $publicTestSlug = data_get($publicTest, 'slug');
                            $publicExamUrl = $publicExamSlug
                                ? route('site_category_post', ['slug_cate' => $publicExamSlug])
                                : route('getAllExam');
                            $publicTestUrl = $publicTestSlug
                                ? route('site_category_post', ['slug_cate' => $publicTestSlug])
                                : route('getTestAllExam');
                        @endphp
                        <div class="item_filter_exam @if($active == 'category_exam_new') active_file_exam @endif ">
                            <a href="{{ route('getAllExam') }}" title="Tất cả đề thi">
                                <span class="icon_exam"><i class="fas fa-question"></i></span>
                                <span>Tất cả đề thi</span>
                            </a>
                        </div>
                        <div class="item_filter_exam @if($active == 'category_test') active_file_exam @endif">
                            <a href="{{ route('getTestAllExam') }}" title="Đề thi thử">
                                <span class="icon_exam"><i class="fas fa-text-width"></i></span>
                                <span>Đề thi thử</span>
                            </a>
                        </div>
                        <div class="item_filter_exam">
                            <a href="{{ $publicExamUrl }}" title="{{ data_get($publicExam, 'title', 'Cuộc thi') }}">
                                <span class="icon_exam"><i class="fas fa-compress-arrows-alt"></i></span>
                                <span>Cuộc thi</span>
                            </a>
                        </div>
                        <div class="item_filter_exam">
                            <a  href="{{ route('getRomAll') }}" title="Phòng thi">
                                <span class="icon_exam"><i class="fab fa-chromecast"></i></span>
                                <span>Phòng thi</span>
                            </a>
                        </div>
                        <div class="item_filter_exam">
                            <a target="_blank" href="{{ $publicTestUrl }}" title="{{ data_get($publicTest, 'title', 'Hướng dẫn') }}">
                                <span class="icon_exam"><i class="fab fa-slideshare"></i></span>
                                <span>Hướng dẫn</span>
                            </a>
                        </div>
                    </div>
                    <form class="search_exam" id="searchBox" action="{{ route('submit_category_Exam') }}" method="GET">
                        <?php $word_get = isset($_GET['w']) ? $_GET['w'] : '';?>
                    <div class="input-group mb-3">
                        <input type="text" name="word" class="form-control" placeholder="Tìm bài thi" aria-label="" aria-describedby="basic-addon2" value="{{ $word_get }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

</section>
