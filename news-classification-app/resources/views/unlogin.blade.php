@extends('layouts.app')
@section('title','LOL')

@section('content')

<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>กรุณาเข้าสู่ระบบ</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .container {
                margin-top: 100px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>กรุณาเข้าสู่ระบบ</h2>
            <p>คุณต้องล็อกอินเพื่อเข้าถึงหน้านี้</p>
            <a href="/login" class="btn btn-primary">ไปยังหน้าเข้าสู่ระบบ</a>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const accessToken = localStorage.getItem('access_token');

                // ตรวจสอบว่า user ได้ล็อกอินอยู่แล้วหรือไม่
                if (accessToken) {
                    // หากมีการล็อกอินอยู่แล้ว เปลี่ยนเส้นทางไปยังหน้ารายการข่าว
                    window.location.replace('/news');
                }
            });
        </script>
    </body>
    </html>

@endsection

