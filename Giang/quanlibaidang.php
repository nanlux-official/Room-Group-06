<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lí bài đăng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="quanlibaidang.css">
</head>
<style>
  * {
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
  margin: 0;
  padding: 0;
}

body {
  background: #f7f7f7;
  color: #1a1a1a;
  display: flex;
  min-height: 100vh;
  font-size: 16px;
}

/* Container */
.container {
  display: flex;
  width: 100%;
}

/* Sidebar */
.sidebar {
  width: 240px;
  background: #fff;
  border-right: 1px solid #ddd;
  padding: 24px 16px;
}

.sidebar h2 {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 24px;
  color: #0a1121;
}

.section-title {
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  color: #6b7280;
  margin: 16px 0 8px;
}

.menu a {
  display: flex;
  align-items: center;
  padding: 12px 14px;
  margin-bottom: 8px;
  text-decoration: none;
  color: #1a1a1a;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 500;
  transition: 0.2s;
}

.menu a i {
  width: 22px;
  margin-right: 12px;
  font-size: 16px;
}

.menu a:hover,
.menu a.active {
  background: #0a1121;
  color: #fff;
}

.menu a.active i {
  color: #fff;
}

/* Main content */
.main-content {
  flex: 1;
  padding: 32px;
  background-color: #f7f7f7;
}

.main-content h1 {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 20px;
}

/* Search box */
.search-box {
  position: relative;
  width: 100%;
  max-width: 600px;
  margin-bottom: 20px;
}

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

/* Table wrapper */
.table-wrapper {
  background: white;
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
  background-color: #f9f9f9;
}

/* Room info (cột có ảnh) */
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
  background: #e5e7eb;
  color: #4b5563;
}

/* Action icons */
.action-icons i {
  margin-right: 12px;
  cursor: pointer;
  font-size: 16px;
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
        <a href="quanliphong.html"><i class="fa-solid fa-house"></i> Quản lí phòng</a>
        <a href="quanlinguoidung.html"><i class="fa-solid fa-user"></i> Quản lí người dùng</a>
        <a href="#" class="active"><i class="fa-solid fa-book"></i> Quản lí bài đăng</a>
        <a href="#"><i class="fa-regular fa-credit-card"></i> Thanh toán</a>
        <a href="#"><i class="fa-solid fa-comments"></i> Chatbox AI</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <h1>Quản lí bài đăng</h1>

      <div class="search-box">
        <input type="text" placeholder="Tìm kiếm bài đăng...">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
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
            <!-- ✅ DỮ LIỆU TỪ BACKEND SẼ ĐƯỢC ĐỔ RA ĐÂY -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
