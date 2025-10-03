  $servername = "localhost";
  $username   = "root";
  $password   = "";
  $dbname     = "congcu";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Kết nối thất bại: " . $conn->connect_error);
  }

  $error = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $fullName = trim($_POST['fullName']);
      $email    = trim($_POST['email']);
      $phone    = trim($_POST['phone']);
      $pass     = $_POST['password'];
      $confirm  = $_POST['confirm'];
      $role     = $_POST['role'] ?? "";

      if (empty($fullName) || empty($email) || empty($phone) || empty($pass)) {
          $error = "Vui lòng nhập đầy đủ thông tin.";
      } elseif ($pass !== $confirm) {
          $error = "Mật khẩu nhập lại không khớp.";
      } elseif (empty($role)) {
          $error = "Vui lòng chọn vai trò.";
      } else {
          $fullName_safe = $conn->real_escape_string($fullName);
          $email_safe    = $conn->real_escape_string($email);
          $phone_safe    = $conn->real_escape_string($phone);
          $pass_safe     = $conn->real_escape_string($pass);
          $role_safe     = ($role === "host") ? 2 : 1; // 2 = chủ trọ, 1 = khách

          $sql = "INSERT INTO nguoidung (HoTen, Email, SDT, MatKhau, LoaiID)
                  VALUES ('$fullName_safe', '$email_safe', '$phone_safe', '$pass_safe', '$role_safe')";

          if ($conn->query($sql) === TRUE) {
              header("Location: dangnhap.php");
              exit();
          } else {
              $error = "Lỗi khi đăng ký: " . $conn->error;
          }
      }
  }
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Đăng ký tài khoản</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="dangky.css" />
</head>
<body>
  <main class="auth">
    <div class="card">
      <header class="head">
        <h1>Đăng ký</h1>
        <p>Tạo tài khoản để quản lí phòng trọ, bài đăng và lịch xem phòng.</p>
      </header>
      <?php if (!empty($error)): ?>
        <div style="color:red; text-align:center; margin-bottom:10px;">
          <?= $error ?>
        </div>
      <?php endif; ?>
      <form id="formRegister" method="post" action="dangky.php" novalidate>
        <div class="grid">
          <div class="field">
            <label>Họ và tên</label>
            <div class="control">
              <i class="fa-regular fa-user"></i>
              <input type="text" name="fullName" placeholder="VD: Nguyễn Văn A" required />
            </div>
            <small class="error"></small>
          </div>

          <div class="field">
            <label>Email</label>
            <div class="control">
              <i class="fa-regular fa-envelope"></i>
              <input type="email" name="email" placeholder="you@example.com" required />
            </div>
            <small class="error"></small>
          </div>

         <div class="field">
            <label>Số điện thoại</label>
            <div class="control">
              <i class="fa-solid fa-phone"></i>
              <input type="tel" name="phone" placeholder="09xxxxxxxx" required />
            </div>
            <small class="error"></small>
          </div>
        

          <div class="field">
            <label>Mật khẩu</label>
            <div class="control">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Tối thiểu 8 ký tự" required />
              <button type="button" class="toggle" data-target="password" aria-label="Ẩn/hiện mật khẩu">
                <i class="fa-regular fa-eye"></i>
              </button>
            </div>
            <small class="hint">Ít nhất 8 ký tự, gồm chữ và số.</small>
            <small class="error"></small>
          </div>

          <div class="field">
            <label>Nhập lại mật khẩu</label>
            <div class="control">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="confirm" id="confirm" placeholder="Nhập lại mật khẩu" required />
              <button type="button" class="toggle" data-target="confirm" aria-label="Ẩn/hiện mật khẩu">
                <i class="fa-regular fa-eye"></i>
              </button>
            </div>
            <small class="error"></small>
          </div>
        </div>

        <div class="role-select" aria-label="Chọn vai trò khi đăng ký">
          <label class="role">
            <input type="radio" name="role" value="host">
            <span><i class="fa-solid fa-house"></i> Chủ trọ</span>
          </label>
          <label class="role">
            <input type="radio" name="role" value="customer">
            <span><i class="fa-solid fa-user"></i> Khách hàng</span>
          </label>
        </div>
        <small class="error" id="roleError"></small>

        <label class="agree">
          <input type="checkbox" name="terms" required />
          Tôi đồng ý với <a href="#">Điều khoản</a> và <a href="#">Chính sách</a>.
        </label>

        <button class="btn primary" type="submit">
          <i class="fa-solid fa-user-plus"></i> Tạo tài khoản
        </button>

        <p class="alt">Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p>
      </form>
    </div>
  </main>
</body>
</html>
