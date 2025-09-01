<?php

// ====================== XỬ LÝ AJAX LOGIN ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass'])) {
    header('Content-Type: application/json');

    // Mật khẩu đúng (bạn thay giá trị này tùy ý)

    $pass = $_POST['pass'] ?? '';

    if ($pass === $passadmin) {
        // Lưu cookie 7 ngày
        setcookie('webadmin', $pass, time() + 60*60*24*7, "/");
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Sai mật khẩu!']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Webadmin Login Story</title>
	<link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
	<div class="title">Webadmin Login Story</div>
	<div class="menu">
		<form id="loginForm" onsubmit="return false;">

			<div class="group-input">
				<label for="pass">Mật khẩu weadmin: </label>
				<input type="password" id="pass" autocomplete="off">
			</div>
			<div class="btn" id="loginBtn">Đăng nhập</div>
			<div id="message" style="color:red;margin-top:10px;"></div>
		</form>
		<div class="box">Quên mật khẩu webadmin: truy cập file _db_config.php</div>
	</div>

	<script>
	document.getElementById('loginBtn').addEventListener('click', function() {
		const pass = document.getElementById('pass').value.trim();
		if (!pass) {
			document.getElementById('message').textContent = "Vui lòng nhập mật khẩu.";
			return;
		}

		// Gửi AJAX ngay trong file này
		fetch(location.href, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'pass=' + encodeURIComponent(pass)
		})
		.then(res => res.json())
		.then(data => {
			if (data.success) {
				window.location.href = "/admin/index.php?action=dangnhap&query=dangnhap"; // Trang admin sau khi login
			} else {
				document.getElementById('message').textContent = data.message || "Sai mật khẩu.";
			}
		})
		.catch(err => {
			document.getElementById('message').textContent = "Lỗi kết nối server.";
			console.error(err);
		});
	});
	</script>
</body>
</html>
