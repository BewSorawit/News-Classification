<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>สมัครสมาชิก</h2>
        <form id="register-form">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" class="form-control" id="username" placeholder="กรอกชื่อผู้ใช้" required>
            </div>
            <div class="form-group">
                <label for="email">อีเมล</label>
                <input type="email" class="form-control" id="email" placeholder="กรอกอีเมล" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" class="form-control" id="password" placeholder="กรอกรหัสผ่าน" required>
            </div>
            <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
        </form>
        <div id="error-message" class="text-danger mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#register-form').on('submit', function(e) {
                e.preventDefault();  // ป้องกันการ reload หน้า

                const username = $('#username').val();
                const email = $('#email').val();
                const password = $('#password').val();
                const typer_user_id = 1;  // ตั้งค่า typer_user_id เป็น 4

                $.ajax({
                    url: 'http://localhost:8001/users',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ 
                        username: username, 
                        email: email, 
                        password: password,
                        typer_user_id: typer_user_id  // ส่ง typer_user_id เป็น 4
                    }),
                    success: function(data) {
                        // ถ้าสมัครสำเร็จ สามารถเปลี่ยนเส้นทางหรือแสดงข้อความยืนยัน
                        alert('สมัครสมาชิกสำเร็จ!');
                        window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON.detail || 'เกิดข้อผิดพลาดในการสมัครสมาชิก';
                        $('#error-message').text(errorMessage);
                    }
                });
            });
        });
    </script>
</body>
</html>
