<?php
require_once 'db_connect.php';

$success_message = '';
$error_message = '';

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    
    if (empty($teacher_id)) {
        $error_message = 'ไม่พบรหัสอาจารย์';
    } else {
        try {
            $stmt = $conn->prepare("DELETE FROM Teachers WHERE teacher_id = :teacher_id");
            $stmt->execute([':teacher_id' => $teacher_id]);
            $success_message = 'ลบข้อมูลเรียบร้อยแล้ว!';
        } catch(PDOException $e) {
            $error_message = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
        }
    }
}

// Fetch all teachers
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
        ul { list-style-type: none; padding: 0; }
        li { background: white; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; border-radius: 4px; }
        .btn-delete { background-color: red; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 4px; font-weight: bold; }
        .btn-delete:hover { background-color: darkred; }
        .success { color: green; padding: 10px; background: #eeffee; border: 1px solid green; margin-bottom: 10px; }
        .error { color: red; padding: 10px; background: #ffeeee; border: 1px solid red; margin-bottom: 10px; }
        .no-data { text-align: center; padding: 20px; color: #666; }
        .item-info { font-size: 16px; color: #333; }
        .item-info strong { color: brown; }
    </style>
    <script>
        function confirmDelete(teacherName) {
            return confirm('ยืนยันที่จะลบอาจารย์ "' + teacherName + '" หรือไม่?');
        }
    </script>
</head>
<body>
    <h2>Link 4: ลบข้อมูล (Delete Data)</h2>
    <p>คลิกที่ปุ่มลบเพื่อนำข้อมูลออกจากระบบ</p>

    <?php if ($success_message): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <ul>
        <?php if (!empty($teachers)): ?>
            <?php foreach ($teachers as $teacher): ?>
                <li>
                    <span class="item-info">
                        <strong><?php echo htmlspecialchars($teacher['teacher_id']); ?></strong> - 
                        <?php echo htmlspecialchars($teacher['name'] . ' ' . $teacher['surname']); ?> 
                        (<?php echo htmlspecialchars($teacher['email']); ?>)
                    </span>
                    <form method="POST" action="" style="display: inline;" onsubmit="return confirmDelete('<?php echo htmlspecialchars($teacher['name'] . ' ' . $teacher['surname'], ENT_QUOTES); ?>')">
                        <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($teacher['teacher_id']); ?>">
                        <button type="submit" name="delete" class="btn-delete">ลบ (Delete)</button>
                    </form>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="no-data">ไม่มีข้อมูลในระบบ</li>
        <?php endif; ?>
    </ul>
</body>
</html>
