<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างเนื้อหาใหม่</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        document.getElementById("newsForm").addEventListener("submit", function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มโดยตรง
            
            const title = document.getElementById("title").value;
            const content = document.getElementById("content").value;

            // กำหนดประเภทข่าวอัตโนมัติ (ใช้ประเภทข่าวแรกเป็นตัวอย่าง)
            const news_type_id = 1; // ระบุประเภทข่าวที่ต้องการโดยอัตโนมัติ (เช่น "Upload")
            const writer_id = 3; // กำหนด writer_id เป็น 3
            const upload_date = new Date().toISOString(); // วันที่ปัจจุบันในรูปแบบ ISO

            // สร้างออบเจกต์ JSON สำหรับข้อมูล
            const newsData = {
                title,
                content,
                news_type_id,
                writer_id,   // เพิ่ม writer_id
                upload_date   // เพิ่ม upload_date
            };

            console.log("หัวข้อข่าว:", title);
            console.log("เนื้อหา:", content);
            console.log("ประเภทข่าว:", news_type_id);
            console.log("writer_id:", writer_id);
            console.log("upload_date:", upload_date);

            // ส่งข้อมูลไปยัง backend
            fetch('http://127.0.0.1:8001/news/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
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
                // แสดงข้อความหรือเปลี่ยนหน้าเว็บหลังจากเพิ่มข้อมูลสำเร็จ
                alert("บันทึกข่าวเรียบร้อยแล้ว");
                document.getElementById("newsForm").reset(); // รีเซ็ตฟอร์ม
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("เกิดข้อผิดพลาดในการบันทึกข่าว");
            });
        });
    </script>
</body>
</html>
