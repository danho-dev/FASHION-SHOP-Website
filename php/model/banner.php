<div class="container">
    <div class="banner-grid">
        <div class="banner-grid__header">
            <h3 class="banner-grid__title">BANNER</h3>
        </div>
        <div class="banner-grid__items">
            <?php
            // Không cần require_once('connect.php') nữa nếu đã có ở index.php
            // Lấy 4 ảnh từ bảng slides với status = 2. Bỏ cột 'link' vì nó không tồn tại.
            $sql_banner = "SELECT image FROM slides WHERE status = 2 LIMIT 4";
            $result_banner = mysqli_query($conn, $sql_banner);
            if (mysqli_num_rows($result_banner) > 0) {
                while ($row_banner = mysqli_fetch_assoc($result_banner)) {
            ?>
                    <div class="banner-grid__item">
                        
                        <img class="banner-grid__image" src="<?php echo "../../" . htmlspecialchars($row_banner['image']); ?>" alt="Banner quảng cáo">
                        
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>
