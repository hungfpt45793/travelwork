@extends('site.layout.site')

@section('title','BẢN GIÁ DỊCH VỤ')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('content')

<section class="contentProducts pdb20 mgt20">
         <div class="container">
            <div class="contentTable bgrWhite pd20 borderRadius10 borderLight font16">
               <div class="titleTable text-ct mgb30 mgt10">
                  <h1 class="fontBold font20">BẢNG GIÁ DỊCH VỤ TUYỂN DỤNG TIVA.VN</h1>
               </div>
               <p class="fontBold mgb10">1. Gói lọc - mời phỏng vấn hồ sơ ứng viên, tiết kiệm tối đa chi phí</p>
               <div class="table-responsive">
                  <table class="table table-bordered">
                  <thead class="white" style="background: #802390">
                     <tr>
                        <th scope="col" width="10%">Tên gói</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col" width="10%">Số lượng</th>
                        <th scope="col" width="10%">Thời gian sử dụng</th>
                        <th scope="col">Tặng kèm</th>
                        <th scope="col" width="10%">Giá thanh toán</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">TIVA01</th>
                        <td class="text-justify">Nhà tuyển dụng có 4.000.000 trong tài khoản đề mời ứng viên. Ứng viên chấp nhận lời mời, sau 03 ngày nhà tuyển dụng không xác nhận thì mức tiền thu theo bảng giá của tiva.vn. Chi phí 100.000/lần đi làm thành công.</td>
                        <td>200 CV</td>
                        <td>52 tuần</td>
                        <td>Bảng mô tả công việc các ngành nghề, Gói chụp ảnh doanh nghiệp</td>
                        <td>2.000.000</td>
                     </tr>
                     <tr>
                        <th scope="row">TIVA01</th>
                        <td class="text-justify">Nhà tuyển dụng có 4.000.000 trong tài khoản đề mời ứng viên. Ứng viên chấp nhận lời mời, sau 03 ngày nhà tuyển dụng không xác nhận thì mức tiền thu theo bảng giá của tiva.vn. Chi phí 100.000VNĐ/lần đi làm thành công.</td>
                        <td>500 CV</td>
                        <td>53 tuần</td>
                        <td>Bảng mô tả công việc các ngành nghề, Gói chụp ảnh doanh nghiệp, Biên tập tin</td>
                        <td>5.500.000</td>
                     </tr>
                  </tbody>
               </table>
               </div>
               
               <p class="fontBold mgb10 mgt30">2. Gói Tuyển Dụng Theo Yêu Cầu, phòng nhân sự thuê ngoài doanh nghiệp</p>
               <div class="table-responsive">
                  <table class="table table-bordered">
                  <thead class="white" style="background: #802390">
                     <tr>
                        <th scope="col" width="10%">Tên gói</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col"width="5%">Số lượng</th>
                        <th scope="col"width="10%">Thời gian tuyển</th>
                        <th scope="col"width="10%">Bảo hành</th>
                        <th scope="col" width="10%">Giá thanh toán tuyển</th>
                        <th scope="col" width="10%">Giá thanh toán tuyển nhanh</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">TIVA03</th>
                        <td class="text-justify">Nhân viên bán hàng, lao động phổ thông, giúp việc gia đình, Học việc garaoto, An ninh bảo vệ, Kho vận.</td>
                        <td>1</td>
                        <td>1-2 tuần</td>
                        <td>01 đổi 1 trong vòng 1 tháng</td>
                        <td>1.000.000</td>
                        <td>1.500.000</td>
                     </tr>
                     <tr>
                        <th scope="row">TIVA04</th>
                        <td class="text-justify">Nhân viên kinh doanh, sale, chăm sóc khách hàng, kế toán, Hành chính văn phòng, lễ tân, nhân sự, Khách sạn nhà hàng, Thiết kế, mỹ thuật, biên dịch, Cơ khí chế tạo. Biên dịch, công ty luật. Du học.</td>
                        <td>1</td>
                        <td>1-2 tuần</td>
                        <td>01 đổi 1 trong vòng 1 tháng</td>
                        <td>1.500.000</td>
                        <td>2.000.000</td>
                     </tr>
                     <tr>
                        <th scope="row">TIVA05</th>
                        <td class="text-justify">Nhân viên bảo hiểm, Kinh doanh bất động sản, Thư ký, trợ lý giám đốc, giám đốc kinh doanh, marketing, ID phần cứng, phần mềm, Spa. Tài chính đầu tư. Ngân hàng.</td>
                        <td>1</td>
                        <td>1-3 tuần</td>
                        <td>01 đổi 1 trong vòng 1 tháng</td>
                        <td>2.000.000</td>
                        <td>1 tháng lương</td>
                     </tr>
                     <tr>
                        <th scope="row">TIVA06</th>
                        <td class="text-justify">Dịch vụ giúp việc theo giờ.</td>
                        <td>1</td>
                        <td>6 giờ</td>
                        <td>30 ngày</td>
                        <td>60.000/giờ</td>
                        <td>80.000/giờ</td>
                     </tr>
                  </tbody>
               </table>
               </div>
               
               <p class="fontBold mgt30 mgb10">Quy Trình Tuyển dụng như sau:</p>
               <p class="mgb10"><b>Bước 1: </b>Nhận yêu cầu từ nhà tuyển dụng qua trang đăng ký <a href="https://tiva.vn/trang/danh-cho-nha-tuyen-dung"> TẠI ĐÂY</a></p>
               <p class="mgb10"><b>Bước 2: </b>Tiva phỏng vấn sơ loại lần 1: Lọc tiêu chí, yêu cầu và test thái độ khẳ năng sẵn sang trong công việc.</p>
               <p class="mgb10"><b>Bước 3: </b>Gửi hồ sơ đạt yêu cầu: Trợ giúp đặt lịch phỏng vấn cho nhà tuyển dụng và note lại những thông tin trao đổi với ứng viên.</p>
               <p class="mgb10"><b>Bước 4: </b>Công Ty phỏng vấn ứng viên lần 2: Bám sát kết quả phỏng vấn và nhận phản hồi để hoàn thành quá trình tuyển dụng.</p>
               <p class="mgb10"><b>Bước 5: </b>Đi làm: Trong thời gian bảo hành 1 tháng từ ngày Ứng viên đi làm, vì bất kể lý do gì ứng viên nghỉ việc thì bảo hành 1 đổi 1. Không giới hạn hồ sơ phỏng vấn đề khi nhà tuyển dụng phỏng vấn đủ thì thôi.</p>
               <p class="fontBold mgb10 mgt30">3. Gói Đăng tin tuyển dụng & Xuất hiện trên trang chủ tin Vip1, Vip 2, Vip 2 theo thời gian show ra trang chủ, trang việc làm theo tỉnh thành, việc làm nhanh</p>
               <div class="table-responsive">
                  <table class="table table-bordered mgb10Im">
                  <thead class="white" style="background: #802390">
                     <tr>
                        <th scope="col" width="10%">Tên gói</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col" width="5%">Số lượng</th>
                        <th scope="col" width="10%">Thời gian sử dụng</th>
                        <th scope="col" width="15%">Tặng kèm</th>
                        <th scope="col" width="10%">Giá thanh toán</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">Việc làm nhanh</th>
                        <td class="text-justify">
                           <p class="mgb10">- Tin đăng hiển thị 4 tuần trên 3 trang ngành nghề và được đẩy top tự động 1 tiếng/1 lần.</p>
                           <p>- Tin đăng được Tô Đậm Đỏ giúp gia tăng 20% lượt views.</p>
                        </td>
                        <td>1 gói</td>
                        <td>4 tuần</td>
                        <td>Công cụ Quản lý CV & Quy trình tuyển dụng cơ bản - ATS</td>
                        <td>1.650.000</td>
                     </tr>
                     <tr>
                        <th scope="row">Việc làm VIP 1, VIP 2, VIP 3</th>
                        <td class="text-justify">
                           <p class="mgb10">- Hiển thị tại mục Việc làm tốt nhất tại trang chủ việc làm & Ứng dụng di động Tiva.</p>
                           <p class="mgb10">- Ưu tiên hiển thị trong nhóm đầu 3 ngành nghề với nền xanh.</p>
                           <p class="mgb10">Ưu tiên hiển thị trong nhóm đầu trong mục Việc làm phù hợp.</p>
                           <p class="mgb10">Ưu tiên hiển thị trước với ứng viên phù hợp trong quá trình ứng viên viết CV.</p>
                           <p>Tin được tự động làm mới, đẩy lên đầu trang mỗi 1 tiếng / lần.</p>
                        </td>
                        <td>1 gói</td>
                        <td>2 tuần</td>
                        <td>Công cụ Quản lý CV & Quy trình tuyển dụng cơ bản - ATS</td>
                        <td>3.300.000</td>
                     </tr>
                     <tr>
                        <th scope="row">Việc làm hot theo tỉnh thành</th>
                        <td class="text-justify">
                           <p class="mgb10">- Hiển thị tại mục Việc làm tốt nhất tại trang chủ việc làm & Ứng dụng di động Tiva.</p>
                           <p class="mgb10">- Ưu tiên hiển thị trong nhóm đầu trong 3 ngành nghề với nền xanh.</p>
                           <p class="mgb10">- Ưu tiên hiển thị trong nhóm đầu trong mục Việc làm phù hợp.</p>
                           <p class="mgb10">- Ưu tiên hiển thị trước với ứng viên phù hợp trong quá trình ứng viên viết CV.</p>
                           <p>- Tin được tự động làm mới, đẩy lên đầu trang mỗi 1 tiếng / lần.</p>
                        </td>
                        <td>1 gói</td>
                        <td>4 tuần</td>
                        <td>Công cụ Quản lý CV & Quy trình tuyển dụng cơ bản - ATS</td>
                        <td>5.720.000</td>
                     </tr>
                  </tbody>
               </table>
               </div>
               
               <p class="red"><i>Được phép kích hoạt 1 tin / 1 tuần, tối đa 4 tin tuyển dụng. Sử dụng tối đa trong 4 tuần.</i></p>
               <p class="fontBold mgt30 mgb10">4. Email marketing</p>
               <div class="table-responsive">
                 <table class="table table-bordered">
                  <thead class="white" style="background: #802390">
                     <tr>
                        <th scope="col" width="10%">Tên gói</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col" width="10%">Số lượng</th>
                        <th scope="col" width="10%">Thời gian sử dụng</th>
                        <th scope="col" width="10%">Tặng kèm</th>
                        <th scope="col" width="10%">Giá thanh toán</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">Email Marketing</th>
                        <td class="text-justify">
                           <p class="mgb10">- Tivadựa theo các tiêu chí tuyển dụng từ phía doanh nghiệp, sau đó lọc ra ít nhất 1000 ứng viên phù hợp và thực hiện gửi email.</p>
                           <p>- Mỗi lần gửi có thể giới Tiva thiệu 1 hoặc nhiều vị trí tuyển dụng của công ty.</p>
                        </td>
                        <td>1000 Email</td>
                        <td>1 lần duy nhất</td>
                        <td>&nbsp</td>
                        <td>3.300.000</td>
                     </tr>
                  </tbody>
               </table>
               </div>

               <p class="fontBold mgb10 mgt30">5. Truyền thông Thương hiệu Tuyển dụng</p>
               <div class="table-responsive">
                                 <table class="table table-bordered">
                  <thead class="white" style="background: #802390">
                     <tr>
                        <th scope="col" width="15%">Tên gói</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col" width="10%">Số lượng</th>
                        <th scope="col" width="10%">Thời gian sử dụng</th>
                        <th scope="col" width="10%">Tặng kèm</th>
                        <th scope="col" width="10%">Giá thanh toán</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">Chuyên trang tuyển dụng - CCTD</th>
                        <td class="text-justify">
                           <p class="mgb10">- Chuyên trang tuyển dụng riêng dành cho công ty.</p>
                           <p class="mgb10">- Xây dựng thương hiệu tuyển dụng hiệu quả.</p>
                           <p>- Tham khảo thêm:<a href=" https://www.Tiva.vn/brand/Tiva">TẠI ĐÂY</a></p>
                        </td>
                        <td>1 Công ty</td>
                        <td>53 tuần</td>
                        <td>Công cụ Quản lý CV & Quy trình tuyển dụng cơ bản - ATS</td>
                        <td>5.500.000 VNĐ</td>
                     </tr>
                     <tr>
                        <th scope="row">Công ty nổi bật - CTNB</th>
                        <td class="text-justify">
                           <p class="mgb10">- Tên công ty và các vị trí đang tuyển dụng sẽ được hiển thị cố định bên phải của tất cả các trang Tìm kiếm việc làm.</p>
                           <p>- Hiển thị theo cơ chế chia sẻ 5 & ngẫu nhiên mỗi lần tải trang.</p>
                        </td>
                        <td>1 Công ty</td>
                        <td>4 tuần</td>
                        <td>&nbsp</td>
                        <td>5.500.000</td>
                     </tr>
                     <tr>
                        <th scope="row">Top công ty - TCT</th>
                        <td class="text-justify">
                           <p class="mgb10">- Công ty sẽ được đưa vào danh sách Top List theo lĩnh vực / ngành nghề, giúp tăng sự tin tưởng và tương tác nhiều hơn từ ứng viên.</p>
                           <p>- Tham khảo thêm: <a href="https://www.Tiva.vn/top-trung-tam-tieng-anh-hang-dau-viet-nam-tl2.html"> TẠI ĐÂY</a></p>
                        </td>
                        <td>1 vị trí</td>
                        <td>4 tuần</td>
                        <td>&nbsp</td>
                        <td>8.800.000</td>
                     </tr>
                  </tbody>
               </table>
               </div>

               <p class="fontBold mgb10 mgt30">6. Gói quảng bá thương hiệu</p>
               <img class="lazy" src="./image/indexTiva.png" alt="Trang chủ Tiva" width="100%">
               <table class="table table-bordered mgt20">
                  <thead  class="white" style="background: #802390">
                     <tr>
                        <th scope="col">Vị trí</th>
                        <th scope="col" width="20%">Giá tiền (VNĐ/4 tuần)</th>
                        <th scope="col" width="30%">Cơ chế chia sẻ</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>Bannner lớn trang chủ việc làm TIVA</td>
                        <td>16.500.000</td>
                        <td>5 NTD/thời điểm</td>
                     </tr>
                     <tr>
                        <td>Banner nhỏ trang chủ việc làm TIVA</td>
                        <td>13.200.000</td>
                        <td>2 NTD/thời điểm</td>
                     </tr>
                  </tbody>
               </table>
               <p class="fontBold mgb10 mgt30">LƯU Ý</p>
               <p class="mgb5">- Bảng giá trên đã bao gồm 10% thuế VAT và chỉ có hiệu lực hết ngày 30/6/2019.</p>
               <p class="mgb5">- Hạn kích hoạt dịch vụ đã mua tối đa 365 ngày kể từ ngày thanh toán.</p>
               <p class="mgb5">- Các dịch vụ đã mua mà chưa được kích hoạt sử dụng, nếu tại thời điểm kích hoạt - dịch vụ đó không còn được cung cấp, sẽ được quy đổi sang các dịch vụ hiện hành khác có giá trị tương đương.</p>
               <p class="text-ct mgt20"><i>Tiva Việt Nam mong muốn có cơ hội được hợp tác lâu dài với Quý công ty. Chúc Quý công ty tuyển dụng thành công!</i></p>

               <div class="notificationBox formJobLarge mt30" style="background: #f6eecc">
                  <div class="">
                     <p class="supportTitle text-ct fontBold font20 mgb30">THÔNG TIN THANH TOÁN</p>
                     <div class="infoPayx">
                        <p class="mgb10 fontBold">Số tài khoản: <b class="font20 red">0711000306679</b> - Nguyễn Xuân Kết - Ngân hàng Công thương Việt Nam VCB Chi nhánh Thanh Xuân, Hà Nội</p>
                        <p class="mgb10 fontBold">Số tài khoản: <b class="font20 red">19029281284028</b> - Đào Thị Hằng - Ngân hàng TMCP Kỹ thương Việt Nam TECHCOMBANK Chi nhánh Ba Đình, Hà Nội</p>
                        <p class="mgb30 fontBold">Số tài khoản: <b class="font20 red">03101012283825</b> -  Công ty CP Tri Thức Vì Dân - Ngân hàng TMCP Hàng Hải Việt Nam MSB Chi nhánh Đống Đa, Hà Nội</p>
                     </div>
                     <div class="hotlineSupport mgt20 font16">
                        <p class="supportTitle text-ct fontBold font20 mgb30">HỖ TRỢ BÁO GIÁ DỊCH VỤ</p>
                        <div class="row">
                           <div class="col-2 text-right fontBold mgb10">Miền Bắc</div>
                           <div class="col-10 text-left mgb10">
                              <div class="row">
                                 <div class="col-4">
                                     <p><span class="red fontBold font20">0914 190 258</span> - Mrs Hằng</p>
                                 </div>
                                 <div class="col-4">
                                     <p><span class="red fontBold font20">024 6262 7806</span> - Mrs Hiền</p>
                                 </div>
                                 <div class="col-4">
                                     <p><span class="red fontBold font20">0967 317 066</span> - Mrs Hương</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-2 text-right fontBold mgb10">Miền Trung</div>
                           <div class="col-10 text-left mgb10">
                              <p><span class="red fontBold font20">0905 181 999</span> - Mrs Hà</p>
                           </div>
                           <div class="col-2 text-right fontBold">Miền Nam</div>
                           <div class="col-10 text-left">
                              <p><span class="red fontBold font20">0906 037 688</span> - Mr Nhân</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

@endsection