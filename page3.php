<?php
require_once 'db_connect.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $room = trim($_POST['room'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if (empty($teacher_id) || empty($name) || empty($surname) || empty($email)) {
        $error_message = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    } else {
        try {
            $stmt = $conn->prepare("UPDATE Teachers SET name = :name, surname = :surname, room = :room, mobile = :mobile, email = :email WHERE teacher_id = :teacher_id");
            $stmt->execute([
                ':teacher_id' => $teacher_id,
                ':name' => $name,
                ':surname' => $surname,
                ':room' => $room,
                ':mobile' => $mobile,
                ':email' => $email
            ]);
            $success_message = 'อัปเดตข้อมูลเรียบร้อยแล้ว!';
        } catch(PDOException $e) {
            $error_message = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
        }
    }
}

// Fetch all teachers for editing
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
        .edit-box { background: white; padding: 15px; border-left: 5px solid #ffcc00; margin-bottom: 15px; border-radius: 4px; }
        .edit-box strong { display: block; margin-bottom: 10px; color: #333; }
        input[type="text"], input[type="number"], select { padding: 8px; margin: 5px 5px 5px 0; border: 1px solid #ddd; border-radius: 4px; width: 200px; }
        button { padding: 8px 20px; background-color: #ffcc00; color: black; border: 1px solid #999; cursor: pointer; border-radius: 4px; font-weight: bold; }
        button:hover { background-color: #ffdb4d; }
        .success { color: green; padding: 10px; background: #eeffee; border: 1px solid green; margin-bottom: 10px; }
        .error { color: red; padding: 10px; background: #ffeeee; border: 1px solid red; margin-bottom: 10px; }
        .no-data { text-align: center; padding: 20px; color: #666; }
        label { display: inline-block; width: 100px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Link 3: แก้ไขข้อมูล (Edit Data)</h2>
    <p>เลือกรายการที่ต้องการแก้ไข</p>

    <?php if ($success_message): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if (!empty($teachers)): ?>
        <?php foreach ($teachers as $teacher): ?>
            <div class="edit-box">
                <strong>อาจารย์: <?php echo htmlspecialchars($teacher['name'] . ' ' . $teacher['surname']); ?> (ID: <?php echo htmlspecialchars($teacher['teacher_id']); ?>)</strong>
                <form method="POST" action="" style="display: inline-block;">
                    <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($teacher['teacher_id']); ?>">
                    
                    <div style="margin-bottom: 8px;">
                        <label>ชื่อ:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required>
                    </div>
                    
                    <div style="margin-bottom: 8px;">
                        <label>นามสกุล:</label>
                        <input type="text" name="surname" value="<?php echo htmlspecialchars($teacher['surname']); ?>" required>
                    </div>
                    
                    <div style="margin-bottom: 8px;">
                        <label>ห้อง:</label>
                        <input type="text" name="room" value="<?php echo htmlspecialchars($teacher['room']); ?>">
                    </div>
                    
                    <div style="margin-bottom: 8px;">
                        <label>เบอร์โทร:</label>
                        <input type="text" name="mobile" value="<?php echo htmlspecialchars($teacher['mobile']); ?>">
                    </div>
                    
                    <div style="margin-bottom: 8px;">
                        <label>อีเมล:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
                    </div>
                    
                    <button type="submit" name="update">ยืนยันการแก้ไข</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-data">ไม่มีข้อมูลในระบบ</div>
    <?php endif; ?>
</body>
</html>
