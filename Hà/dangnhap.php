<?php
  session_start();

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
      $account = trim($_POST['account']);
      $pass    = $_POST['password'];

      if (empty($account) || empty($pass)) {
          $error = "Vui lòng nhập đầy đủ thông tin.";
      } else {
          $acc_safe  = $conn->real_escape_string($account);
          $pass_safe = $conn->real_escape_string($pass);
          $sql = "SELECT * FROM nguoidung WHERE Email = '$acc_safe' AND MatKhau = '$pass_safe' LIMIT 1";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
              $user = $result->fetch_assoc();
              $_SESSION['user_id'] = $user['IDNguoiDung'];
              $_SESSION['ten']     = $user['HoTen'];
              $_SESSION['LoaiID']  = $user['LoaiID'];
              if ($user['LoaiID'] == 1) {
                header("Location: trangchukhach.php");
              }
              else{
                if($user['LoaiID'] == 2){
                  header("Location: trangchuctro.php");
                }
                else{
                  header("Location: admin.php");
                }
              }   
              exit();
          } else {
              $error = "Sai tên đăng nhập hoặc mật khẩu!";
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng nhập</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="stylesheet" href="dangnhap.css" />
  </head>
  <body>
    

    <main class="auth">
      <div class="card">
        <header class="head">
          <h1>Đăng nhập</h1>
          <p>Chào mừng quay lại! Đăng nhập để tiếp tục quản lý.</p>
        </header>

        <form id="formLogin" method="post" action="">
          <div class="field">
            <label>Email hoặc SĐT</label>
            <div class="control">
              <i class="fa-regular fa-user"></i>
              <input
                type="text"
                name="account"
                placeholder="Nhập email đã đk"
                required
              />
            </div>
             
          </div>

          <div class="field">
            <label>Mật khẩu</label>
            <div class="control">
              <i class="fa-solid fa-lock"></i>
              <input
                type="password"
                name="password"
                id="password"
                placeholder="Nhập mật khẩu"
                required
              />
              <button
                type="button"
                class="toggle"
                data-target="password"
                aria-label="Ẩn/hiện mật khẩu"
              >
                <i class="fa-regular fa-eye"></i>
              </button>
            </div>
            <small class="error">
               <?php if (!empty($error)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?php echo htmlspecialchars($error); ?>
                </div>
              <?php endif; ?>
            </small>
          </div>

          <div class="row">
            <label class="remember">
              <input type="checkbox" name="remember" />
              Ghi nhớ đăng nhập
            </label>
            <a class="link" href="quenmatkhau.html">Quên mật khẩu?</a>
          </div>

          <button class="btn primary" type="submit">
            <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
          </button>

          <p class="alt">
            Chưa có tài khoản? <a href="dangky.php">Đăng ký</a>
          </p>
        </form>
      </div>
    </main>
  </body>
</html>
