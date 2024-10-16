@extends('layouts.app')
@section('title','Login')

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
            /* #logout-button, #add-news-button {
                position: absolute;
                top: 20px;
            } */
            /* #add-news-button {
                right: 140px; /* ปรับระยะห่างจากขอบขวา */
            /* } */ */
            /* #logout-button {
                right: 20px;
            }
            body {
                display: none;
            } */
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <h2>รายการข่าว</h2>
            <ul class="nav nav-tabs" id="status-tabs" style="display: none;">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-status="1">รอพิจารณา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-status="3">ไม่ได้รับการอนุมัติ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-status="2">เผยแพร่แล้ว</a>
                </li>
            </ul>
            <div class="list-group" id="news-list"></div>
            <button id="add-news-button" class="btn btn-primary" style="display: none;">เพิ่มเนื้อหาใหม่</button>
            {{-- <button id="logout-button" class="btn btn-danger">ล็อกเอาท์</button> --}}
        </div>

        <script>
            $(document).ready(function() {
                const accessToken = localStorage.getItem('access_token');

                // Check if user is logged in
                if (!accessToken) {
                    window.location.href = '/unlogin'; // Redirect to unlogin page
                    return;
                }

                function fetchNewsForWriter(status) {
                    const writerApi = 'http://localhost:8001/news/writer/';
                    const statusApi = `http://localhost:8001/news/type/${status}`;

                    $.when(
                        $.ajax({
                            url: writerApi,
                            method: 'GET',
                            headers: { 'Authorization': `Bearer ${accessToken}` }
                        }),
                        $.ajax({
                            url: statusApi,
                            method: 'GET',
                            headers: { 'Authorization': `Bearer ${accessToken}` }
                        })
                    ).done(function(writerData, statusData) {
                        const matchingNews = writerData[0].filter(news =>
                            statusData[0].some(statusItem => statusItem.id === news.id)
                        );
                        displayNews(matchingNews);
                    }).fail(function() {
                        alert('ไม่สามารถดึงข้อมูลข่าวได้');
                    });
                }

                function fetchNewsForViewer() {
                    const viewerApi = 'http://localhost:8001/news/type/2';
                    $.ajax({
                        url: viewerApi,
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    }).done(function(data) {
                        displayNews(data);
                    }).fail(function() {
                        alert('ไม่สามารถดึงข้อมูลข่าวสำหรับ Viewer ได้');
                    });
                }

                function fetchNewsForEditor(status) {
                    let editorApi;
                    if (status === 1) {
                        editorApi = 'http://localhost:8001/news/type/1'; // รอพิจารณา
                    } else if (status === 2) {
                        editorApi = 'http://localhost:8001/news/typeByEditor/2'; // เผยแพร่แล้ว
                    } else if (status === 3) {
                        editorApi = 'http://localhost:8001/news/typeByEditor/3'; // ไม่ได้รับการอนุมัติ
                    }

                    $.ajax({
                        url: editorApi,
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    }).done(function(data) {
                        displayNews(data);
                    }).fail(function() {
                        alert('ไม่สามารถดึงข้อมูลข่าวสำหรับ Editor ได้');
                    });
                }

                function displayNews(newsItems) {
                    const newsList = $('#news-list');
                    newsList.empty();

                    const categoryPromises = newsItems.map(item => {
                        return Promise.all([
                            $.ajax({
                                url: `http://localhost:8001/categories/${item.category_level_1}`,
                                method: 'GET',
                                headers: { 'Authorization': `Bearer ${accessToken}` }
                            }),
                            $.ajax({
                                url: `http://localhost:8001/categories/${item.category_level_2}`,
                                method: 'GET',
                                headers: { 'Authorization': `Bearer ${accessToken}` }
                            })
                        ]).then(([level1Data, level2Data]) => ({
                            title: item.title,
                            id: item.id,
                            category_level_1_name: level1Data.name,
                            category_level_2_name: level2Data.name
                        }));
                    });

                    Promise.all(categoryPromises).then(newsData => {
                        newsData.forEach(item => {
                            newsList.append(`
                                <div class="list-group-item">
                                    <h5 class="mb-1">
                                        <a href="/news/${item.id}" class="text-decoration-none">${item.title}</a>
                                    </h5>
                                    <p class="mb-1">
                                        <span class="badge badge-primary">${item.category_level_1_name}</span>
                                        <span class="badge badge-secondary">${item.category_level_2_name}</span>
                                    </p>
                                </div>
                            `);
                        });
                    });
                }

                $.ajax({
                    url: 'http://localhost:8001/typer_user_router/role',
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` },
                    success: function(response) {
                        if (response.role === 'Writer') {
                            $('#status-tabs, #add-news-button').show();
                            fetchNewsForWriter(1);

                            $('#status-tabs .nav-link').on('click', function() {
                                $('#status-tabs .nav-link').removeClass('active');
                                $(this).addClass('active');
                                const status = $(this).data('status');
                                fetchNewsForWriter(status);
                            });
                        } else if (response.role === 'Viewer') {
                            fetchNewsForViewer(); // For Viewer role
                        } else if (response.role === 'Editor') {
                            $('#status-tabs').show(); // Show status tabs for Editor
                            fetchNewsForEditor(1); // Fetch news for the "รอพิจารณา" status by default

                            $('#status-tabs .nav-link').on('click', function() {
                                $('#status-tabs .nav-link').removeClass('active');
                                $(this).addClass('active');
                                const status = $(this).data('status');
                                fetchNewsForEditor(status); // Fetch news based on selected status
                            });
                        }
                        $('body').show();
                    },
                    error: function() {
                        alert('ไม่สามารถตรวจสอบ role ของผู้ใช้ได้');
                    }
                });

                $('#logout-button').on('click', function() {
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token');
                    window.location.href = '/login';
                });

                $('#add-news-button').on('click', function() {
                    window.location.href = '/create-news';
                });

            });

            </script>

    </body>
    </html>

@endsection

