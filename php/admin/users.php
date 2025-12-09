<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');

// Xử lý thông báo flash message
$message = '';
$message_type = '';
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message']['text'];
    $message_type = $_SESSION['flash_message']['type'];
    unset($_SESSION['flash_message']);
}
?>

<div class="users__container">
    <h1 class="users__header">Quản lý Người Dùng</h1>

    <?php if ($message) : ?>
        <div class="users__alert users__alert--<?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <table class="users__table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Họ và tên</th>
                <th>Trạng thái</th>
                <th class="users__table-actions">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Lấy tất cả người dùng, trừ admin hiện tại để tránh tự khóa
            $current_admin_id = $_SESSION['admin_id'] ?? 0;
            $sql = "SELECT id, username, email, fullname, role FROM users WHERE id != ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $current_admin_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $status_text = 'Hoạt động';
                    $status_class = 'users__status--active';
                    if ($row['role'] == 1) {
                        $status_text = 'Admin';
                        $status_class = 'users__status--admin';
                    } elseif ($row['role'] == 2) {
                        $status_text = 'Bị khóa';
                        $status_class = 'users__status--blocked';
                    }
            ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><span class="users__status <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        <td class="users__table-actions">
                            <?php if ($row['role'] == 0) : // Nếu là user thường, cho phép khóa ?>
                                <a href="_user_process.php?action=block&id=<?php echo $row['id']; ?>" class="users__action-link users__action-link--block" title="Khóa tài khoản" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">Khóa</a>
                            <?php elseif ($row['role'] == 2) : // Nếu đang bị khóa, cho phép mở ?>
                                <a href="_user_process.php?action=unblock&id=<?php echo $row['id']; ?>" class="users__action-link users__action-link--unblock" title="Mở khóa tài khoản">Mở khóa</a>
                            <?php endif; // Admin (role 1) sẽ không có hành động nào ?>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Không có người dùng nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>