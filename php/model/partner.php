<div class="container">
    <section class="partner">
        <div class="partner__header">
            <h3 class="partner__title">Đối tác của chúng tôi</h3>
        </div>
        <div class="partner__grid">
            <?php
            $sql_partner = "SELECT image FROM slides WHERE status = 3";
            $result_partner = mysqli_query($conn, $sql_partner);
            while ($kq_partner = mysqli_fetch_assoc($result_partner)) {
            ?>
                <div class="partner__item">
                    <img class="partner__image" src="<?php echo "../../" . $kq_partner['image']; ?>" alt="Logo đối tác">
                </div>
            <?php } ?>
        </div>
    </section>
</div>