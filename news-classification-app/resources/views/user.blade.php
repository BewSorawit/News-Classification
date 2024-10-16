@extends('layouts.app')
@section('title','Login')

@section('content')

        <!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ข้อมูลผู้ใช้ทั้งหมด</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <style>
                .logout-button {
                    position: absolute; /* Position it at the top right */
                    right: 20px; /* Adjust as necessary */
                    top: 20px; /* Adjust as necessary */
                }
                .signup-button {
                    position: absolute; /* Position it to the left of the logout button */
                    right: 120px; /* Adjust as necessary to space it from the logout button */
                    top: 20px; /* Align with the logout button */
                    margin-right: 20px; /* Add margin to create space between buttons */
                }
            </style>
        </head>
        <body>
            <div class="container mt-5">
                {{-- <button class="btn btn-primary signup-button" id="signup">สมัครสมาชิก</button> <!-- Sign Up button -->
                <button class="btn btn-danger logout-button" id="logout">ออกจากระบบ</button> <!-- Logout button --> --}}
                <h2>ข้อมูลผู้ใช้ทั้งหมด</h2>
                <table class="table table-bordered mt-3" id="user-table">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>อีเมล</th>
                            <th>บทบาท</th>
                            <th>การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div id="error-message" class="text-danger mt-3"></div>
            </div>

            <script>
                $(document).ready(function() {
                    const accessToken = localStorage.getItem('access_token'); // ดึง token จาก localStorage

                    if (!accessToken) {
                        window.location.href = '/news'; // ถ้าไม่มี token ให้ไปที่หน้า news
                        return;
                    }

                    // ตรวจสอบ role ของผู้ใช้
                    $.ajax({
                        url: 'http://localhost:8001/typer_user_router/role',
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` },
                        success: function(roleData) {
                            console.log('User Role:', roleData.role); // แสดง role ใน console

                            if (roleData.role !== 'Admin') {
                                window.location.href = '/news'; // ถ้าไม่ใช่ Admin ให้ไปที่หน้า news
                                return;
                            }

                            // ถ้าเป็น Admin ดึงข้อมูลผู้ใช้ทั้งหมด
                            $.ajax({
                                url: 'http://localhost:8001/users/',
                                method: 'GET',
                                headers: { 'Authorization': `Bearer ${accessToken}` },
                                success: function(users) {
                                    const tbody = $('#user-table tbody');
                                    tbody.empty(); // ล้างข้อมูลเก่า

                                    // ดึงข้อมูล role ทั้งหมด
                                    $.ajax({
                                        url: 'http://localhost:8001/typer_user_router/', // ดึงข้อมูล role
                                        method: 'GET',
                                        headers: { 'Authorization': `Bearer ${accessToken}` },
                                        success: function(roles) {
                                            // สร้าง object สำหรับการเก็บ role โดยใช้ id เป็น key
                                            const roleMap = {};
                                            roles.forEach(role => {
                                                roleMap[role.id] = role.role; // เก็บ role ตาม id
                                            });

                                            // วนลูปผ่านผู้ใช้
                                            users.forEach(user => {
                                                const userRole = roleMap[user.typer_user_id] || 'ไม่มีบทบาท'; // ตรวจสอบ role

                                                // Skip users with 'Admin' role
                                                if (userRole === 'Admin') return;

                                                const row = `
                                                    <tr data-id="${user.id}"> <!-- Store user ID in the row for easy access -->
                                                        <td><span class="username">${user.username}</span><input type="text" class="form-control edit-username" value="${user.username}" style="display:none;"></td>
                                                        <td><span class="email">${user.email}</span><input type="email" class="form-control edit-email" value="${user.email}" style="display:none;"></td>
                                                        <td>
                                                            <span class="user-role">${userRole}</span>
                                                            <select class="form-control edit-role" style="display:none;"></select>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning edit-user">แก้ไข</button>
                                                            <button class="btn btn-success confirm-edit" style="display:none;">ยืนยัน</button>
                                                            <button class="btn btn-secondary cancel-edit" style="display:none;">ยกเลิก</button>
                                                            <button class="btn btn-danger delete-user" data-id="${user.id}">ลบ</button>
                                                        </td>
                                                    </tr>`;
                                                tbody.append(row);
                                            });

                                            // Populate the role dropdown and handle editing
                                            $('.edit-role').each(function() {
                                                const currentRole = $(this).siblings('.user-role').text();
                                                const options = roles.map(role => `<option value="${role.id}" ${role.role === currentRole ? 'selected' : ''}>${role.role}</option>`);
                                                $(this).html(options.join(''));
                                            });

                                            // Handle edit button click
                                            $('.edit-user').on('click', function() {
                                                const row = $(this).closest('tr'); // Get the closest row
                                                row.find('.username, .email, .user-role').hide(); // Hide text
                                                row.find('.edit-username, .edit-email, .edit-role').show(); // Show inputs
                                                $(this).hide(); // Hide edit button
                                                row.find('.confirm-edit, .cancel-edit').show(); // Show confirm and cancel buttons
                                            });

                                            // Handle confirm edit button click
                                            $('.confirm-edit').on('click', function() {
                                                const row = $(this).closest('tr');
                                                const userId = row.data('id');
                                                const newUsername = row.find('.edit-username').val();
                                                const newEmail = row.find('.edit-email').val();
                                                const newRoleId = row.find('.edit-role').val();

                                                $.ajax({
                                                    url: `http://localhost:8001/users/${userId}`,
                                                    method: 'PUT',
                                                    headers: { 'Authorization': `Bearer ${accessToken}` },
                                                    contentType: 'application/json',
                                                    data: JSON.stringify({
                                                        username: newUsername,
                                                        email: newEmail,
                                                        typer_user_id: newRoleId // Send updated role ID
                                                    }),
                                                    success: function() {
                                                        alert('แก้ไขข้อมูลผู้ใช้สำเร็จ');
                                                        row.find('.username').text(newUsername).show(); // Update displayed username
                                                        row.find('.email').text(newEmail).show(); // Update displayed email
                                                        row.find('.user-role').text(roleMap[newRoleId]).show(); // Update displayed role
                                                        row.find('.edit-username, .edit-email, .edit-role').hide(); // Hide input fields
                                                        row.find('.confirm-edit, .cancel-edit').hide(); // Hide confirm and cancel buttons
                                                        row.find('.edit-user').show(); // Show edit button again
                                                    },
                                                    error: function() {
                                                        $('#error-message').text('ไม่สามารถแก้ไขข้อมูลผู้ใช้ได้');
                                                    }
                                                });
                                            });

                                            // Handle cancel edit button click
                                            $('.cancel-edit').on('click', function() {
                                                const row = $(this).closest('tr');
                                                row.find('.edit-username, .edit-email, .edit-role').hide(); // Hide input fields
                                                row.find('.username, .email, .user-role').show(); // Show text again
                                                row.find('.confirm-edit, .cancel-edit').hide(); // Hide confirm and cancel buttons
                                                row.find('.edit-user').show(); // Show edit button again
                                            });

                                            // Handle delete button click
                                            $('.delete-user').on('click', function() {
                                                const userId = $(this).data('id'); // Get user ID from data attribute
                                                if (confirm('คุณแน่ใจว่าต้องการลบผู้ใช้คนนี้?')) { // Confirm deletion
                                                    $.ajax({
                                                        url: `http://localhost:8001/users/${userId}`,
                                                        method: 'DELETE',
                                                        headers: { 'Authorization': `Bearer ${accessToken}` },
                                                        success: function() {
                                                            alert('ลบผู้ใช้สำเร็จ');
                                                            location.reload(); // Reload the page to refresh the user list
                                                        },
                                                        error: function() {
                                                            $('#error-message').text('ไม่สามารถลบผู้ใช้ได้');
                                                        }
                                                    });
                                                }
                                            });
                                        },
                                        error: function() {
                                            $('#error-message').text('ไม่สามารถดึงข้อมูลบทบาทผู้ใช้ได้');
                                        }
                                    });
                                },
                                error: function() {
                                    $('#error-message').text('ไม่สามารถดึงข้อมูลผู้ใช้ได้');
                                }
                            });
                        },
                        error: function() {
                            // Clear the access token and redirect to login page
                            localStorage.removeItem('access_token');
                            $('#error-message').text('ไม่สามารถตรวจสอบบทบาทผู้ใช้ได้');
                            window.location.href = '/login'; // Redirect to login page
                        }
                    });

                    // Logout functionality
                    $('#logout').on('click', function() {
                        localStorage.removeItem('access_token'); // Clear the access token
                        window.location.href = '/login'; // Redirect to the login page
                    });

                    // Sign Up button functionality
                    $('#signup').on('click', function() {
                        window.location.href = '/register'; // Redirect to the register page
                    });
                });
            </script>
        </body>
        </html>

@endsection
