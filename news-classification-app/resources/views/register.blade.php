@extends('layouts.app')
@section('title','register')

@section('content')

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        #content {
            display: none; /* ซ่อนเนื้อหาทั้งหมด */
        }
    </style>
</head>
<body>
    <div class="container mt-5" id="content">
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
            <div class="form-group">
                <label for="role-select">เลือก Role</label>
                <select class="form-control" id="role-select" required>
                    <option value="">-- กรุณาเลือก Role --</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
        </form>
        <div id="error-message" class="text-danger mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            const accessToken = localStorage.getItem('access_token'); // ดึง access token จาก localStorage

            // ตรวจสอบว่ามี access token หรือไม่
            if (!accessToken) {
                alert('กรุณาเข้าสู่ระบบก่อนที่จะสมัครสมาชิก'); // แจ้งเตือนหากไม่มี token
                window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                return;
            }

            // ตรวจสอบ role ของผู้ใช้
            $.ajax({
                url: 'http://localhost:8001/typer_user_router/role', // URL ของ API เพื่อดึง role
                method: 'GET',
                headers: { 'Authorization': `Bearer ${accessToken}` }, // แนบ access token ใน header
                success: function(roleData) {
                    if (roleData.role !== 'Admin') { // ตรวจสอบว่าถ้า role ไม่ใช่ Admin
                        alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้'); // แจ้งเตือน
                        window.location.href = '/news'; // เปลี่ยนไปหน้า news
                        return;
                    }

                    // แสดงเนื้อหาหลังจากตรวจสอบ role
                    $('#content').show();

                    // ดึงรายการ Role จาก API
                    $.ajax({
                        url: 'http://localhost:8001/typer_user_router/',  // URL ของ API
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }, // แนบ access token ใน header
                        success: function(data) {
                            const roleSelect = $('#role-select');
                            data.forEach(role => {
                                roleSelect.append(new Option(role.role, role.id));  // แสดงชื่อ role และใช้ id เป็นค่า
                            });
                        },
                        error: function() {
                            alert('ไม่สามารถดึงรายการ Role ได้');
                        }
                    });
                },
                error: function() {
                    alert('ไม่สามารถดึงข้อมูล role ได้');
                    window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบหากเกิดข้อผิดพลาด
                }
            });

            $('#register-form').on('submit', function(e) {
                e.preventDefault();  // ป้องกันการ reload หน้า

                const username = $('#username').val();
                const email = $('#email').val();
                const password = $('#password').val();
                const typer_user_id = $('#role-select').val();  // ดึงค่า role ที่เลือก

                $.ajax({
                    url: 'http://localhost:8001/users',
                    method: 'POST',
                    contentType: 'application/json',
                    headers: { 'Authorization': `Bearer ${accessToken}` }, // แนบ access token ใน header
                    data: JSON.stringify({
                        username: username,
                        email: email,
                        password: password,
                        typer_user_id: parseInt(typer_user_id)  // ส่ง typer_user_id เป็นตัวเลข
                    }),
                    success: function(data) {
                        alert('สมัครสมาชิกสำเร็จ!');
                        window.location.href = '/user'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
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

@endsection
