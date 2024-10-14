<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>เข้าสู่ระบบ</h2>
        <form id="login-form">
            <div class="form-group">
                <label for="email">อีเมล</label>
                <input type="email" class="form-control" id="email" placeholder="กรอกอีเมล" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" class="form-control" id="password" placeholder="กรอกรหัสผ่าน" required>
            </div>
            <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>
        <div id="error-message" class="text-danger mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            const accessToken = localStorage.getItem('access_token');
            if (accessToken) {
                window.location.href = '/news';
            }

            $('#login-form').on('submit', function(e) {
                e.preventDefault();  // ป้องกันการ reload หน้า

                const email = $('#email').val();
                const password = $('#password').val();

                $.ajax({
                    url: 'http://localhost:8001/login',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ email: email, password: password }),
                    success: function(data) {
                        localStorage.setItem('access_token', data.access_token);
                        localStorage.setItem('refresh_token', data.refresh_token);

                        location.replace('/news');
                    },
                    error: function() {
                        $('#error-message').text('อีเมลหรือรหัสผ่านไม่ถูกต้อง');
                    }
                });
            });
        });
    </script>
</body>
</html>
