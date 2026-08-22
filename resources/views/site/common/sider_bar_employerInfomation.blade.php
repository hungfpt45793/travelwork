<div class="col-xl-3 col-lg-3 col-md-12">
   <div class="side-bar-left formJobLarge ">
      <nav>
         <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
               role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
               role="tab" aria-controls="nav-profile" aria-selected="false">Bộ lọc</a>
         </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
         <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
            aria-labelledby="nav-home-tab">
            <div class="account ">
               <br>
               <div class="row ">
                  <div class="col-md-4 ">
                     <div class="accountThumbnail ">
                        <img class="lazy" src="{{isset($employer->image) ? $employer->image : '/CV/Profile.jpg' }}"
                           alt="" width="100% ">
                     </div>
                  </div>
                  <div class="col-md-8" style="padding:0 ">
                     <div class="accountInfo ">
                        <h5>{{isset($user->name) ? $user->name : '' }}</h5>
                        <a href="/dang-xuat">Thoát</a>

                     </div>
                  </div>
               </div>
            </div>
            <br>
            <div class="createNew text-center ">
               <a href="{{route('show_create_job')}}" class="createNewButton ">
                  <i class="fas disInBlock fa-paper-plane "></i>
                  <p class="disInBlock font16 fontBold pd10">Tạo tin tuyển dụng</p>
               </a>
            </div>
            <div class="item ">
               <?php $employer = \App\Entity\Employer::where('employer_user_id', $user->id)->first() ?>
               <ul>
                  <li>
                     <a href="{{route('employer_information')}}">

                     <i class="fas fa-user-circle "></i>&emsp;<span>Quản lý tài khoản</span>
                     </a>
                  </li>
                  <li>
                     <a href="{{route('job_management',['slug'=>$employer->slug])}}">
                     <i class="fas fa-file-alt"></i>&emsp;<span>Quản lý tin tuyển dụng</span>
                     </a>
                  </li>
                  <li>
                     <a href="{{route('show_candidate_apply')}}">
                     <i class="fas fa-id-card "></i>&emsp;<span>Quản lý hồ sơ đã ứng
                     tuyển</span>
                     </a>
                  </li>
                  <li>
                     <a href="{{route('show_candidates')}}">
                        <i class="fas fa-address-book"></i>&emsp;<span>Mời ứng viên</span>
                     </a>
                  </li>
                  <li>
                     <a href="{{route('management_employee',['slug'=>$employer->slug])}}">
                        <i class="fas fa-user-tag"></i>&emsp;<span>Ứng viên đã mời</span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="tab-pane fade" id="nav-profile" role="tabpanel"
            aria-labelledby="nav-profile-tab">
            <div class="filter formJobLarge ">
               <p class="text-title mau ">
                  TÌM THEO NGÀNH
               </p>
               <p>Sắp xếp theo :<span class="disBlock"> <a href="# ">Ngành hot</a> | <a
                  href="# ">ABC</a>
                  </span>
               </p>
               <div class="form-group ">
                  <input type="text " class="form-control " placeholder="Tìm nhanh ">
               </div>
               <p class="jobItem"><a href="# ">Hành chính văn phòng</a></p>
               <p class="jobItem"><a href="# ">Nhân viên kinh doanh</a></p>
               <p class="jobItem"><a href="# ">Bán hàng</a></p>
               <p class="jobItem"><a href="# ">Kế toán kiểm toán</a></p>
               <p class="jobItem"><a href="# ">Tư vấn</a></p>
               <p class="jobItem"><a href="# ">Kỹ thuật</a></p>
               <p class="jobItem"><a href="# ">xây dựng</a></p>
               <p class="jobItem"><a href="# ">Quản trị kinh doanh</a></p>
               <p class="jobItem"><a href="# ">Maketing-PR</a></p>
               <p class="jobItem"><a href="# ">Điện-Điện tử-Điện lạnh</a></p>
               <p class="jobItem"><a href="# ">Cơ khí-Chế tạo</a></p>
               <p class="jobItem"><a href="# ">Nhân sự</a></p>
               <p class="jobItem"><a href="# ">Kiến trúc-TK nội thất</a></p>
            </div>
         </div>
      </div>
   </div>
</div>