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

// Xử lý xóa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM NguoiDung WHERE IDNguoiDung=?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Xóa thành công!'); window.location='quanlinguoidung.php';</script>";
    } else {
        echo "<script>alert('Xóa thất bại!');</script>";
    }
}

// Xử lý cập nhật (từ modal)
if (isset($_POST['update'])) {
    $id = $_POST['IDNguoiDung'];
    $hoten = $_POST['HoTen'];
    $sdt = $_POST['SDT'];
    $email = $_POST['Email'];
    $loaiid = $_POST['LoaiID'];

    $stmt = $conn->prepare("UPDATE NguoiDung SET HoTen=?, SDT=?, Email=?, LoaiID=? WHERE IDNguoiDung=?");
    $stmt->bind_param("sssis", $hoten, $sdt, $email, $loaiid, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location='quanlinguoidung.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật!');</script>";
    }
}

// Xử lý tìm kiếm
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $sql = "SELECT * FROM NguoiDung 
            WHERE HoTen LIKE ? OR Email LIKE ? OR SDT LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM NguoiDung";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lí người dùng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
    body {background:#f8f8f8;}
    .container {display:flex;}
    /* Sidebar */
    .sidebar {width:220px;background:#fff;height:100vh;border-right:1px solid #ddd;padding:24px 16px;}
    .sidebar h2 {font-size:18px;margin-bottom:20px;}
    .sidebar .section-title {font-size:14px;font-weight:bold;color:#555;margin-bottom:14px;}
    .menu a {display:flex;align-items:center;padding:10px;margin-bottom:8px;text-decoration:none;color:#222;border-radius:6px;font-size:15px;transition:0.2s;}
    .menu a i {width:20px;margin-right:10px;text-align:center;}
    .menu a.active {background:#f2f2f2;}
    .menu a:hover {background:#eaeaea;}
    /* Main content */
    .main-content {flex:1;padding:32px;background:#f8f8f8;}
    .main-content h1 {font-size:22px;font-weight:bold;margin-bottom:20px;}
    /* Search box */
    .search-box {position:relative;max-width:600px;margin-bottom:20px;}
    .search-box input {width:100%;padding:15px 50px 15px 20px;border:1px solid #cbd5e1;border-radius:999px;background:#fff;font-size:14px;color:#0a1121;outline:none;}
    .search-box button {position:absolute;right:6px;top:50%;transform:translateY(-50%);background:#000;color:white;border:none;border-radius:50%;width:32px;height:32px;cursor:pointer;}
    /* Table */
    .table-wrapper {background:#fff;border:1px solid #ddd;border-radius:10px;overflow-x:auto;}
    table {width:100%;border-collapse:collapse;font-size:13px;}
    th,td {text-align:left;padding:12px 16px;}
    thead {background:#f3f3f3;color:#0a1121;font-weight:600;}
    tbody tr {border-top:1px solid #eee;}
    td .actions i {margin-right:10px;cursor:pointer;color:#555;}
    td .actions i:hover {color:#000;}
    td .badge {padding:4px 10px;background:#d1fae5;color:#047857;font-size:12px;border-radius:6px;display:inline-block;font-weight:500;}
    /* Modal */
    .modal {display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);justify-content:center;align-items:center;z-index:1000;}
    .modal-content {background:#fff;padding:20px;border-radius:10px;width:400px;max-width:95%;animation:fadeIn 0.3s ease;}
    @keyframes fadeIn {from{opacity:0;transform:scale(0.9);}to{opacity:1;transform:scale(1);}}
    .modal h3 {margin-bottom:16px;}
    .modal label {display:block;font-weight:600;margin-top:10px;}
    .modal input, .modal select {width:100%;padding:8px;margin-top:6px;border:1px solid #ccc;border-radius:6px;}
    .modal button {margin-top:16px;padding:10px 20px;background:#0a1121;color:#fff;border:none;border-radius:6px;cursor:pointer;}
    .modal-close {float:right;cursor:pointer;font-size:18px;color:#555;}
    .modal-close:hover {color:#000;}
  </style>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Người dùng</h2>
      <div class="section-title">Dashboard</div>
      <nav class="menu">
        <a href="quanliphong.php"><i class="fa-solid fa-house"></i> Quản lí phòng</a>
        <a href="#" class="active"><i class="fa-solid fa-user"></i> Quản lí người dùng</a>
        <a href="quanlibaidang.php"><i class="fa-solid fa-book"></i> Quản lí bài đăng</a>
        <a href="#"><i class="fa-regular fa-credit-card"></i> Thanh toán</a>
        <a href="#"><i class="fa-solid fa-comments"></i> Chatbox AI</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <h1>Quản lí người dùng</h1>

      <div class="search-box">
        <form method="GET">
          <input type="text" name="search" placeholder="Tìm kiếm người dùng..." value="<?= htmlspecialchars($search) ?>">
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Họ và Tên</th>
              <th>Số điện thoại</th>
              <th>Email</th>
              <th>Loại tài khoản</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['HoTen']) ?></td>
                  <td><?= htmlspecialchars($row['SDT']) ?></td>
                  <td><?= htmlspecialchars($row['Email']) ?></td>
                  <td>
                    <span class="badge">
                      <?= ($row['LoaiID'] == 1 ? "Quản trị" : ($row['LoaiID'] == 2 ? "Người dùng" : "Chủ trọ")) ?>
                    </span>
                  </td>
                  <td class="actions">
                    <i class="fa-solid fa-pen" onclick="openModal('<?= $row['IDNguoiDung'] ?>','<?= htmlspecialchars($row['HoTen']) ?>','<?= htmlspecialchars($row['SDT']) ?>','<?= htmlspecialchars($row['Email']) ?>','<?= $row['LoaiID'] ?>')"></i>
                    <a href="quanlinguoidung.php?delete=<?= $row['IDNguoiDung'] ?>" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');"><i class="fa-solid fa-trash"></i></a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align:center; color:gray;">Không có dữ liệu</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal sửa -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <span class="modal-close" onclick="closeModal()">&times;</span>
      <h3>Sửa người dùng</h3>
      <form method="POST">
        <input type="hidden" name="IDNguoiDung" id="editID">
        <label>Họ tên</label>
        <input type="text" name="HoTen" id="editHoTen">
        <label>SĐT</label>
        <input type="text" name="SDT" id="editSDT">
        <label>Email</label>
        <input type="email" name="Email" id="editEmail">
        <label>Loại tài khoản</label>
        <select name="LoaiID" id="editLoaiID">
          <option value="1">Quản trị</option>
          <option value="2">Người dùng</option>
          <option value="3">Chủ trọ</option>
        </select>
        <button type="submit" name="update">Lưu thay đổi</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(id, hoten, sdt, email, loaiid) {
      document.getElementById("editID").value = id;
      document.getElementById("editHoTen").value = hoten;
      document.getElementById("editSDT").value = sdt;
      document.getElementById("editEmail").value = email;
      document.getElementById("editLoaiID").value = loaiid;

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
