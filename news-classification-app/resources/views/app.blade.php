@extends('layouts.app')

@section('content')


<div class="content">
    <div class="wrapper">
        <form method="POST" action="{{route('register')}}">
            @csrf
            <h1 style="text-align: center;">Register</h1>
            <div class="input-box">
                <input name="name" id="name" type="text" placeholder="ชื่อผู้ใช้" required>
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

            <div class="form-check form-check-inline" style="margin-top: 5%;">
                <input id="userrole" class="form-check-input" type="radio" name="userrole" value="admin">
                <label class="form-check-label" for="inlineRadio1">admin</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="userrole" class="form-check-input" type="radio" name="userrole" value="editor">
                <label class="form-check-label" for="inlineRadio2">editor</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="userrole" class="form-check-input" type="radio" name="userrole" value="writer">
                <label class="form-check-label" for="inlineRadio3">writer</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="userrole" class="form-check-input" type="radio" name="userrole" value="viewer">
                <label class="form-check-label" for="inlineRadio4">viewer</label>
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

@endsection
