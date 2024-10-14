<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
      body {
          background-image: url('../images/screenBackground.png'); /* ลิงก์ไปยังรูปภาพ */
          background-size: cover; /* ทำให้รูปภาพครอบคลุมทั้งหน้าจอ */
          background-position: center; /* จัดกึ่งกลางรูปภาพ */
          background-repeat: no-repeat; /* ไม่ให้รูปภาพซ้ำ */
          background-attachment: fixed;
      }

  </style>

    <title>@yield('title') | HOME  </title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="/js/jquery-3.6.0.min.js"></script> <!-- Local jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<body>


    <nav class="navbar navbar-expand-lg" style="background-color: #efefef;">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('home') }}">NEWS - Classification</a>

            {{-- <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('findUser', ['workType' => 'work']) }}">ค้นหาผู้หางาน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('findUser', ['workType' => 'intern']) }}">ค้นหานักศึกษาฝึกงาน</a>
                </li>

            </ul> --}}




            <ul class="navbar-nav ms-auto zero-item " style="display: none;" id="navbar"  >
                <li class="nav-item zero-item " style="display: none;" >
                    <a class="nav-link" href="{{route('login')}}">เข้าสู่ระบบ</a>
                </li>

                <li>
                    <button id="logout-button" class="btn btn-danger" >
                        ออกจากระบบ
                    </button>
                </li>

                {{-- <li class="nav-item zero-item " style="display: none;" >
                    <a class="nav-link" href="{{route('register')}}">
                        <button type="button" class="btn btn-primary btn-sm">สมัครสมาชิก</button>
                    </a>
                </li> --}}
            </ul>
        <script>
            $(document).ready(function() {
                const accessToken = 'your_access_token_here'; // Replace with actual token

                // Check if token exists
                if (!accessToken) {
                    alert('Token not found. Please log in.');
                    window.location.href = '/login'; // Redirect to login if no token
                    return;
                }
                // จัดการการคลิกปุ่มล็อกเอาท์
                $('#logout-button').on('click', function() {
                    // ล้าง token จาก Local Storage
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                    // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                    window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                });


            });
        </script>





            <ul class="navbar-nav ms-auto admin-item " style="display: none;" >
                <li class="dropdown admin-item"  style="display: none;" >

                    <ul class="dropdown-menu admin-item " style="display: none;" >
                        <li>
                            <a class="dropdown-item" href="{{route('register')}}">
                                <button type="button" class="btn btn-primary btn-sm">สมัครสมาชิกเพิ่ม</button>
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">โปรไฟล์</a></li>
                        <li><a class="dropdown-item" href="#">ตั้งค่าโปรไฟล์</a></li>

                        <li>
                            <button id="logout-button" class="btn btn-danger" >
                                ออกจากระบบ
                            </button>
                        </li>

                        <style>
                            .dropdown-menu{
                                margin-left: -150%;
                            }
                        </style>
                    </ul>
                </li>
            </ul>
            <script>
                $(document).ready(function() {
                    const accessToken = 'your_access_token_here'; // Replace with actual token

                    // Check if token exists
                    if (!accessToken) {
                        alert('Token not found. Please log in.');
                        window.location.href = '/login'; // Redirect to login if no token
                        return;
                    }
                    // จัดการการคลิกปุ่มล็อกเอาท์
                    $('#logout-button').on('click', function() {
                        // ล้าง token จาก Local Storage
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                        // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                        window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                    });


                });
            </script>



            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown editor-item "  style="display: none;" >
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">ข้อมูลบริษัท</a></li>
                        <li><a class="dropdown-item" href="#">ตั้งค่าข้อมูลบริษัท</a></li>
                        <li><a class="dropdown-item" href="#">รายการติดตาม</a></li>

                        <li>
                            <button id="logout-button" class="btn btn-danger" >
                                ออกจากระบบ
                            </button>
                        </li>

                        <style>
                            .dropdown-menu{
                                margin-left: -150%;
                            }
                        </style>
                    </ul>
                </li>
            </ul>
            <script>
                $(document).ready(function() {
                    const accessToken = 'your_access_token_here'; // Replace with actual token

                    // Check if token exists
                    if (!accessToken) {
                        alert('Token not found. Please log in.');
                        window.location.href = '/login'; // Redirect to login if no token
                        return;
                    }
                    // จัดการการคลิกปุ่มล็อกเอาท์
                    $('#logout-button').on('click', function() {
                        // ล้าง token จาก Local Storage
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                        // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                        window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                    });


                });
            </script>







            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown writer-item " style="display: none;" >
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">ข้อมูลบริษัท</a></li>
                        <li><a class="dropdown-item" href="#">ตั้งค่าข้อมูลบริษัท</a></li>
                        <li><a class="dropdown-item" href="#">รายการติดตาม</a></li>

                        <li>
                            <button id="logout-button" class="btn btn-danger" >
                                ออกจากระบบ
                            </button>
                        </li>

                        <style>
                            .dropdown-menu{
                                margin-left: -150%;
                            }
                        </style>
                    </ul>
                </li>
            </ul>
            <script>
                $(document).ready(function() {
                    const accessToken = 'your_access_token_here'; // Replace with actual token

                    // Check if token exists
                    if (!accessToken) {
                        alert('Token not found. Please log in.');
                        window.location.href = '/login'; // Redirect to login if no token
                        return;
                    }
                    // จัดการการคลิกปุ่มล็อกเอาท์
                    $('#logout-button').on('click', function() {
                        // ล้าง token จาก Local Storage
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                        // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                        window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                    });


                });
            </script>







            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown viewer-item " style="display: none;">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">ข้อมูลบริษัท</a></li>
                        <li><a class="dropdown-item" href="#">ตั้งค่าข้อมูลบริษัท</a></li>
                        <li><a class="dropdown-item" href="#">รายการติดตาม</a></li>

                        <li>
                            <button id="logout-button" class="btn btn-danger" >
                                ออกจากระบบ
                            </button>
                        </li>

                        <style>
                            .dropdown-menu{
                                margin-left: -150%;
                            }
                        </style>
                    </ul>
                </li>
            </ul>
            <script>
                $(document).ready(function() {
                    const accessToken = 'your_access_token_here'; // Replace with actual token

                    // Check if token exists
                    if (!accessToken) {
                        alert('Token not found. Please log in.');
                        window.location.href = '/login'; // Redirect to login if no token
                        return;
                    }
                    // จัดการการคลิกปุ่มล็อกเอาท์
                    $('#logout-button').on('click', function() {
                        // ล้าง token จาก Local Storage
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                        // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                        window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
                    });


                });
            </script>



        </div>
    </nav>



    <script>
        $(document).ready(function() {
            const accessToken = 'your_access_token_here'; // Replace with actual token

            // Check if token exists
            if (!accessToken) {
                alert('Token not found. Please log in.');
                window.location.href = '/login'; // Redirect to login if no token
                return;
            }

            $.ajax({
                url: 'http://localhost:8001/typer_user_router/role',
                method: 'GET',
                headers: { 'Authorization': `Bearer ${accessToken}` },
                success: function(response) {
                    console.log('Role ของผู้ใช้:', response.role); // แสดงค่า role ใน console

                    // แสดงเมนูที่เหมาะสมตาม role ของผู้ใช้
                    if (response.role === 'viewer') {
                        $('.viewer-item').show();
                        alert('Unable to check user viewer');
                    }
                    else if (response.role === 'writer') {
                        $('.writer-item').show();
                        alert('Unable to check user writer');
                    }
                    else if (response.role === 'admin') {
                        $('.admin-item').show();
                        alert('Unable to check user admin');
                    }
                    else if (response.role === 'editor') {
                        $('.editor-item').show();
                        alert('Unable to check user editor');
                    }
                },
                error: function() {
                    $('.zero-item').show();
                    alert('Unable to check user role');
                    // alert('ไม่สามารถตรวจสอบ role ของผู้ใช้ได้');
                }
            });



                // จัดการการคลิกปุ่มล็อกเอาท์
            $('#logout-button').on('click', function() {
                // ล้าง token จาก Local Storage
                localStorage.removeItem('access_token');
                localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                window.location.href = '/login'; // เปลี่ยนไปหน้าเข้าสู่ระบบ
            });


        });
    </script>


    <div class="container py-2">
        @yield('content')
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>

