@extends('layouts.app')
@section('title','news_framePage')

@section('content')

    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>รายการข่าว</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <style>
            /* ปรับตำแหน่งปุ่มล็อกเอาท์ */
            #logout-button {
                position: absolute; /* ทำให้ปุ่มมีตำแหน่งแบบ absolute */
                top: 20px; /* ระยะห่างจากด้านบน */
                right: 20px; /* ระยะห่างจากด้านขวา */
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <h2>รายการข่าว</h2>
            <div class="list-group" id="news-list"></div>

            <!-- ปุ่มล็อกเอาท์ -->
            {{-- <ul class="navbar-nav ms-auto zero-item " style="display: none;" id="navbar"  > --}}
                {{-- <li><button id="logout-button" class="btn btn-danger nav-item ">ล็อกเอาท์</button></li> --}}
            {{-- </ul> --}}
        </div>

        {{-- <script>
            $(document).ready(function() {
                // ดึง token จาก Local Storage
                const accessToken = localStorage.getItem('access_token');

                 // Check if token exists
                if (!accessToken) {
                    alert('Token not found. Please log in.');
                    window.location.href = '/login'; // Redirect to login if no token
                    return;
                }


                $.ajax({
                    url: 'http://localhost:8001/news/',  // URL ของ API
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${accessToken}` // แนบ token ใน header
                    },
                    success: function(data) {
                        const newsList = $('#news-list');
                        data.forEach(item => {
                            newsList.append(`
                                <div class="list-group-item">
                                    <h5 class="mb-1">
                                        <a href="/news/${item.id}" class="text-decoration-none">${item.title}</a>
                                    </h5>
                                    <p class="mb-1">
                                        <span class="badge badge-primary">${item.category_level_1}</span>
                                        <span class="badge badge-secondary">${item.category_level_2}</span>
                                    </p>
                                </div>
                            `);
                        });
                    },
                    error: function() {
                        alert('ไม่สามารถดึงข้อมูลข่าวได้  news_frames  ');
                    }
                });

                จัดการการคลิกปุ่มล็อกเอาท์
                $('#logout-button').on('click', function() {
                    // ล้าง token จาก Local Storage
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                    // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                    window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                });
            });
        </script> --}}

    </body>
    </html>

@endsection

