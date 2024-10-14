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
            {{-- !Auth::check() --}}
            @if ( =="" )
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
                          {{-- ( Auth()->user()->userType ) == ("admin") --}}
                @if (  == ("admin") )
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
                    url: 'http://localhost:8001/typer_user_router/role',
                    method: 'GET',
                    contentType: 'application/json',
                    headers: {
                        'Authorization': `Bearer ${accessToken}` // แนบ token ใน header
                    },
                    data: JSON.stringify({ email: email, password: password }),
                    success: function(data) {
                        console.log(data)
                    },
                    error: function() {
                        $('#error-message').text('อีเมลหรือรหัสผ่านไม่ถูกต้อง');
                    }
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>

