<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <h3 class="clhome f20 mgt15 text-center fw6">Tìm kiếm ứng viên</h3>
    <form class="typeOfBusiness" method="get" action="{{ route('show_employee') }}" >
        <div class="mgt20 mgl10 mgr10">
            <div class="boxTitle relative bgorang white fw7 pd10 text-center">
                <span class="f16">Trình độ ứng viên</span>
                <span class="btn_collapse flRight f18 absolute pd0 right10" id="">
                <i class="fas fa-chevron-down"></i>
              </span>
            </div>
            <div class="boxCheck pd5-10 pdb15 bdLightGray filter" id="type" style="padding-top: 20px;text-shadow: 0 0 black;">
                        <?php
                             $filter_literacys = App\Entity\Literacy::getAll();
                             $employee_level_id_get = isset($_GET['employee_level_id']) ?$_GET['employee_level_id'] : '';
                        ?>
                @foreach($filter_literacys as $filter_literacy)
                        <div class="form-check item col">
                            <label>
                            <input type="radio" name="employee_level_id" class="form-check-input" style="width: 20px;height: 20px" id="exampleCheck1" value="{{ $filter_literacy->literacy_id }}" @if($employee_level_id_get == $filter_literacy->literacy_id) checked @endif>
                           <span style="display: inline-block;margin-top: 5px;margin-left: 5px;">{{ $filter_literacy->literacy_name }}</span>
                            </label>
                        </div>
                    @endforeach

            </div>
        </div>

        <div class="mgt20 mgl10 mgr10">

            <div class="boxTitle relative bgorang white fw7 pd10 text-center">
                <span class="f16">Kinh nghiệm ứng viên</span>
                <span class="btn_collapse flRight f18 absolute pd0 right10" id="">
                <i class="fas fa-chevron-down"></i>
              </span>
            </div>


            <div class="boxCheck pd5-10 pdb15 bdLightGray filter" id="type" style="padding-top: 20px;text-shadow: 0 0 black;">
                <?php
                $filter_experiences = App\Entity\Experience::getAllEx();
                $experience_id_get = isset($_GET['experience_id']) ?$_GET['experience_id'] : '';
                ?>
                @foreach($filter_experiences as $filter_experience)
                    <div class="form-check item col">
                        <label>
                            <input type="radio" name="experience_id" class="form-check-input" style="width: 20px;height: 20px" id="exampleCheck1" value="{{ $filter_experience->experience_id }}" @if($experience_id_get == $filter_experience->experience_id) checked @endif>
                            <span style="display: inline-block;margin-top: 5px;margin-left: 5px;">{{ $filter_experience->experience_name }}</span>
                        </label>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="mgt20 mgl10 mgr10" >
            <button class="btn btn-success w100" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
        </div>
    </form>
</div>

