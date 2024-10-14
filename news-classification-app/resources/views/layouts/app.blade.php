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


            {{-- ถ้าไม่มีการ login จะเข้าหน้านี้  --}}
            @if (!Auth::check())
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">เข้าสู่ระบบ</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">
                            <button type="button" class="btn btn-primary btn-sm">สมัครสมาชิก</button>
                        </a>
                    </li> --}}
                </ul>
            @else
                {{-- {{ $data= Auth()->user()->userType }} return userType  --}}
                          {{-- Auth()->company()->compID --}}
                @if (  ( Auth()->user()->userType ) == ("admin")  )
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{url((Auth::user()->namePicture != '')?('storage/public/'.Auth::user()->namePicture):'images/dummyprofile.png')}}" class="pic">
                                <style>
                                    .pic{
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 50%;
                                        object-fit: cover;
                                    }
                                </style>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{route('register')}}">
                                        <button type="button" class="btn btn-primary btn-sm">สมัครสมาชิกเพิ่ม</button>
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="{{route('user.show')}}">โปรไฟล์</a></li>
                                <li><a class="dropdown-item" href="{{route('user.edit')}}">ตั้งค่าโปรไฟล์</a></li>
                                {{-- <li><a class="dropdown-item" href="#">คำเชิญจากบริษัท</a></li> --}}

                                <li>
                                    <button id="logout-button" class="btn btn-danger" >
                                        ออกจากระบบ
                                    </button>
                                </li>

                                {{-- <li>
                                <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item" :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                {{ __('ออกจากระบบ') }}
                                        </button>
                                </form>
                                </li> --}}

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
                            // ดึง token จาก Local Storage
                            const accessToken = localStorage.getItem('access_token');

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
                                    alert('ไม่สามารถดึงข้อมูลข่าวได้');
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


                @elif (  ( Auth()->user()->userType ) == ("editor")  )
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{url((Auth::user()->namePicture != '')?('storage/public/'.Auth::user()->namePicture):'images/dummyprofile.png')}}" class="pic">
                                <style>
                                    .pic{
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 50%;
                                        object-fit: cover;
                                    }
                                </style>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/company/".${Auth()}>ข้อมูลบริษัท</a></li>
                                <li><a class="dropdown-item" href="{{route('company.edit')}}">ตั้งค่าข้อมูลบริษัท</a></li>
                                <li><a class="dropdown-item" href="{{route('companyfollowing.index')}}">รายการติดตาม</a></li>

                                <li>
                                <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item" :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                {{ __('ออกจากระบบ') }}
                                        </button>
                                </form>
                                </li>

                                <style>
                                    .dropdown-menu{
                                        margin-left: -150%;
                                    }
                                </style>
                            </ul>
                        </li>
                    </ul>
                @elif (  ( Auth()->user()->userType ) == ("writer")  )
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{url((Auth::user()->namePicture != '')?('storage/public/'.Auth::user()->namePicture):'images/dummyprofile.png')}}" class="pic">
                                <style>
                                    .pic{
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 50%;
                                        object-fit: cover;
                                    }
                                </style>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/company/".${Auth()}>ข้อมูลบริษัท</a></li>
                                <li><a class="dropdown-item" href="{{route('company.edit')}}">ตั้งค่าข้อมูลบริษัท</a></li>
                                <li><a class="dropdown-item" href="{{route('companyfollowing.index')}}">รายการติดตาม</a></li>

                                <li>
                                <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item" :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                {{ __('ออกจากระบบ') }}
                                        </button>
                                </form>
                                </li>

                                <style>
                                    .dropdown-menu{
                                        margin-left: -150%;
                                    }
                                </style>
                            </ul>
                        </li>
                    </ul>
                @elif (  ( Auth()->user()->userType ) == ("viewer")  )
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{url((Auth::user()->namePicture != '')?('storage/public/'.Auth::user()->namePicture):'images/dummyprofile.png')}}" class="pic">
                                <style>
                                    .pic{
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 50%;
                                        object-fit: cover;
                                    }
                                </style>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/company/".${Auth()}>ข้อมูลบริษัท</a></li>
                                <li><a class="dropdown-item" href="{{route('company.edit')}}">ตั้งค่าข้อมูลบริษัท</a></li>
                                <li><a class="dropdown-item" href="{{route('companyfollowing.index')}}">รายการติดตาม</a></li>

                                <li>
                                <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item" :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                {{ __('ออกจากระบบ') }}
                                        </button>
                                </form>
                                </li>

                                <style>
                                    .dropdown-menu{
                                        margin-left: -150%;
                                    }
                                </style>
                            </ul>
                        </li>
                    </ul>

                @endif


            @endif

        </div>
        </div>
      </nav>

      <div class="container py-2">
            @yield('content')
      </div>

      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>

