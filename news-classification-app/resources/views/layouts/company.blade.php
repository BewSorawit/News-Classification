<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            background-image: url('../images/homie.svg'); /* ลิงก์ไปยังรูปภาพ */
            background-size: cover; /* ทำให้รูปภาพครอบคลุมทั้งหน้าจอ */
            background-position: center; /* จัดกึ่งกลางรูปภาพ */
            background-repeat: no-repeat; /* ไม่ให้รูปภาพซ้ำ */
            background-attachment: fixed;
        }
    </style>
    <title>@yield('title') | resume-online </title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dyQwq4jN1jxptpDDHAxtZwU4y3XpZG9wCx/q27P4kRF9q9RWVh7bR9QYtu8/c9av/0wHZotQsCX3QGlRf6EbZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #efefef;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">JOBIE</a>
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('findUser', ['workType' => 'work']) }}">ค้นหาผู้หางาน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('findUser', ['workType' => 'intern']) }}">ค้นหานักศึกษาฝึกงาน</a>
                </li>
            </ul>
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

                            /* <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('ออกจากระบบ') }}
                                </button>
                            </form>
                            </li> */
                            /* <style> */
                                .dropdown-menu{
                                    margin-left: -150%;
                                }

                        </style>

                    </ul>
                </li>
            </ul>
          {{-- </div> --}}
        </div>
    </nav>

    <div class="container py-2">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>

</body>
</html>
