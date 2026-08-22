# ONBOARDING — travelwork

> Tài liệu này được viết bằng cách đọc trực tiếp source code trong repo.

> Ngày khảo sát: 2026-08-11 — commit `80788ad9` (branch `main`).

---

## 0. Cảnh báo trước khi đọc

`README.md` hiện tại **không chứa thông tin gì về dự án** — nó là template mặc định của GitLab (checklist "Add your files", "Choose a self-explaining name"...). Xem `README.md:1-93`. Vì vậy toàn bộ tài liệu này suy ra từ code, không phải từ docs.

---

## 1. Dự án giải quyết bài toán gì, phục vụ ai

Đây là một **nền tảng tuyển dụng / việc làm (job portal) tiếng Việt**, có mở rộng thêm mảng **đào tạo (khóa học)** và **thi trắc nghiệm**.

**Bằng chứng — tên route đều bằng tiếng Việt và mô tả rõ nghiệp vụ:**

| Nghiệp vụ | Bằng chứng |
|---|---|
| Nhà tuyển dụng đăng ký | `routes/web.php:58` — `/nha-tuyen-dung-dang-ky` → `RegisterController@showEmployerRegistrationForm` |
| Ứng viên đăng ký | `routes/web.php:60` — `/ung-vien-dang-ky` → `RegisterController@showEmployeeRegistrationForm` |
| Nhóm việc làm | `routes/web.php:46` — `/nhom-viec-lam/{jobGroupSlug}` |
| Tìm kiếm việc làm | `routes/web.php:51-52` — `/tim-kiem`, `/tim-kiem-ajax` |
| API danh sách công việc | `routes/api.php:29-32` — `/cong-viec`, `/chi-tiet-cong-viec/{jobID}` |
| Đào tạo / khóa học | `routes/admin.php:26-31` — `category_course`, `course_formality`, `courses` |
| Ứng viên đăng ký khóa học | `routes/staff.php:15` — `/ung-vien-dang-ky-khoa-hoc` |
| Thi / trắc nghiệm | `app/Exam/` — `Exam.php`, `RoomExam.php`, `ResultExam.php`, `Questions.php` |

**Các nhóm người dùng** — hệ thống phân quyền bằng cột số nguyên `users.role`. Ý nghĩa từng giá trị suy ra từ chỗ code **ghi** giá trị đó khi tạo tài khoản:

| role | Vai trò | Bằng chứng (nơi gán giá trị) |
|---|---|---|
| `1` | Ứng viên (employee) | `app/Http/Controllers/Site/RegisterController.php:155`; xác nhận lại ở `RegisterController.php:346-351` (role 1 → update bảng `Employee`) |
| `2` | Nhà tuyển dụng (employer) | `app/Http/Controllers/Site/EmployerController.php:150`; xác nhận ở `RegisterController.php:353-358` (role 2 → update bảng `Employer`) |
| `3` | Giáo viên (teacher) | `app/Http/Controllers/Site/TeacherController.php:97`, `app/Http/Controllers/Admin/TeacherController.php:135`; xác nhận ở `RegisterController.php:360-365` (role 3 → update `Teacher`) |
| `4` | Admin | `app/Http/Controllers/Admin/AdminController.php:38` — `if(Auth::check() && Auth::user()->role != 4) { return redirect(...) }` |
| `5` | Staff | `app/Http/Controllers/Admin/StaffController.php:107` |
| `6` | Staff HR / Staff member | `app/Http/Controllers/Admin/StaffHrController.php:109`, `app/Http/Controllers/Admin/StaffMemberController.php:108` |
| `7` | **chưa xác định được** — chỉ thấy 1 chỗ so sánh `role == 7` trong code, không tìm thấy chỗ nào gán giá trị 7 |

**Tên sản phẩm thương mại / khách hàng cụ thể: chưa xác định được.** Có vài dấu vết domain trong code nhưng mâu thuẫn nhau, không đủ để kết luận:
- `.gitignore:31-32` liệt kê `.env_ssh_nhacviec.vn` và `.env_ssh_sanketoan.vn` → gợi ý deploy cho nhiều domain (`nhacviec.vn`, `sanketoan.vn`).
- `config/services.php:41` hardcode redirect `http://kidsandmom.vn3c.com/login/google/callback` — domain khác hẳn.
- `database/migrations/vn3c_kidsandmom.sql` — dump DB tên `vn3c_kidsandmom`.
- Commit gần nhất `ca748b7b` có message "day code sanketoan len travelwork".

---

## 2. Tech stack

| Thành phần | Công nghệ | Bằng chứng |
|---|---|---|
| Ngôn ngữ | PHP `>=5.6.4` | `composer.json:11` |
| Framework | **Laravel 5.4** | `composer.json:26` — `"laravel/framework": "5.4.*"` |
| DB mặc định | **MySQL** | `config/database.php:16` — `env('DB_CONNECTION', 'mysql')`; định nghĩa ở `config/database.php:43-56`. (sqlite/pgsql/sqlsrv cũng có sẵn ở `:37`, `:58`, `:71` nhưng chỉ là default của Laravel, không có dấu hiệu đang dùng) |
| Cache | **file** (mặc định) | `config/cache.php:18` — `env('CACHE_DRIVER', 'file')`. Redis/memcached có khai báo (`:72`, `:53`) nhưng chỉ là boilerplate |
| Session | **file** (mặc định) | `config/session.php:19` — `env('SESSION_DRIVER', 'file')` |
| Message queue | **sync** (mặc định = chạy đồng bộ, không có queue thật) | `config/queue.php:18` — `env('QUEUE_DRIVER', 'sync')` |
| Frontend build | **chưa xác định được** | Không có `package.json`, `webpack.mix.js`, hay `gulpfile` ở thư mục gốc. `.gitignore:34-35` cố tình ignore `package.json` và `package-lock.json`. Asset là file tĩnh trong `public/assets` |
| View layer | Blade (server-side rendering) | `resources/views/` — 17 thư mục con, xem `resources/views/site`, `resources/views/admin` |
| Test framework | PHPUnit `~5.7` | `composer.json:54`, cấu hình ở `phpunit.xml` |

**Lý do chọn từng công nghệ: chưa xác định được** — không có ADR, design doc, hay comment nào giải thích. Dưới đây là *quan sát* chứ không phải lý do chính thức:

- **Queue thực tế không được dùng.** `QUEUE_DRIVER` mặc định `sync`, và grep toàn bộ `app/` **không tìm thấy một lời gọi `dispatch()` nào**. Có 1 job class duy nhất `app/Jobs/ProcessPodcast.php:11` implement `ShouldQueue`, cùng vài Mailable ở `app/Mail/Mail.php:11`, `app/Mail/OrderShipped.php:11`, `app/Mail/TestEmail.php:11`. Kết luận: **hạ tầng queue có sẵn nhưng gần như không sử dụng**; việc chạy nền được làm bằng cron (xem mục 3).
- **Cache/Redis cũng vậy** — chỉ là config mặc định của Laravel, không thấy dấu hiệu dùng riêng.

**Các tích hợp bên thứ ba đáng chú ý** (đều từ `composer.json:12-49`):

- **PDF**: `barryvdh/laravel-dompdf`, `dompdf/dompdf`, `setasign/fpdf`, `setasign/fpdi`, `webklex/laravel-pdfmerger`, `ncjoes/poppler-php` → sinh và ghép CV/hợp đồng dạng PDF.
- **Excel/Word**: `maatwebsite/excel`, `phpoffice/phpexcel`, `phpoffice/phpword`, `rap2hpoutre/fast-excel`.
- **Auth mạng xã hội**: `laravel/socialite`, `facebook/graph-sdk` → xem `app/Http/Controllers/Site/FacebookAuthController.php`, `app/Http/Controllers/Site/LoginController.php:335-350` (Google).
- **JWT**: `tymon/jwt-auth` — đăng ký provider ở `config/app.php:173`, facade ở `config/app.php:252`, dùng thực tế ở `app/Http/Controllers/Site/LoginController.php:365` (`JWTAuth::toUser($token)`).
- **SMS / Notification**: `twilio/sdk`; `pusher/pusher-php-server` (nhưng `config/broadcasting.php:18` default là `null` → broadcast đang tắt).
- **Email**: `sendgrid/sendgrid` → `app/Services/SendGridService.php`.
- **Captcha**: `anhskohbo/no-captcha`, `mews/captcha`, `google/recaptcha`, `greggilbert/recaptcha`.
- **AWS**: `aws/aws-sdk-php`. Dùng vào việc gì cụ thể: **chưa xác định được**.
- **Google API**: `google/apiclient`, cộng thêm một bản **copy thủ công** ở thư mục `google-api-php-client-2.4.0_PHP54/` (nằm ngoài `vendor/`).

---

## 3. Kiến trúc tổng thể

### 3.1 Đây là monolith, không phải microservices

Toàn bộ là **một ứng dụng Laravel duy nhất**. Không tìm thấy `Dockerfile`, `docker-compose.yml`, hay service mesh nào. Không có CI config (`.gitlab-ci.yml`, `.github/`, `Jenkinsfile`, `.travis.yml` — **đều không tồn tại**; file YAML duy nhất trong repo là `testapi/.styleci.yml`, thuộc về thư mục phụ).

Việc phân tách không theo service mà theo **"khu vực người dùng" (area)**, mỗi khu vực là một namespace controller + một file route riêng:

```
                    public/index.php          ← entry point HTTP duy nhất
                           │
                    bootstrap/app.php         ← khởi tạo container
                           │
                    App\Http\Kernel           ← middleware toàn cục
                           │
                    RouteServiceProvider
                     ┌─────┴─────┐
                     │           │
             routes/web.php   routes/api.php
                     │           │
                     │           └──► Controllers\Api\*      (31 controller)
                     │
      ┌──────────────┼──────────────┬──────────────┐
      │              │              │              │
 (require_once)  (require_once) (require_once)   (phần còn lại
 routes/admin.php routes/staff.php routes/forum.php  của web.php)
      │              │              │              │
 Controllers\Admin  Controllers\Staff  (rỗng)   Controllers\Site
   (126 file)        (38 file)                    (71 file)
```

**Bằng chứng cho sơ đồ trên:**
- `public/index.php:19,31,43-49` — nạp autoload, `bootstrap/app.php`, rồi `$kernel->handle(Request::capture())`.
- `bootstrap/app.php:29-36` — bind `App\Http\Kernel` và `App\Console\Kernel`.
- `app/Providers/RouteServiceProvider.php:36-43` — `map()` chỉ gọi `mapApiRoutes()` và `mapWebRoutes()`.
- `app/Providers/RouteServiceProvider.php:52-57` — web routes: middleware `web`, file `routes/web.php`.
- `app/Providers/RouteServiceProvider.php:66-72` — api routes: **prefix `api`**, middleware `api`, file `routes/api.php`.
- **Điểm dễ nhầm:** `routes/admin.php` và `routes/staff.php` **không** được `RouteServiceProvider` nạp. Chúng được `require_once` từ bên trong `routes/web.php:16,20,21`. Nghĩa là chúng nằm trong middleware group `web`.
- `routes/forum.php:2-4` — route group `/dien-dan` **rỗng hoàn toàn**, chưa có route nào.
- `routes/web.php:1113` — có thêm `require_once('test_login.php')` nằm sâu trong file.

### 3.2 Phân tầng bên trong: thực tế là 2 tầng

Có một thư mục `app/Biz/` trông như tầng business logic, chứa `ProductBiz.php`, `CategoryProductBiz.php`, `TemplateBiz.php` (`app/Biz/`). **Nhưng nó gần như không được dùng**: chỉ **1 controller duy nhất** trong toàn bộ codebase tham chiếu tới nó — `app/Http/Controllers/Admin/ProductController.php`.

Ngược lại, **286 / 309 controller** import thẳng model Eloquent (`use App\Entity\...`). Nghĩa là:

> **Luồng thực tế: Route → Controller → Eloquent Model → DB.** Không có tầng service/repository ở giữa. Business logic nằm trong controller.

(Cách verify: `grep -rl "use App\\\\Entity" app/Http/Controllers/ | wc -l` → 286; `find app/Http/Controllers -name "*.php" | wc -l` → 309.)

Hai thứ hỗ trợ duy nhất bên cạnh controller:
- `app/Ultility/Ultility.php` — helper tĩnh: `createSlug()` (`:16`), `get_client_ip()` (`:99`), `getCurrentDomain()` (`:119`), `base64_to_jpeg()` (`:248`)... Còn có `CallApi.php`, `ExchangeDate.php`, `Location.php` trong cùng thư mục.
- `app/Services/SendGridService.php` — service class duy nhất trong `app/Services/`.

### 3.3 Model được nhóm theo domain

Model Eloquent không nằm chung một chỗ mà tách theo nghiệp vụ:

| Thư mục | Số file | Nội dung |
|---|---|---|
| `app/Entity/` | **253** | Model lõi: `Employee.php`, `Employer.php`, `User.php`, `Job*`, `Cv_*`, `Coin_*`, `Educate_*`... |
| `app/Course/` | 26 | Khóa học: `Courses.php`, `Course_chapters.php`, `Course_order.php`... |
| `app/Exam/` | 25 | Thi cử: `Exam.php`, `Questions.php`, `RoomExam.php`, `ResultExam.php`... |
| `app/Transaction/` | 5 | Giao dịch: `Transaction_history_bank.php`, `Transaction_history_card.php`... |
| `app/Facebook/` | 3 | `Comment.php`, `Fanpage.php`, `People.php` |

Ví dụ mapping bảng: `app/Entity/Employer.php:17-18` → table `employer`, PK `employer_id`; `app/Entity/Employee.php:26-27` → table `employees`, PK `employee_id`; `app/Entity/User.php:17` → table `users`.

⚠️ **Có 2 model User trùng nhau**: `app/User.php:16` và `app/Entity/User.php:17` — cả hai đều trỏ tới table `users`. Lý do tồn tại cả hai: **chưa xác định được**. `config/services.php:33` tham chiếu `App\User::class`, còn controller thì dùng `App\Entity\User`.

### 3.4 Xử lý nền: bằng cron, không bằng queue

`app/Console/Kernel.php:29-38` khai báo lịch:

| Command | Tần suất | File |
|---|---|---|
| `posts:cron` | mỗi phút | `app/Console/Commands/PostsCron.php:23` — signature; `:30` mô tả "Cập nhập tin tức theo ngày" |
| `voucher:cron` | mỗi phút | `app/Console/Commands/VoucherCron.php` |
| `podcast:cron` | hằng ngày 11:00 | `app/Console/Commands/PodcastCron.php` |
| `notification:cron` | ngày 1 hàng tháng, 00:00 | `app/Console/Commands/NotificationPostCron.php` |

Lưu ý `app/Console/Kernel.php:16-21` đăng ký 4 command, nhưng thư mục `app/Console/Commands/` có **5 file** — `TestCron.php` không được đăng ký.

Timezone toàn app là `Asia/HO_CHI_MINH` (`config/app.php:67`), locale là `en` (`config/app.php:80`).

---

## 4. Cây thư mục — trách nhiệm từng folder

### Cấp 1

| Folder | Trách nhiệm | Ghi chú |
|---|---|---|
| `app/` | Toàn bộ code ứng dụng (PSR-4 `App\` → `app/`, xem `composer.json:60-62`) | |
| `bootstrap/` | Khởi tạo framework — `app.php`, `autoload.php` | |
| `config/` | 22 file config Laravel | |
| `database/` | `migrations/`, `seeds/`, `factories/` | ⚠️ xem cảnh báo bên dưới |
| `routes/` | 8 file route | Tổng ~180KB — `web.php` 83KB, `admin.php` 45KB, `staff.php` 38KB |
| `resources/` | `views/` (Blade), `assets/`, `lang/` | |
| `public/` | **Web root** — `index.php` + asset tĩnh | |
| `storage/` | Log, cache, file upload, `excel/`, `fonts/`, `debugbar/` | |
| `tests/` | Test PHPUnit | |
| `library/` | Ảnh upload (`library/images/`, `library/.thumbs/`) | |
| `upload/` | File upload | Vai trò khác `library/` thế nào: **chưa xác định được** |
| `font/` | Font `.ttf`/`.woff` (Roboto, FontAwesome) | Phục vụ sinh PDF hay frontend: **chưa xác định được** |
| `google-api-php-client-2.4.0_PHP54/` | Bản copy thủ công của Google API client, để ngoài `vendor/` | Vì sao không dùng bản composer (`composer.json:20`): **chưa xác định được** |
| `testapi/` | **Một project Laravel thứ hai, hoàn chỉnh và riêng biệt** | Có `composer.json`, `artisan`, `app/`, `routes/`, `.env.example`, `webpack.mix.js` riêng. Quan hệ với app chính: **chưa xác định được** |
| `test/` | Chỉ chứa `test/index.html` | Mục đích: **chưa xác định được** |

**File lạ ở thư mục gốc** (không rõ vai trò, nhiều khả năng là rác nên commit nhầm): `index.html` (115KB), `11212.txt`, `Bảng giá 5 TP 2024.docx`, `~$ng giá 5 TP 2024.docx` (file lock tạm của MS Word), `sitemap.xml` (87KB), `config/.swp` (file swap của vim).

### Cấp 2 — bên trong `app/`

| Folder | Trách nhiệm |
|---|---|
| `app/Http/Controllers/Site/` | 71 controller — giao diện người dùng cuối (ứng viên, NTD) |
| `app/Http/Controllers/Admin/` | 126 controller — trang quản trị |
| `app/Http/Controllers/Staff/` | 38 controller — trang nhân viên nội bộ |
| `app/Http/Controllers/Api/` | 31 controller — REST API |
| `app/Http/Controllers/Auth/` | 4 controller scaffold mặc định của Laravel: `LoginController`, `RegisterController`, `ForgotPasswordController`, `ResetPasswordController` |
| `app/Http/Middleware/` | 6 middleware — xem mục 5.2 |
| `app/Entity/`, `app/Course/`, `app/Exam/`, `app/Transaction/`, `app/Facebook/` | Model Eloquent theo domain (mục 3.3) |
| `app/Console/Commands/` | 5 cron command (mục 3.4) |
| `app/Providers/` | 5 service provider chuẩn Laravel |
| `app/Ultility/` | Helper tĩnh (lưu ý: viết sai chính tả, đúng ra là "Utility") |
| `app/Biz/` | Tầng business logic — **hầu như không dùng** (mục 3.2) |
| `app/Services/` | Chỉ có `SendGridService.php` |
| `app/Jobs/`, `app/Mail/`, `app/Exceptions/` | Job (1 file), Mailable (3 file), exception handler |

### Cấp 2 — bên trong `resources/views/`

17 thư mục: `admin/`, `site/`, `staff_admin/`, `customers/`, `emails/`, `mail/`, `jobs/`, `orders/`, `sales/`, `report/`, `promotion/`, `voucher/`, `general/`, `sidebar/`, `sitemap/`, `vendor/`, cộng `sitemap.blade.php` và `sitemap.xml`.

---

## 5. Entry point — request đi vào hệ thống từ đâu

### 5.1 Luồng HTTP

1. **`public/index.php`** — entry point duy nhất. Web server phải trỏ document root vào `public/`.
   - `public/index.php:19` → `require __DIR__.'/../bootstrap/autoload.php'`
   - `public/index.php:31` → `$app = require_once __DIR__.'/../bootstrap/app.php'`
   - `public/index.php:43-49` → `$kernel->handle(Request::capture())` rồi `$response->send()`
2. **`bootstrap/app.php:29-36`** — bind HTTP Kernel và Console Kernel.
3. **`app/Http/Kernel.php:16-21`** — middleware toàn cục: `CheckForMaintenanceMode`, `ValidatePostSize`, `TrimStrings`, `ConvertEmptyStringsToNull`.
4. **`app/Providers/RouteServiceProvider.php:36-72`** — nạp route (sơ đồ ở mục 3.1).
5. Controller → Model → View.

Ngoài ra có `server.php` ở gốc — file router cho `php artisan serve`.

**Entry point CLI**: `artisan` ở thư mục gốc → `app/Console/Kernel.php`.

### 5.2 Middleware — điều bạn cần biết trước khi sửa gì

`app/Http/Kernel.php:28-50` định nghĩa 2 group:
- **`web`** (`:29-44`): `EncryptCookies`, `AddQueuedCookiesToResponse`, `StartSession`, `ShareErrorsFromSession`, `SubstituteBindings`.
- **`api`** (`:46-49`): `throttle:60,1`, `bindings`.

`app/Http/Kernel.php:59-67` định nghĩa route middleware, đáng chú ý: `'admin' => \Illuminate\Auth\Middleware\Authenticate::class` (`:60`) — tức alias `admin` chỉ là middleware `auth` mặc định, **không hề kiểm tra vai trò admin**.

⚠️ **Ba điểm cần đặc biệt lưu ý (đã verify trực tiếp trong code, không phải suy đoán):**

1. **CSRF đang bị tắt.** `app/Http/Kernel.php:35` — dòng `\App\Http\Middleware\VerifyCsrfToken::class` **bị comment out**. Class vẫn tồn tại ở `app/Http/Middleware/VerifyCsrfToken.php` nhưng không nằm trong pipeline. Lý do: **chưa xác định được** (không có comment giải thích).

2. **Route group admin có lỗi cú pháp khiến middleware không được áp dụng.** `routes/admin.php:2`:
   ```php
   Route::group(['middleware' => 'HtmlMifier', 'prefix' => 'admin', 'namespace' => 'Admin', ' ' => ['admin']], function () {
   ```
   Key cuối cùng là `' '` (một dấu cách) chứ không phải `'middleware'` → mảng `['admin']` bị Laravel bỏ qua. Nhóm route admin **chỉ có `HtmlMifier`**, không có middleware xác thực nào.

3. **Phân quyền được làm trong constructor của controller, không phải middleware.** Ví dụ `app/Http/Controllers/Admin/AdminController.php:38-40`:
   ```php
   if(Auth::check() && Auth::user()->role != 4) {
       return redirect(route('name'));
   }
   ```
   Lưu ý: `return redirect(...)` bên trong `__construct()` **không dừng được request** trong PHP — giá trị trả về của constructor bị bỏ đi. Ngoài ra điều kiện `Auth::check() &&` nghĩa là **khách chưa đăng nhập sẽ không bị chặn ở đây**.
   140 file trong `app/Http/Controllers/Admin/` có gọi `middleware(` ở đâu đó, nhưng cần kiểm tra từng file — không có chuẩn chung.

   → **Khuyến nghị:** trước khi đụng vào bất cứ chức năng admin/staff nào, hãy hỏi team lead xem tầng bảo vệ thật nằm ở đâu (có thể ở tầng web server / VPN / firewall). Đây là quan sát từ code, tôi không có thông tin về môi trường production.

### 5.3 Cơ chế đăng nhập

- `config/auth.php:16-17` — guard mặc định `web`; `:39-42` guard `web` dùng driver `session`; `:44-47` guard `api` dùng driver `token`.
- `config/auth.php:73-76` — user provider dùng driver **`database`** (query thẳng table `users`), **không phải `eloquent`**. Phần `eloquent` trỏ tới `App\Entity\User::class` bị comment ở `config/auth.php:68-71`.
- Đăng nhập chính: `app/Http/Controllers/Site/LoginController.php:144-230` — tìm user theo email (`:152`), chống brute-force bằng `hasTooManyLoginAttempts()` (`:158`), rồi `attemptLogin()` (`:163`), sau đó rẽ nhánh theo `role` (`:170`, `:220`, `:228`).
  - ⚠️ `app/Http/Controllers/Site/LoginController.php:165-166` — `session()->regenerate()` và `clearLoginAttempts()` **bị comment out**, kèm ghi chú "tam an de test laij dang nhap" (tạm ẩn để test lại đăng nhập). Không regenerate session ID sau khi đăng nhập là một điểm cần lưu ý.
- Đăng nhập Google: `LoginController.php:335-350`. Đăng nhập Facebook: `LoginController.php:94-110` và `app/Http/Controllers/Site/FacebookAuthController.php`.
- Đăng nhập bằng JWT: `LoginController.php:361-366` — `JWTAuth::toUser($token)` rồi `Auth::login()`.

### 5.4 API

- Toàn bộ route trong `routes/api.php` **tự động có prefix `/api`** (`app/Providers/RouteServiceProvider.php:68`). Ví dụ `routes/api.php:29` khai báo `/cong-viec` → URL thật là `/api/cong-viec`.
- `routes/api.php:18` — group namespace `Api`.
- Rate limit 60 req/phút (`app/Http/Kernel.php:47`).
- ⚠️ `routes/api.php:15-17` — middleware `auth:api` bị comment out. Các endpoint như `/api/infor-user` (`routes/api.php:25`) **không thấy khai báo middleware auth ở tầng route**; nếu có kiểm tra thì nằm trong controller. Tôi chưa verify từng controller một.

---

## 6. Chạy local + chạy test

> ⚠️ **Không có tài liệu setup nào trong repo** (`README.md` là template GitLab, không có `Makefile`, `Dockerfile`, `docker-compose.yml`, hay script setup). Các bước dưới đây là **quy trình chuẩn của Laravel 5.4** suy ra từ file cấu hình có sẵn, **không phải quy trình đã được xác nhận của team**. Hãy đối chiếu với đồng nghiệp.

### 6.1 Yêu cầu môi trường

- PHP `>= 5.6.4` (`composer.json:11`). Lưu ý Laravel 5.4 rất cũ — PHP 8.x nhiều khả năng không chạy được. Phiên bản PHP chính xác team đang dùng: **chưa xác định được**.
- MySQL (`config/database.php:16`).
- Composer.
- ⚠️ `vendor/` **không có trong repo** (bị ignore ở `.gitignore:23`), phải chạy `composer install`.

### 6.2 Các bước

```bash
composer install

# ⚠️ KHÔNG CÓ .env.example ở thư mục gốc — xem cảnh báo bên dưới
php artisan key:generate

php artisan serve      # dùng server.php làm router
```

⚠️ **Vấn đề chặn:** `composer.json:71` khai báo script `post-root-package-install` copy `.env.example` → `.env`, **nhưng file `.env.example` không tồn tại ở thư mục gốc**. File `.env.example` duy nhất trong repo nằm ở `testapi/.env.example` — thuộc project phụ, không chắc dùng được cho app chính.

→ **Bạn phải xin file `.env` từ đồng nghiệp.** Các biến tối thiểu suy ra từ config: `APP_KEY`, `APP_ENV`, `APP_DEBUG`, `APP_URL` (`config/app.php:15,28,41,54`); `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (`config/database.php:43-49`). Ngoài ra còn `FACEBOOK_APP_ID`/`FACEBOOK_APP_SECRET`/`FACEBOOK_URL` (`config/services.php:44-46`), và các key cho SendGrid / Twilio / AWS / reCAPTCHA nếu cần dùng chức năng tương ứng.

### 6.3 Cơ sở dữ liệu — điểm cần chú ý nhất

⚠️ **`php artisan migrate` sẽ KHÔNG dựng được schema.** Thư mục `database/migrations/` chỉ có **2 file**:
- `2017_11_14_022231_create_ratings_table.php` — migration thật duy nhất (528 bytes), tạo bảng ratings.
- `vn3c_kidsandmom.sql` — **file dump SQL đặt nhầm chỗ** (115KB, chứa 27 lệnh `CREATE TABLE`). Đây không phải migration, Laravel sẽ bỏ qua nó.

Trong khi đó `app/Entity/` có **253 model**. Nghĩa là schema thật lớn hơn nhiều so với những gì migration mô tả, và **schema không được quản lý bằng migration**.

→ **Bạn phải xin một bản dump database từ đồng nghiệp.** File `vn3c_kidsandmom.sql` có thể là dump cũ/của project khác (tên khớp với domain `kidsandmom.vn3c.com` ở `config/services.php:41`) — 27 bảng là quá ít so với 253 model. **Có dùng được không: chưa xác định được, đừng tự ý import đè.**

Ngoài ra `composer.json:57-59` classmap cả thư mục `database/`, nên file `.sql` nằm đó là bất thường.

### 6.4 Chạy cron (nếu cần test tính năng nền)

```bash
php artisan schedule:run     # chạy 1 lần
php artisan posts:cron       # chạy riêng 1 command
```
Trên server thật cần crontab gọi `schedule:run` mỗi phút (chuẩn Laravel). Crontab thực tế của production: **chưa xác định được**.

### 6.5 Chạy test

```bash
./vendor/bin/phpunit                        # toàn bộ
./vendor/bin/phpunit --testsuite Unit       # chỉ Unit
./vendor/bin/phpunit --testsuite Feature    # chỉ Feature
```

Cấu hình ở `phpunit.xml`: bootstrap `bootstrap/autoload.php`; 2 testsuite `Feature` → `./tests/Feature` và `Unit` → `./tests/Unit`; env override `APP_ENV=testing`, `CACHE_DRIVER=array`, `SESSION_DRIVER=array`, `QUEUE_DRIVER=sync`.

⚠️ **Thực tế không có test nào.** Thư mục `tests/` chỉ có 4 file:
- `tests/Unit/ExampleTest.php` — scaffold mặc định của Laravel
- `tests/Feature/ExampleTest.php` — scaffold mặc định
- `tests/TestCase.php`, `tests/CreatesApplication.php` — hạ tầng

→ **Độ phủ test ~0%. Không có CI.** Mọi thay đổi phải test thủ công. Đây là rủi ro lớn nhất khi bạn sửa code trong repo này.

---

## 7. Tóm tắt cho ngày đầu tiên

**Nắm 5 điều này trước:**

1. Monolith Laravel 5.4, chia theo 4 khu vực: `Site` (người dùng cuối) / `Admin` / `Staff` / `Api`. Mỗi khu vực = 1 namespace controller + 1 file route.
2. Business logic nằm **trong controller**. Không có tầng service. `app/Biz/` là tàn dư, chỉ 1 controller dùng.
3. Phân quyền bằng số `users.role`: 1=ứng viên, 2=NTD, 3=giáo viên, 4=admin, 5=staff, 6=staff HR.
4. Muốn hiểu một tính năng: tìm URL tiếng Việt trong `routes/web.php` (83KB) → ra tên controller + method.
5. **Không có test, không có CI, schema không có migration.** Test thủ công là bắt buộc.

**Cần hỏi đồng nghiệp ngay (những thứ không có trong code):**

- File `.env` (không có `.env.example` ở gốc).
- Bản dump database dùng được (`database/migrations/` không dựng nổi schema).
- Phiên bản PHP chính xác của môi trường dev/production.
- Sản phẩm này chạy trên (những) domain nào — code có dấu vết `nhacviec.vn`, `sanketoan.vn`, `kidsandmom.vn3c.com` mâu thuẫn nhau.
- Thư mục `testapi/` là gì và có còn dùng không.
- Tầng bảo vệ thật của khu vực admin nằm ở đâu (mục 5.2).
- CSRF bị tắt (`app/Http/Kernel.php:35`) là cố ý hay sót lại.

---

## 8. Danh mục "chưa xác định được"

Liệt kê lại để bạn tiện đối chiếu khi hỏi team — đây là những chỗ tôi **không tìm được bằng chứng trong code**:

| # | Câu hỏi |
|---|---|
| 1 | Tên sản phẩm thương mại / domain chính thức |
| 2 | Lý do chọn từng công nghệ trong stack |
| 3 | Thư mục `testapi/` dùng để làm gì, còn hoạt động không |
| 4 | Ý nghĩa `role == 7` (chỉ có chỗ đọc, không có chỗ ghi) |
| 5 | Vì sao có 2 model User (`app/User.php` và `app/Entity/User.php`) |
| 6 | Vì sao copy thủ công `google-api-php-client-2.4.0_PHP54/` ra ngoài `vendor/` |
| 7 | Khác biệt giữa `upload/` và `library/` |
| 8 | Thư mục `font/` phục vụ PDF hay frontend |
| 9 | Mục đích của `test/index.html` |
| 10 | Frontend build pipeline (không có `package.json`) |
| 11 | `database/migrations/vn3c_kidsandmom.sql` có dùng được không |
| 12 | Phiên bản PHP của môi trường thật |
| 13 | Crontab production |
| 14 | AWS SDK dùng vào việc gì |
| 15 | Vì sao CSRF bị comment out |
| 16 | Các endpoint `/api/*` được bảo vệ ở đâu (nếu có) |

---

*Tài liệu sinh bởi việc đọc code tại commit `80788ad9`. Nếu bạn phát hiện chỗ nào sai, hãy sửa trực tiếp file này và ghi kèm đường dẫn file làm bằng chứng.*
