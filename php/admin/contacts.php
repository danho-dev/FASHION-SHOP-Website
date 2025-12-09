<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');
?>

<div class="contacts__container">
    <h1 class="contacts__header">Hòm thư Liên Hệ</h1>

    <table class="contacts__table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người Gửi</th>
                <th>Email</th>
                <th>Tiêu Đề</th>
                <th>Ngày Gửi</th>
                <th class="contacts__table-actions">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Thêm cột 'contents' vào câu truy vấn
            $sql = "SELECT id, name, email, title, contents, created FROM contacts ORDER BY created DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo date("d/m/Y H:i", strtotime($row['created'])); ?></td>
                        <td class="contacts__table-actions">
                            <button class="contacts__action-link js-view-contact" 
                                    data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                    data-content="<?php echo htmlspecialchars($row['contents']); ?>"
                                    title="Xem chi tiết">
                                Xem tin nhắn
                            </button>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Chưa có tin nhắn liên hệ nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal dùng chung để hiển thị nội dung -->
<div id="contactModal" class="contacts__modal">
    <div class="contacts__modal-content">
        <span class="contacts__modal-close">&times;</span>
        <h2 id="modalTitle" class="contacts__modal-title"></h2>
        <div id="modalBody" class="contacts__modal-body"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("contactModal");
    const viewButtons = document.querySelectorAll(".js-view-contact");
    const closeModal = document.querySelector(".contacts__modal-close");

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = this.dataset.title;
            document.getElementById('modalBody').innerHTML = this.dataset.content.replace(/\n/g, '<br>');
            modal.style.display = "block";
        });
    });

    closeModal.onclick = function() { modal.style.display = "none"; }

    window.onclick = function(event) {
        if (event.target == modal) { modal.style.display = "none"; }
    }
});
</script>