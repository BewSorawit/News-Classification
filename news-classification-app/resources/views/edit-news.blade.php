@extends('layouts.app')
@section('title','LOL')

@section('content')


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข่าว</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5" id="content" style="display: none;"> <!-- Initially hidden -->
        <h1>แก้ไขข่าว</h1>

        <form id="editNewsForm" action="/news/{{ $id }}" method="POST">
            @csrf
            @method('PUT')

            <!-- News Title -->
            <div class="form-group">
                <label for="newsTitle">หัวข้อข่าว</label>
                <input type="text" class="form-control" id="newsTitle" name="title" readonly>
            </div>

            <!-- News Content -->
            <div class="form-group">
                <label for="newsContent">เนื้อหาข่าว</label>
                <textarea class="form-control" id="newsContent" name="content" rows="5" readonly></textarea>
            </div>

            <!-- Status Dropdown -->
            <div class="form-group">
                <label for="status">สถานะข่าว</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">เลือกสถานะ</option>
                </select>
            </div>

            <!-- Reason Input -->
            <div class="form-group">
                <label for="reason">เหตุผล</label>
                <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="กรอกเหตุผล"></textarea>
            </div>

            <!-- Category Dropdowns -->
            <div class="form-group">
                <label for="category1">หมวดหมู่ 1</label>
                <select class="form-control" id="category1" name="category1" required>
                    <option value="">เลือกหมวดหมู่ 1</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category2">หมวดหมู่ 2</label>
                <select class="form-control" id="category2" name="category2" required>
                    <option value="">เลือกหมวดหมู่ 2</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
            <a href="/news" class="btn btn-secondary">ยกเลิก</a>
        </form>

        <!-- Logout Button -->
        <button id="logoutButton" class="btn btn-danger mt-3">ออกจากระบบ</button>
    </div>

    <script>
        $(document).ready(function () {
            const accessToken = localStorage.getItem('access_token');

            if (!accessToken) {
                // Redirect to the unlogin page if not logged in
                window.location.href = '/unlogin';
                return; // Stop further execution
            }

            // Check user role
            $.ajax({
                url: 'http://localhost:8001/typer_user_router/role', // Role endpoint
                method: 'GET',
                headers: { 'Authorization': `Bearer ${accessToken}` }
            }).done(function (roleData) {
                if (roleData.role !== 'Editor') {
                    // Redirect to news page if role is not Editor
                    window.location.href = '/news';
                    return; // Stop further execution
                }

                // If the role is Editor, show the content
                $('#content').show();

                // Fetch news data for editing
                const newsId = {{ $id }};
                $.ajax({
                    url: `http://localhost:8001/news/${newsId}`,
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                }).done(function (newsData) {
                    // Check if news_type_id is not 1, redirect to news page
                    if (newsData.news_type_id !== 1) {
                        alert('คุณไม่มีสิทธิ์แก้ไขข่าวนี้');
                        window.location.href = '/news'; // Redirect if not allowed
                        return; // Stop further execution
                    }

                    // Set the title and content in readonly fields
                    $('#newsTitle').val(newsData.title); // Updated ID for title
                    $('#newsContent').val(newsData.content); // Updated ID for content
                    $('#reason').val(newsData.reason);

                    // Fetch status options from /news_type/
                    $.ajax({
                        url: 'http://localhost:8001/news_type/',
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    }).done(function (statusData) {
                        statusData.forEach(function (status) {
                            $('#status').append(`<option value="${status.id}">${status.status}</option>`);
                        });

                        // Set the selected status after appending options
                        $('#status').val(newsData.news_type_id);
                    }).fail(function () {
                        alert('ไม่สามารถดึงข้อมูลสถานะข่าวได้');
                    });

                    // Fetch categories from /categories/
                    $.ajax({
                        url: 'http://localhost:8001/categories/',
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    }).done(function (categoriesData) {
                        categoriesData.forEach(function (category) {
                            $('#category1').append(`<option value="${category.id}">${category.name}</option>`);
                            $('#category2').append(`<option value="${category.id}">${category.name}</option>`);
                        });

                        // Set the selected categories
                        $('#category1').val(newsData.category_level_1);
                        $('#category2').val(newsData.category_level_2);
                    }).fail(function () {
                        alert('ไม่สามารถดึงข้อมูลหมวดหมู่ได้');
                    });
                }).fail(function () {
                    alert('ไม่สามารถดึงข้อมูลข่าวได้');
                });

                // Event listener for category selection to remove selected options from the other dropdown
                $('#category1, #category2').on('change', function () {
                    const selectedCategory1 = $('#category1').val();
                    const selectedCategory2 = $('#category2').val();

                    // Clear the previous options
                    $('#category1 option').each(function () {
                        if ($(this).val() === selectedCategory2) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });

                    $('#category2 option').each(function () {
                        if ($(this).val() === selectedCategory1) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });
                });

                // Handle form submission
                $('#editNewsForm').on('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission

                    const selectedStatus = $('#status').val();
                    const reason = $('#reason').val().trim();

                    // Check conditions based on the selected status
                    if (selectedStatus === "1") {
                        alert('กรุณาแก้ไขสถานะของข่าว');
                        return; // Prevent submission
                    }

                    if (selectedStatus === "2") {
                        // No reason needed, can proceed
                        submitForm();
                    } else if (selectedStatus === "3") {
                        if (!reason) {
                            alert('กรุณากรอกเหตุผลก่อนบันทึก');
                        } else {
                            submitForm();
                        }
                    } else {
                        submitForm(); // For any other status
                    }
                });

                // Function to submit the form data
                function submitForm() {
                    const formData = {
                        news_type_id: $('#status').val(), // ใช้ชื่อฟิลด์ที่ตรงตาม API
                        reason: $('#reason').val(), // ข้อความเหตุผล
                        category_level_1: $('#category1').val(), // ID หมวดหมู่ 1 ที่เลือก
                        category_level_2: $('#category2').val(), // ID หมวดหมู่ 2 ที่เลือก
                    };

                    $.ajax({
                        url: `http://localhost:8001/news/${newsId}`, // URL ที่ใช้ทำ PUT
                        method: 'PUT',
                        headers: { 'Authorization': `Bearer ${accessToken}`, 'Content-Type': 'application/json' },
                        data: JSON.stringify(formData), // ส่งข้อมูลในรูปแบบ JSON
                    }).done(function () {
                        alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                        window.location.href = '/news'; // Redirect to news list after saving
                    }).fail(function (jqXHR) {
                        // แสดงข้อความตอบกลับจากเซิร์ฟเวอร์
                        const errorResponse = jqXHR.responseJSON || {};
                        const errorMessage = errorResponse.details ? errorResponse.details.join(', ') : 'ไม่สามารถบันทึกข้อมูลได้';
                        alert(errorMessage);
                    });
                }

                // Logout button click event
                $('#logoutButton').on('click', function () {
                    // Clear the access token
                    localStorage.removeItem('access_token');
                    // Redirect to the login page or unlogin page
                    window.location.href = '/unlogin';
                });

            }).fail(function () {
                // Redirect to news page if role check fails
                window.location.href = '/news';
            });
        });
    </script>
</body>
</html>

@endsection
