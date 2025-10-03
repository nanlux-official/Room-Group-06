<?php
// Kết nối MySQL
$host = "localhost";
$user = "root";
$pass = "";
$db   = "qltro";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu phòng trọ
$sql = "SELECT * FROM PhongTro";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Trung tâm Khách hàng</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --bg: #f7f7f7; --line: #e5e7eb; --text: #0a1121; --muted: #6b7280;
      --primary: #0a1121; --danger: #ef4444; --radius: 12px;
    }
    *{box-sizing:border-box; font-family:'Segoe UI',sans-serif; margin:0; padding:0;}
    body{background:var(--bg); color:var(--text); font-size:15px; min-height:100vh; display:flex;}
    .sidebar{width:240px; background:#fff; border-right:1px solid var(--line); padding:24px 16px; flex-shrink:0;}
    .sb-title{font-size:18px; font-weight:700; margin-bottom:20px;}
    .menu{display:flex; flex-direction:column; gap:8px;}
    #menu-item{display:flex; align-items:center; padding:12px 14px; text-decoration:none; color:var(--text); font-size:15px; border-radius:8px; transition:.2s;}
    #menu-item i{width:20px; margin-right:10px; font-size:15px; text-align:center;}
    #menu-item:hover{background:#f3f3f3;}
    .main{flex:1; padding:32px; background:var(--bg);}
    .page-head{display:grid; grid-template-columns:1fr 2fr auto; align-items:center; gap:16px; margin-bottom:20px;}
    .page-head h2{font-size:22px; font-weight:bold; margin-bottom:4px;}
    .page-head p{font-size:14px; color:var(--muted);}
    .search-wrap input{width:100%; padding:14px 16px; border:1px solid var(--line); border-radius:999px; background:#fff; font-size:14px; outline:none;}
    .search-wrap input:focus{border-color:var(--primary); box-shadow:0 0 0 2px rgba(10,17,33,0.1);}
    .btn{padding:10px 16px; border:1px solid var(--line); border-radius:8px; background:#fff; font-size:14px; cursor:pointer; transition:.2s;}
    .btn:hover{background:#f3f3f3;}
    .btn.primary{background:var(--primary); color:#fff; border-color:var(--primary);}
    .btn.logout{background:var(--danger); color:#fff; border-color:var(--danger);}
    .role-badge{display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:#fff; border:1px dashed var(--line); border-radius:999px; font-size:13px; color:var(--muted);}
    .card-grid{display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:20px; margin-top:20px;}
    .room-card{background:#fff; border:1px solid var(--line); border-radius:var(--radius); overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.06); transition:transform .2s, box-shadow .2s;}
    .room-card:hover{transform:translateY(-4px); box-shadow:0 4px 12px rgba(0,0,0,0.08);}
    .room-card img{width:100%; height:160px; object-fit:cover;}
    .card-body{padding:14px 16px;}
    .card-body h3{font-size:16px; font-weight:600; margin-bottom:6px;}
    .card-body .desc{font-size:14px; color:var(--muted); margin-bottom:8px;}
    .card-body .price{font-weight:600; color:var(--primary); margin-bottom:10px;}
    .status-badge{display:inline-flex; align-items:center; gap:6px; font-size:13px; padding:6px 12px; border-radius:999px; font-weight:500;}
    .status-active{background:#d1fae5; color:#047857;}
    .status-expired{background:#fee2e2; color:#b91c1c;}
    @media(max-width:1024px){.page-head{grid-template-columns:1fr 1.5fr auto;}}
    @media(max-width:820px){.sidebar{width:200px;} .page-head{grid-template-columns:1fr; gap:12px;} .search-wrap{order:2;}}
    .menu a i { width: 20px; margin-right: 10px; text-align: center; }
    .menu a.active { background: #f2f2f2; }
    .menu a:hover { background: #eaeaea; }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sb-title">Dashboard</div>
    <nav class="menu">
      <a href="#" class="active" id="menu-item"><i class="fa-solid fa-house"></i>Trang chủ</a>
      <a href="lienlacchutro.php" id="menu-item"><i class="fa-solid fa-id-badge"></i> Liên lạc chủ trọ</a>
      <a href="timkiemphong.php" id="menu-item"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm phòng</a>
      <a href="locketqua.php" id="menu-item"><i class="fa-solid fa-filter"></i> Lọc kết quả</a>
      <a href="chitietphong.php" id="menu-item"><i class="fa-regular fa-rectangle-list"></i> Chi tiết phòng</a>
      <a href="danhgiabinhluan.php" id="menu-item"><i class="fa-regular fa-star"></i> Đánh giá & bình luận</a>
      <a href="yeuthich.php" id="menu-item"><i class="fa-regular fa-heart"></i> Yêu thích</a>
      <a href="datlich.php" id="menu-item"><i class="fa-regular fa-calendar-check"></i> Đặt lịch hẹn</a>
    </nav>
  </aside>

  <!-- Main -->
  <main class="main">
    <div class="page-head">
      <!-- Left -->
      <div>
        <h2>Trang chủ</h2>
        <p>Xin chào <b>KHÁCH HÀNG !</b></p>
      </div>

      <!-- Middle -->
      <div class="search-wrap">
        <input type="text" placeholder="Nhập địa chỉ, giá, diện tích...">
      </div>

      <!-- Right -->
      <div class="right" style="display:flex; gap:10px; align-items:center;">
        <button class="btn primary"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
        <span class="role-badge"><i class="fa-solid fa-id-badge"></i> Vai trò: Khách hàng</span>
        <button class="btn logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất</button>
      </div>
    </div>

    <!-- Kết quả phòng trọ dạng ô -->
    <div class="card-grid">
      <?php
        if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<div class='room-card'>";
              // Ảnh
              $img = !empty($row['ImageUrl']) ? $row['ImageUrl'] : "https://via.placeholder.com/400x200?text=No+Image";
              echo "<img src='".htmlspecialchars($img)."' alt='Ảnh phòng'>";
              echo "<div class='card-body'>";
                echo "<h3>".htmlspecialchars($row['DiaChi'])."</h3>";
                echo "<p class='desc'>".htmlspecialchars($row['MoTaPhongTro'])."</p>";
                echo "<p class='price'>".number_format($row['GiaPhong'], 0, ',', '.')." VNĐ</p>";
                if ($row['TrangThai'] == 1) {
                  echo "<span class='status-badge status-active'><i class='fa-solid fa-circle'></i> Còn trống</span>";
                } else {
                  echo "<span class='status-badge status-expired'><i class='fa-solid fa-circle'></i> Đã thuê</span>";
                }
              echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<p style='color:gray;'>Không có dữ liệu phòng trọ</p>";
        }
        $conn->close();
      ?>
    </div>
  </main>
</body>
</html>
