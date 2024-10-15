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


    <script>
        function changeUrl() {
            // Change the URL to /new-url without reloading the page
            history.pushState(null, '', '/home');
        }

        function clearQueryParameters() {
            // Clear query parameters from the current URL
            const baseUrl = window.location.pathname;
            history.replaceState(null, '', baseUrl);
        }
    </script>

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




            <ul class="navbar-nav ms-auto " id="navbar"  >

                <div  class="admin-item mt-2">
                    <li class="admin-item nav-item"  >
                        <a class=" admin-item nav-link " href="{{route('register')}}">
                            {{-- <button type="button" class="btn btn-primary btn-sm"> --}}
                                สมัครสมาชิก
                            {{-- </button> --}}
                        </a>
                    </li>
                </div>
                {{-- <div  class="admin-item mt-2">
                    <li class="admin-item nav-item"  >
                        <a class=" admin-item nav-link " href="๒">
                                HOHO
                        </a>
                    </li>
                </div> --}}






                <div class="zero-item mt-2" >
                    <li class="zero-item nav-item  flex  " >
                        <a class="nav-link  zero-item " href="{{route('login')}}">เข้าสู่ระบบ</a>
                    </li>
                </div>



                <div class="logout-item mt-2" >
                    <li class="logout-item nav-item" id="logout-button" >
                        {{-- <button id="logout-button" class="logout-item " > --}}
                            {{-- <a id="logout-button" class="nav-link logout-item" href="{{route('register')}}"> --}}
                                <a onclick="changeUrl()" class="nav-link  logout-item " href="" >ออกจากระบบ</a>
                            {{-- </a> --}}
                        {{-- </button> --}}
                    </li>
                </div>


            </ul>




        </div>
    </nav>



    <script>
        $(document).ready(function() {
            const accessToken = localStorage.getItem('access_token'); // Replace with actual token

            $.ajax({
                url: 'http://localhost:8001/typer_user_router/role',
                method: 'GET',
                headers: { 'Authorization': `Bearer ${accessToken}` },
                success: function(response) {
                    console.log('Role ของผู้ใช้:', response.role); // แสดงค่า role ใน console

                    // แสดงเมนูที่เหมาะสมตาม role ของผู้ใช้
                    if (response.role == 'Viewer') {
                        $('.viewer-item').show();
                        $('.logout-item').show();

                        $('.admin-item').hide();
                        $('.writer-item').hide();
                        $('.editor-item').hide();
                        $('.zero-item').hide();
                        // alert('YOU are login as admin viewer');
                    }
                    else if (response.role == 'Writer') {
                        $('.writer-item').show();
                        $('.logout-item').show();

                        $('.admin-item').hide();
                        $('.editor-item').hide();
                        $('.viewer-item').hide();
                        $('.zero-item').hide();
                        // alert('YOU are login as admin writer');
                    }
                    else if (response.role == 'Admin') {
                        $('.admin-item').show();
                        $('.logout-item').show();

                        $('.writer-item').hide();
                        $('.editor-item').hide();
                        $('.viewer-item').hide();
                        $('.zero-item').hide();
                        // alert('YOU are login as admin');
                    }
                    else if (response.role == 'Editor') {
                        $('.editor-item').show();
                        $('.logout-item').show();

                        $('.admin-item').hide();
                        $('.writer-item').hide();
                        $('.viewer-item').hide();
                        $('.zero-item').hide();
                        // alert('YOU are login as admin editor');
                    }
                },
                error: function() {
                    $('.zero-item').show(); // for login

                    $('.viewer-item').hide();
                    $('.writer-item').hide();
                    $('.admin-item').hide();
                    $('.logout-item').hide();


                    // alert('Unable to check user role');
                    // alert('ไม่สามารถตรวจสอบ role ของผู้ใช้ได้');
                }
            });



                // จัดการการคลิกปุ่มล็อกเอาท์
            $('#logout-button').on('click', function() {
                // ล้าง token จาก Local Storage
                localStorage.removeItem('access_token');
                localStorage.removeItem('refresh_token'); // ล้าง refresh_token ถ้ามี

                // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                // window.location.href = '/home'; // เปลี่ยนไปหน้าเข้าสู่ระบบ

                location.replace('/home');
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

