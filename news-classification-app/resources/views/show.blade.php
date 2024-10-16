@extends('layouts.app')
@section('title','Login')

@section('content')

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="news-title"></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
         /* #logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
        } */

        #content {
            display: none;
        }

        #no-content-warning {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: red;

        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <div id="user-controls" style="display: none;">
            {{-- <button id="logout-button" class="btn btn-danger">ล็อกเอาท์</button> --}}
            <a href="/news" class="btn btn-secondary mb-3">กลับไปหน้ารายการข่าว</a>
            <button id="edit-news-button" class="btn btn-warning mb-3" style="display: none;">แก้ไขข่าว</button>
        </div>

        <div id="content">
            <h1 id="news-title-h1"></h1>
            <p class="text-muted">
                <span class="badge badge-primary" id="category-1"></span>
                <span class="badge badge-secondary" id="category-2"></span>
            </p>
            <hr>
            <div id="reason-container" style="display: none;">
                <h5 class="text-danger">เหตุผลที่ไม่อนุมัติ: <span id="reason-text"></span></h5>
            </div>
            <p id="news-content"></p>

        </div>

        <div id="no-content-warning" class="alert alert-danger">
            ไม่พบเนื้อหานี้หรือไม่มีสิทธิ์ในการเข้าถึงเนื้อหา
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const accessToken = localStorage.getItem('access_token');

        if (!accessToken) {
            // Redirect to unlogin.blade.php if not logged in
            window.location.href = '/unlogin';
        } else {
            // Show user controls and content
            $('#user-controls').show();
            $('#content').show();

            const path = window.location.pathname;
            const newsId = path.split('/').pop();

            function checkUserRole() {
                return $.ajax({
                    url: 'http://localhost:8001/typer_user_router/role',
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchNewsDetails() {
                return $.ajax({
                    url: `http://localhost:8001/news/${newsId}`,
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchPublishedNews() {
                return $.ajax({
                    url: 'http://localhost:8001/news/type/2', // For Viewer
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchWriterNews() {
                return $.ajax({
                    url: 'http://localhost:8001/news/writer/',
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchEditorPendingNews() {
                return $.ajax({
                    url: 'http://localhost:8001/news/type/1', // Pending for Editor
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchEditorRejectedNews() {
                return $.ajax({
                    url: 'http://localhost:8001/news/typeByEditor/3', // Rejected for Editor
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchEditorPublishedNews() {
                return $.ajax({
                    url: 'http://localhost:8001/news/typeByEditor/2', // Published for Editor
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            function fetchWriterNewsReason() {
                return $.ajax({
                    url: 'http://localhost:8001/news/type/3', // For checking reason
                    method: 'GET',
                    headers: { 'Authorization': `Bearer ${accessToken}` }
                });
            }

            checkUserRole().done(function(roleResponse) {
                if (roleResponse.role === 'Writer') {
                    fetchWriterNews().done(function(writerNews) {
                        const writerNewsItem = writerNews.find(item => item.id === parseInt(newsId));
                        if (writerNewsItem) {
                            fetchNewsDetails().done(function(newsData) {
                                $('#news-title-h1').text(newsData.title);
                                document.title = newsData.title;
                                $('#news-content').text(newsData.content);

                                // Now check if the reason should be displayed
                                fetchWriterNewsReason().done(function(reasonNews) {
                                    const reasonNewsItem = reasonNews.find(item => item.id === parseInt(newsId));
                                    if (reasonNewsItem) {
                                        $('#reason-container').show();
                                        $('#reason-text').text(reasonNewsItem.reason);
                                    }
                                });

                                $.when(
                                    $.ajax({
                                        url: `http://localhost:8001/categories/${newsData.category_level_1}`,
                                        method: 'GET',
                                        headers: { 'Authorization': `Bearer ${accessToken}` }
                                    }),
                                    $.ajax({
                                        url: `http://localhost:8001/categories/${newsData.category_level_2}`,
                                        method: 'GET',
                                        headers: { 'Authorization': `Bearer ${accessToken}` }
                                    })
                                ).done(function(cat1, cat2) {
                                    $('#category-1').text(cat1[0].name);
                                    $('#category-2').text(cat2[0].name);
                                });
                            });
                        } else {
                            $('#no-content-warning').show();
                            $('#content').hide();
                        }
                    }).fail(function() {
                        alert('ไม่สามารถดึงข้อมูลข่าวของผู้เขียนได้');
                    });
                } else if (roleResponse.role === 'Viewer') {
                    fetchPublishedNews().done(function(publishedNews) {
                        const isViewerAccessAllowed = publishedNews.some(item => item.id === parseInt(newsId));
                        if (isViewerAccessAllowed) {
                            fetchNewsDetails().done(displayNews);
                        } else {
                            $('#no-content-warning').show();
                            $('#content').hide();
                        }
                    }).fail(function() {
                        alert('ไม่สามารถดึงข้อมูลข่าวที่เผยแพร่ได้');
                    });
                } else if (roleResponse.role === 'Editor') {
    $.when(
        fetchEditorPendingNews(),
        fetchEditorRejectedNews(),
        fetchEditorPublishedNews()
    ).done(function(pendingNews, rejectedNews, publishedNews) {
        const allEditorNews = [...pendingNews[0], ...rejectedNews[0], ...publishedNews[0]];
        const isEditorAccessAllowed = allEditorNews.some(item => item.id === parseInt(newsId));

        if (isEditorAccessAllowed) {
            fetchNewsDetails().done(function(newsData) {
                // Display news details
                $('#news-title-h1').text(newsData.title);
                document.title = newsData.title;
                $('#news-content').text(newsData.content);

                // Show the Edit button if the news is from type/1 (pending)
                const isPendingNews = pendingNews[0].some(item => item.id === parseInt(newsId));
                if (isPendingNews) {
                    $('#edit-news-button').show();
                }

                // Check if the news is from the rejected type
                const rejectedNewsItem = rejectedNews[0].find(item => item.id === parseInt(newsId));
                if (rejectedNewsItem) {
                    $('#reason-container').show();
                    $('#reason-text').text(rejectedNewsItem.reason);
                } else {
                    $('#reason-container').hide();
                }

                // Fetch categories for the news
                $.when(
                    $.ajax({
                        url: `http://localhost:8001/categories/${newsData.category_level_1}`,
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    }),
                    $.ajax({
                        url: `http://localhost:8001/categories/${newsData.category_level_2}`,
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    })
                ).done(function(cat1, cat2) {
                    $('#category-1').text(cat1[0].name);
                    $('#category-2').text(cat2[0].name);
                });
            });
        } else {
            $('#no-content-warning').show();
            $('#content').hide();
        }
    }).fail(function() {
        alert('ไม่สามารถดึงข้อมูลข่าวสำหรับ Editor ได้');
    });

    // Event handler for Edit News button
    $('#edit-news-button').on('click', function() {
        window.location.href = `/edit-news/${newsId}`;
    });
}

            }).fail(function() {
                alert('ไม่สามารถตรวจสอบบทบาทของผู้ใช้ได้');
            });

            function displayNews(data) {
                $('#news-title-h1').text(data.title);
                document.title = data.title;
                $('#news-content').text(data.content);

                $.when(
                    $.ajax({
                        url: `http://localhost:8001/categories/${data.category_level_1}`,
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    }),
                    $.ajax({
                        url: `http://localhost:8001/categories/${data.category_level_2}`,
                        method: 'GET',
                        headers: { 'Authorization': `Bearer ${accessToken}` }
                    })
                ).done(function(cat1, cat2) {
                    $('#category-1').text(cat1[0].name);
                    $('#category-2').text(cat2[0].name);
                });
            }

            $('#logout-button').on('click', function() {
                localStorage.removeItem('access_token');
                localStorage.removeItem('refresh_token');
                window.location.href = '/login';
            });
        }
    });
    </script>
</body>
</html>

@endsection
