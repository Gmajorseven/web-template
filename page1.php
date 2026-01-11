<?php
require_once 'db_connect.php';

// Fetch data from database
try {
    $stmt = $conn->query("SELECT * FROM Teachers ORDER BY teacher_id");
    $teachers = $stmt->fetchAll();
} catch(PDOException $e) {
    $error_message = "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        h2 { color: #333; border-bottom: 2px solid brown; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: brown; color: white; }
        tr:nth-child(even) { background-color: #eee; }
        .error { color: red; padding: 10px; background: #ffeeee; border: 1px solid red; }
        .no-data { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>
    <h2>Link 1: แสดงข้อมูล (Show Data)</h2>
    <p>หน้านี้ใช้สำหรับแสดงรายการข้อมูลที่มีอยู่ในระบบ</p>
    
    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Teacher ID</th>
                <th>ชื่อ (Name)</th>
                <th>นามสกุล (Surname)</th>
                <th>ห้อง (Room)</th>
                <th>เบอร์โทร (Mobile)</th>
                <th>อีเมล (Email)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($teachers)): ?>
                <?php foreach ($teachers as $teacher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($teacher['teacher_id']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['name']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['surname']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['room']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['mobile']); ?></td>
                        <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="no-data">ไม่มีข้อมูลในระบบ</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
