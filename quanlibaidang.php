<?php
// Kết nối MySQL
$host = "localhost";
$user = "root";
$pass = "";
$db   = "qltro";   // tên database của bạn

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
// Xử lý xóa
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $conn->prepare("DELETE FROM PhongTro WHERE IDPhong=?");
  $stmt->bind_param("s", $id);
  if ($stmt->execute()) {
      echo "<script>alert('Xóa thành công!'); window.location='quanlibaidang.php';</script>";
  } else {
      echo "<script>alert('Xóa thất bại!');</script>";
  }
}

// Xử lý cập nhật (modal)
if (isset($_POST['update'])) {
  $id = $_POST['IDPhong'];
  $mota = $_POST['MoTaPhongTro'];
  $gia = $_POST['GiaPhong'];
  $chutro = $_POST['ThongTinChuTro'];
  $trangthai = $_POST['TrangThai'];
  $image = $_POST['ImageUrl'];

  $stmt = $conn->prepare("UPDATE PhongTro 
                          SET MoTaPhongTro=?, GiaPhong=?, ThongTinChuTro=?, TrangThai=?, ImageUrl=? 
                          WHERE IDPhong=?");
  $stmt->bind_param("sdsiss", $mota, $gia, $chutro, $trangthai, $image, $id);

  if ($stmt->execute()) {
      echo "<script>alert('Cập nhật thành công!'); window.location='quanlibaidang.php';</script>";
  } else {
      echo "<script>alert('Lỗi cập nhật!');</script>";
  }
}

// Tìm kiếm
$search = "";
if (isset($_GET['search'])) {
  $search = trim($_GET['search']);
  $sql = "SELECT * FROM PhongTro WHERE MoTaPhongTro LIKE ? OR ThongTinChuTro LIKE ?";
  $stmt = $conn->prepare($sql);
  $like = "%$search%";
  $stmt->bind_param("ss", $like, $like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $sql = "SELECT * FROM PhongTro";
  $result = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lí bài đăng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="quanlibaidang.css">
</head>
<style>
  /* Reset và base */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background: #f7f7f7;
  color: #0a1121;
  font-size: 15px;
}

.container {
  display: flex;
  min-height: 100vh;
  width: 100%;
}

    /* Sidebar */
    .sidebar {
      width: 220px;
      background: #fff;
      height: 100vh;
      border-right: 1px solid #ddd;
      padding: 24px 16px;
    }
    .sidebar h2 { font-size: 18px; margin-bottom: 20px; }
    .sidebar .section-title {
      font-size: 14px; font-weight: bold; color: #555; margin-bottom: 14px;
    }
    .menu a {
      display: flex; align-items: center; padding: 10px; margin-bottom: 8px;
      text-decoration: none; color: #222; border-radius: 6px; font-size: 15px;
      transition: 0.2s ease;
    }
    .menu a i { width: 20px; margin-right: 10px; text-align: center; }
    .menu a.active { background: #f2f2f2; }
    .menu a:hover { background: #eaeaea; }
     /* Modal */
     .modal {
      display: none;
      position: fixed;
      top:0; left:0; width:100%; height:100%;
      background: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .modal-content {
      background:#fff;
      padding:20px;
      border-radius:10px;
      width:450px;
      max-width:95%;
      animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {from{opacity:0;transform:scale(0.9);}to{opacity:1;transform:scale(1);}}
    .modal h3 {margin-bottom:16px;}
    .modal label {display:block;margin-top:10px;font-weight:600;}
    .modal input,.modal textarea,.modal select {
      width:100%;padding:8px;margin-top:6px;
      border:1px solid #ccc;border-radius:6px;
    }
    .modal button {
      margin-top:16px;padding:10px 20px;
      background:#0a1121;color:#fff;border:none;
      border-radius:6px;cursor:pointer;
    }
    .modal-close {float:right;cursor:pointer;font-size:18px;color:#555;}
    .modal-close:hover {color:#000;}
/* Main content */
.main,
.main-content {
  flex: 1;
  padding: 32px;
  background-color: #f7f7f7;
}

.main h2,
.main-content h1 {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 20px;
}

/* Search box */
.search,
.search-box {
  position: relative;
  max-width: 600px;
  margin-bottom: 20px;
}

.search input,
.search-box input {
  width: 100%;
  padding: 15px 50px 15px 20px;
  border: 1px solid #cbd5e1;
  border-radius: 999px;
  background: #fff;
  font-size: 14px;
  color: #0a1121;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.search button,
.search-box button {
  position: absolute;
  right: 8px;
  top: 50%;
  transform: translateY(-50%);
  width: 36px;
  height: 36px;
  background: #0a1121;
  color: #fff;
  border: none;
  border-radius: 999px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

/* Table */
.table-wrapper {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 12px;
  overflow-x: auto;
}

.table-wrapper table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
  min-width: 700px;
}

.table-wrapper thead {
  background: #f3f3f3;
  color: #0a1121;
  font-weight: 600;
}

.table-wrapper th,
.table-wrapper td {
  text-align: left;
  padding: 14px 20px;
  vertical-align: middle;
}

.table-wrapper tbody tr {
  border-top: 1px solid #eee;
}

.table-wrapper tbody tr:hover {
  background-color: #fafafa;
}

/* Badge trạng thái */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  padding: 6px 12px;
  border-radius: 999px;
  font-weight: 500;
}

.badge i {
  font-size: 6px;
}

.status-active {
  background: #d1fae5;
  color: #047857;
}

.status-pending {
  background: #fef3c7;
  color: #92400e;
}

.status-expired {
  background: #fee2e2;
  color: #b91c1c;
}

/* Room info (cho bài đăng có ảnh) */
.room-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.room-info img {
  width: 48px;
  height: 48px;
  object-fit: cover;
  border-radius: 6px;
}

/* Action icons */
.action-icons i,
td .actions i {
  margin-right: 12px;
  cursor: pointer;
  font-size: 16px;
  color: #555;
  transition: 0.2s;
}

.action-icons i:hover,
td .actions i:hover {
  color: #000;
}

</style>
<body>
  <div class="container">
     <!-- Sidebar -->
     <div class="sidebar">
      <h2>Bài đăng</h2>
      <div class="section-title">Dashboard</div>
      <nav class="menu">
        <a href="quanliphong.php"><i class="fa-solid fa-house"></i> Quản lí phòng</a>
        <a href="quanlinguoidung.php"><i class="fa-solid fa-user"></i> Quản lí người dùng</a>
        <a href="quanlibaidang.php" class="active"><i class="fa-solid fa-book"></i> Quản lí bài đăng</a>
        <a href="#"><i class="fa-regular fa-credit-card"></i> Thanh toán</a>
        <a href="#"><i class="fa-solid fa-comments"></i> Chatbox AI</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <h1>Quản lí bài đăng</h1>

      <div class="search-box">
        <form method="GET">
          <input type="text" name="search" placeholder="Tìm kiếm bài đăng..." value="<?= htmlspecialchars($search) ?>">
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Tiêu đề</th>
              <th>Giá thuê</th>
              <th>Người đăng</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                  <td>
                    <div class='room-info'>
                      <img src="<?= htmlspecialchars($row['ImageUrl']) ?>" alt="Ảnh phòng">
                      <span><?= htmlspecialchars($row['MoTaPhongTro']) ?></span>
                    </div>
                  </td>
                  <td><?= number_format($row['GiaPhong'], 0, ',', '.') ?> VNĐ</td>
                  <td><?= htmlspecialchars($row['ThongTinChuTro']) ?></td>
                  <td>
                    <?php if ($row['TrangThai']==1): ?>
                      <span class="badge status-active"><i class="fa-solid fa-circle"></i> Còn trống</span>
                    <?php else: ?>
                      <span class="badge status-expired"><i class="fa-solid fa-circle"></i> Hết phòng</span>
                    <?php endif; ?>
                  </td>
                  <td class="action-icons">
                    <i class="fa-solid fa-pen" 
                       onclick="openModal('<?= $row['IDPhong'] ?>',
                                          '<?= htmlspecialchars($row['MoTaPhongTro']) ?>',
                                          '<?= $row['GiaPhong'] ?>',
                                          '<?= htmlspecialchars($row['ThongTinChuTro']) ?>',
                                          '<?= $row['TrangThai'] ?>',
                                          '<?= htmlspecialchars($row['ImageUrl']) ?>')"></i>
                    <a href="quanlibaidang.php?delete=<?= $row['IDPhong'] ?>" onclick="return confirm('Bạn có chắc muốn xóa bài đăng này?');"><i class="fa-solid fa-trash"></i></a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align:center;color:gray;">Không có dữ liệu</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <span class="modal-close" onclick="closeModal()">&times;</span>
      <h3>Sửa bài đăng</h3>
      <form method="POST">
        <input type="hidden" name="IDPhong" id="editID">
        <label>Tiêu đề / Mô tả</label>
        <textarea name="MoTaPhongTro" id="editMoTa"></textarea>
        <label>Giá thuê</label>
        <input type="number" step="0.01" name="GiaPhong" id="editGia">
        <label>Người đăng</label>
        <input type="text" name="ThongTinChuTro" id="editChuTro">
        <label>Ảnh</label>
        <input type="text" name="ImageUrl" id="editImage">
        <label>Trạng thái</label>
        <select name="TrangThai" id="editTrangThai">
          <option value="1">Còn trống</option>
          <option value="0">Hết phòng</option>
        </select>
        <button type="submit" name="update">Lưu thay đổi</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(id, mota, gia, chutro, trangthai, image) {
      document.getElementById("editID").value = id;
      document.getElementById("editMoTa").value = mota;
      document.getElementById("editGia").value = gia;
      document.getElementById("editChuTro").value = chutro;
      document.getElementById("editTrangThai").value = trangthai;
      document.getElementById("editImage").value = image;

      document.getElementById("editModal").style.display = "flex";
    }
    function closeModal() {
      document.getElementById("editModal").style.display = "none";
    }
    window.onclick = function(e) {
      if (e.target == document.getElementById("editModal")) {
        closeModal();
      }
    }
  </script>
</body>
</html>
<?php $conn->close(); ?>