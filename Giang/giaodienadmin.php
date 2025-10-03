<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Sidebar</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS riêng -->
  <link rel="stylesheet" href="giaodienadmin.css">
  <style>
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f8f8f8;
    }

    .sidebar {
      width: 220px;
      background: #fff;
      height: 100vh;
      border-right: 1px solid #ddd;
      padding: 24px 16px;
    }

    .sidebar h2 {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .sidebar .section-title {
      font-size: 14px;
      font-weight: bold;
      color: #555;
      margin-bottom: 14px;
    }

    .menu a {
      display: flex;
      align-items: center;
      padding: 10px;
      margin-bottom: 8px;
      text-decoration: none;
      color: #222;
      border-radius: 6px;
      font-size: 15px;
      transition: 0.2s ease;
    }

    .menu a i {
      width: 20px;
      margin-right: 10px;
      text-align: center;
    }

    

    .menu a:hover {
      background: #eaeaea;
    }
    .main-content {
      padding: 30px;
      flex: 1;
      background: #f8f8f8;
    }

    .main-content h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .main-content p {
      font-size: 16px;
      color: #333;
    }
    .container {
      display: flex;
    }


  </style>
</head>
<body>

  <div class="container"> <!-- ✅ Bọc cả sidebar + main-content -->
    <div class="sidebar">
      <h2>Dashboard</h2>
      <nav class="menu">
        <a href="quanliphong.html"><i class="fa-solid fa-house"></i> Quản lí phòng</a>

        <!-- ✅ Sửa thành hình người -->
        <a href="quanlinguoidung.html"><i class="fa-solid fa-user"></i> Quản lí người dùng</a>

        <!-- ✅ Sửa thành quyển sách -->
        <a href="quanlibaidang.html"><i class="fa-solid fa-book"></i> Quản lí bài đăng</a>

        <a href="#"><i class="fa-regular fa-credit-card"></i> Thanh toán</a>
        <a href="#"><i class="fa-solid fa-comments"></i> Chatbox AI</a>
      </nav>
    </div>

    <!-- ✅ PHẦN BÊN PHẢI -->
    <div class="main-content">
      <h1>Tìm kiếm phòng trọ</h1>
      <p>Xin chào <strong>ADMIN</strong></p>
    </div>
  </div>

</body>
</html>
