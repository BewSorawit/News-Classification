@extends('layouts.app')
@section('title','register')
@section('content')

<body>
    <div class="content">
        <div class="wrapper">
            <form method="POST" action="{{route('register')}}">
                @csrf
                <h1 style="text-align: center;">Register</h1>
                <div class="input-box">
                    <input name="name" id="username" type="text" placeholder="ชื่อผู้ใช้" required>
                    <i class='bx bx-user' ></i>
                </div>
                <div class="input-box">
                    <input name="email" id="email" type="text" placeholder="email" required>
                    <i class='bx bx-user' ></i>
                </div>
                <div class="input-box">
                    <input name="password" id="password" type="password" placeholder="รหัสผ่าน" required>
                    <i class='bx bx-lock-alt' ></i>
                </div>
                <div class="input-box">
                    <input name="password_confirmation" id="password_confirmation"type="password" placeholder="ยืนยันรหัสผ่าน" required>
                    <i class='bx bx-lock-alt' ></i>
                </div>

                <div class="form-group mt-3">
                    <label for="role-select">เลือก Role</label>
                    <select class="form-control" id="role-select" required>
                        <option value="">-- กรุณาเลือก Role --</option>
                    </select>
                </div>


                <a >
                    <button type="submit" class="btn">ดำเนินการต่อ</button>
                </a>
                <div class="register-link">
                    <p>If you have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
                <style>
                    .content{
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                    }
                    .wrapper{
                        width: 420px;
                        background: transparent;
                        border: 2px solid rgba(255, 255, 255, .2);
                        backdrop-filter: blur(20px);
                        box-shadow: 0 0 10px  rgba(0, 0, 0, .2);
                        color: #fff;
                        border-radius: 10px;
                        padding: 30px 40px;

                    }
                    '.wrapper h1{
                        font-size: 36px;
                    }
                    .wrapper .input-box{
                        width: 100%;
                        height: 50px;
                        background: salmon;
                        margin: 30px 0;
                    }
                    .input-box input {
                        width: 100%;
                        height: 100%;
                        margin-top: 5%;
                        background: transparent;
                        border: none;
                        outline: none;
                        border: 2px solid rgba(255, 255, 255, .2);
                        border-radius: 40px;
                        font-size: 16px;
                        color: #fff;
                        padding: 20px 45px 20px 20px;
                    }
                    .input-box input::placeholder {
                        color: #fff;
                    }
                    .input-box i {
                        position: absolute;
                        right : 15%;
                        margin-top: 12%;
                        transform: translateY(-50%);
                        font-size: 20px;
                    }
                    .wrapper .btn {
                        width: 100%;
                        height: 45px;
                        background: #31bcea;
                        border: none;
                        outline: none;
                        border-radius: 40px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
                        cursor: pointer;
                        font-size: 16px;
                        color: #fff;
                        font-weight: 600;
                        margin-top: 5%;
                    }
                    .wrapper .register-link {
                        font-size: 14.5px;
                        text-align: center;
                        margin-top: 20px;
                    }
                    .register-link p a {
                        color: #31bcea;
                        text-decoration: none;
                        font-weight: 20px;
                    }
                    .register-link p a:hover{
                        text-decoration: underline;
                    }
                </style>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // ดึงรายการ Role จาก API
            $.ajax({
                url: 'http://localhost:8001/typer_user_router/',  // URL ของ API
                method: 'GET',
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
                    data: JSON.stringify({
                        username: username,
                        email: email,
                        password: password,
                        typer_user_id: parseInt(typer_user_id)  // ส่ง typer_user_id เป็นตัวเลข
                    }),
                    success: function(data) {
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
@endsection
