<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="news-title"></title> <!-- ตั้งค่า id ให้กับ title -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <a href="/news" class="btn btn-secondary mb-3">กลับไปหน้ารายการข่าว</a>
        <h1 id="news-title-h1"></h1> <!-- เปลี่ยน id เพื่อแสดงหัวข้อข่าวใน h1 -->
        <p class="text-muted">
            <span class="badge badge-primary" id="category-1"></span>
            <span class="badge badge-secondary" id="category-2"></span>
        </p>
        <hr>
        <p id="news-content"></p>
    </div>

    <script>
        $(document).ready(function() {
            const path = window.location.pathname; // รับ URL ของ path
            const newsId = path.split('/').pop(); // แยก id ออกมาจาก path

            $.ajax({
                url: `http://localhost:8001/news/${newsId}`,  // URL ของ API
                method: 'GET',
                success: function(data) {
                    // แสดงหัวข้อข่าวใน <h1> และ <title>
                    $('#news-title-h1').text(data.title);
                    document.title = data.title; // ตั้งค่าหัวข้อข่าวใน <title>
                    $('#category-1').text(data.category_level_1);
                    $('#category-2').text(data.category_level_2);
                    $('#news-content').text(data.content);
                },
                error: function() {
                    alert('ไม่สามารถดึงข้อมูลข่าวได้');
                }
            });
        });
    </script>
</body>
</html>
