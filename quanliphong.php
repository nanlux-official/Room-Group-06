<?php
// Kết nối MySQL
$host = "localhost";
$user = "root";      // user MySQL
$pass = "";          // password MySQL
$db   = "qltro";    // tên database

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
      echo "<script>alert('Xóa thành công!'); window.location='quanliphong.php';</script>";
  } else {
      echo "<script>alert('Xóa thất bại!');</script>";
  }
}

// Xử lý cập nhật (từ modal)
if (isset($_POST['update'])) {
  $id = $_POST['IDPhong'];
  $diachi = $_POST['DiaChi'];
  $gia = $_POST['GiaPhong'];
  $mota = $_POST['MoTaPhongTro'];
  $chutro = $_POST['ThongTinChuTro'];
  $trangthai = $_POST['TrangThai'];

  $stmt = $conn->prepare("UPDATE PhongTro 
                          SET DiaChi=?, GiaPhong=?, MoTaPhongTro=?, ThongTinChuTro=?, TrangThai=? 
                          WHERE IDPhong=?");
  $stmt->bind_param("sdssis", $diachi, $gia, $mota, $chutro, $trangthai, $id);

  if ($stmt->execute()) {
      echo "<script>alert('Cập nhật thành công!'); window.location='quanliphong.php';</script>";
  } else {
      echo "<script>alert('Lỗi cập nhật!');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lí phòng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="quanliphong.css" />
</head>
<style>
  * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background: #f8f8f8;
  color: #0a1121;
}

.container {
  display: flex;
  min-height: 100vh;
}
 /* Modal */
 .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      max-width: 95%;
      animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }
    .modal h3 { margin-bottom: 16px; }
    .modal label { display: block; font-weight: 600; margin-top: 10px; }
    .modal input, .modal textarea, .modal select {
      width: 100%; padding: 8px; margin-top: 6px;
      border: 1px solid #ccc; border-radius: 6px;
    }
    .modal button {
      margin-top: 16px; padding: 10px 20px;
      background: #0a1121; color: #fff; border: none;
      border-radius: 6px; cursor: pointer;
    }
    .modal-close {
      float: right; cursor: pointer; font-size: 18px; color: #555;
    }
    .modal-close:hover { color: #000; }

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

/* Main */
.main {
  flex: 1;
  padding: 32px;
}

.main h2 {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 20px;
}

/* Search */
.search {
  position: relative;
  max-width: 600px;
  margin-bottom: 20px;
}

.search input {
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

.search button {
  position: absolute;
  right: 6px;
  top: 50%;
  transform: translateY(-50%);
  background: #000;
  color: white;
  border: none;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  cursor: pointer;
}

/* Table */
.table-wrapper {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

th, td {
  text-align: left;
  padding: 12px 16px;
}

thead {
  background: #f3f3f3;
  color: #0a1121;
  font-weight: 600;
}

tbody tr {
  border-top: 1px solid #eee;
}

tbody tr:hover {
  background: #fafafa;
}

/* Badge trạng thái */
.badge {
  padding: 4px 10px;
  font-size: 12px;
  border-radius: 6px;
  display: inline-block;
  font-weight: 500;
}

.status-active {
  background: #d1fae5;
  color: #047857;
}

.status-expired {
  background: #fee2e2;
  color: #b91c1c;
}

/* Icons */
.action-icons i {
  margin-right: 10px;
  cursor: pointer;
  color: #555;
  transition: 0.2s;
}

.action-icons i:hover {
  color: #000;
}

</style>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Phòng trọ</h2>
      <div class="section-title">Dashboard</div>
      <nav class="menu">
        <a href="#" class="active"><i class="fa-solid fa-house"></i> Quản lí phòng</a>
        <a href="quanlinguoidung.php"><i class="fa-solid fa-user"></i> Quản lí người dùng</a>
        <a href="quanlibaidang.php"><i class="fa-solid fa-book"></i> Quản lí bài đăng</a>
        <a href="#"><i class="fa-regular fa-credit-card"></i> Thanh toán</a>
        <a href="#"><i class="fa-solid fa-comments"></i> Chatbox AI</a>
      </nav>
    </div>

    <!-- Main -->
    <main class="main">
      <h2>Quản lí phòng</h2>

      <div class="search">
        <input type="text" placeholder="Tìm kiếm phòng...">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
      </div>

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Địa chỉ</th>
              <th>Giá thuê</th>
              <th>Mô tả</th>
              <th>Chủ trọ</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM PhongTro";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>".$row['DiaChi']."</td>";
                  echo "<td>".number_format($row['GiaPhong'], 0, ',', '.')." VNĐ</td>";
                  echo "<td>".$row['MoTaPhongTro']."</td>";
                  echo "<td>".$row['ThongTinChuTro']."</td>";

                  // Trạng thái
                  if ($row['TrangThai'] == 1) {
                    echo "<td><span class='badge status-active'>Còn trống</span></td>";
                  } else {
                    echo "<td><span class='badge status-expired'>Đã thuê</span></td>";
                  }

                  // Thao tác
                  echo "<td class='action-icons'>
                          <i class='fa-solid fa-pen' 
                             onclick=\"openModal('".$row['IDPhong']."',
                                                 '".$row['DiaChi']."',
                                                 '".$row['GiaPhong']."',
                                                 '".$row['MoTaPhongTro']."',
                                                 '".$row['ThongTinChuTro']."',
                                                 '".$row['TrangThai']."')\"></i>
                          <a href='quanliphong.php?delete=".$row['IDPhong']."' onclick=\"return confirm('Bạn có chắc muốn xóa?');\"><i class='fa-solid fa-trash'></i></a>
                        </td>";

                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
              }
              $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <span class="modal-close" onclick="closeModal()">&times;</span>
      <h3>Sửa phòng</h3>
      <form method="POST">
        <input type="hidden" name="IDPhong" id="editIDPhong">

        <label>Địa chỉ</label>
        <input type="text" name="DiaChi" id="editDiaChi">

        <label>Giá thuê</label>
        <input type="number" step="0.01" name="GiaPhong" id="editGiaPhong">

        <label>Mô tả</label>
        <textarea name="MoTaPhongTro" id="editMoTa"></textarea>

        <label>Chủ trọ</label>
        <input type="text" name="ThongTinChuTro" id="editChuTro">

        <label>Trạng thái</label>
        <select name="TrangThai" id="editTrangThai">
          <option value="1">Còn trống</option>
          <option value="0">Đã thuê</option>
        </select>

        <button type="submit" name="update">Lưu thay đổi</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(id, diachi, gia, mota, chutro, trangthai) {
      document.getElementById("editIDPhong").value = id;
      document.getElementById("editDiaChi").value = diachi;
      document.getElementById("editGiaPhong").value = gia;
      document.getElementById("editMoTa").value = mota;
      document.getElementById("editChuTro").value = chutro;
      document.getElementById("editTrangThai").value = trangthai;

      document.getElementById("editModal").style.display = "flex";
    }

    function closeModal() {
      document.getElementById("editModal").style.display = "none";
    }

    // Đóng modal khi click ra ngoài
    window.onclick = function(e) {
      if (e.target == document.getElementById("editModal")) {
        closeModal();
      }
    }
  </script>
</body>
</html>