<?php
require_once 'db_connect.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $room = trim($_POST['room'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if (empty($name) || empty($surname) || empty($email)) {
        $error_message = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO Teachers (name, surname, room, mobile, email) VALUES (:name, :surname, :room, :mobile, :email)");
            $stmt->execute([
                ':name' => $name,
                ':surname' => $surname,
                ':room' => $room,
                ':mobile' => $mobile,
                ':email' => $email
            ]);
            $success_message = 'บันทึกข้อมูลเรียบร้อยแล้ว!';
            // Clear form
            $name = $surname = $room = $mobile = $email = '';
        } catch(PDOException $e) {
            $error_message = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        h2 { color: #333; border-bottom: 2px solid brown; padding-bottom: 10px; }
        form { background: white; padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 400px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background-color: brown; color: white; border: none; cursor: pointer; border-radius: 4px; }
        button:hover { background-color: #a52a2a; }
        .success { color: green; padding: 10px; background: #eeffee; border: 1px solid green; margin-bottom: 10px; }
        .error { color: red; padding: 10px; background: #ffeeee; border: 1px solid red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Link 2: เพิ่มข้อมูล (Add Data)</h2>
    <p>กรอกข้อมูลด้านล่างเพื่อทำการเพิ่มรายการใหม่</p>

    <?php if ($success_message): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>ชื่อ (Name):</label>
        <input type="text" name="name" placeholder="ระบุชื่อ" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>

        <label>นามสกุล (Surname):</label>
        <input type="text" name="surname" placeholder="ระบุนามสกุล" value="<?php echo htmlspecialchars($surname ?? ''); ?>" required>

        <label>ห้อง (Room):</label>
        <input type="text" name="room" placeholder="ระบุห้อง" value="<?php echo htmlspecialchars($room ?? ''); ?>">

        <label>เบอร์โทร (Mobile):</label>
        <input type="text" name="mobile" placeholder="ระบุเบอร์โทร" value="<?php echo htmlspecialchars($mobile ?? ''); ?>">

        <label>อีเมล (Email):</label>
        <input type="email" name="email" placeholder="ระบุอีเมล" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>

        <button type="submit">บันทึกข้อมูล</button>
    </form>
</body>
</html>
