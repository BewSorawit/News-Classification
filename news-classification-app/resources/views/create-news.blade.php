<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างเนื้อหาใหม่</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* ซ่อนเนื้อหาทั้งหมดในกรณีที่ยังไม่ได้ล็อกอิน */
        body {
            display: none; /* ซ่อนเนื้อหาทั้งหมด */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>สร้างเนื้อหาใหม่</h2>
        <form id="newsForm">
            <div class="form-group">
                <label for="title">หัวข้อข่าว:</label>
                <input type="text" class="form-control" id="title" required>
            </div>
            <div class="form-group">
                <label for="content">เนื้อหา:</label>
                <textarea class="form-control" id="content" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const accessToken = localStorage.getItem('access_token'); // ดึง token จาก Local Storage

            // ตรวจสอบว่ามี access token หรือไม่
            if (!accessToken) {
                window.location.href = '/unlogin'; // เปลี่ยนเส้นทางไปที่หน้า unlogin ถ้าไม่มี access token
                return;
            }

            // ตรวจสอบ role ของผู้ใช้
            fetch('http://localhost:8001/typer_user_router/role', {
                method: 'GET',
                headers: { 'Authorization': `Bearer ${accessToken}` }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('ไม่สามารถตรวจสอบ role ของผู้ใช้ได้');
                }
                return response.json();
            })
            .then(data => {
                if (data.role !== 'Writer') {
                    // ถ้าไม่ใช่ Writer ให้กลับไปหน้ารายการข่าว
                    window.location.href = '/news';
                } else {
                    // แสดงเนื้อหาหลังจากตรวจสอบสำเร็จ
                    document.body.style.display = 'block'; // แสดงเนื้อหาหลังจากล็อกอินสำเร็จ
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("เกิดข้อผิดพลาดในการตรวจสอบ role ของผู้ใช้");
                window.location.href = '/news'; // ถ้ามีข้อผิดพลาดให้กลับไปที่หน้ารายการข่าว
            });

            document.getElementById("newsForm").addEventListener("submit", function(event) {
                event.preventDefault(); // ป้องกันการส่งฟอร์มโดยตรง
                
                const title = document.getElementById("title").value;
                const content = document.getElementById("content").value;

                // สร้างออบเจกต์ JSON สำหรับข้อมูล
                const newsData = {
                    title,
                    content
                };

                // ส่งข้อมูลไปยัง backend
                fetch('http://127.0.0.1:8001/news/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${accessToken}` // แนบ access token
                    },
                    body: JSON.stringify(newsData),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    // แสดงข้อความและเปลี่ยนเส้นทางกลับไปที่หน้ารายการข่าวหลังจากเพิ่มข้อมูลสำเร็จ
                    alert("บันทึกข่าวเรียบร้อยแล้ว");
                    window.location.href = '/news'; // เปลี่ยนเส้นทางไปยังหน้ารายการข่าว
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert("เกิดข้อผิดพลาดในการบันทึกข่าว");
                });
            });
        });
    </script>
</body>
</html>
