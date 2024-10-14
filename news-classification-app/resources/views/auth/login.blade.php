@extends('layouts.app')
@section('title','Login')

@section('content')
    <div class="content">
        <div class="wrapper">
            <form form method="POST" action="{{route('login')}}">
                @csrf
                <h1 style="text-align: center;">Login</h1>
                <div class="input-box">
                    <input name="email" id="email" type="text" placeholder="email" required>
                    <i class='bx bx-user' ></i>
                </div>
                <div class="input-box">
                    <input name="password" id="password" type="password" placeholder="รหัสผ่าน" required>
                    <i class='bx bx-lock-alt' ></i>
                </div>

                <a type="submit">
                    <button type="submit" class="btn">เข้าสู่ระบบ</button>
                </a>

                <div class="register-link">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
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
                        width: 345%;
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

@endsection
