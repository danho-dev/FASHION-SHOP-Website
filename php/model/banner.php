<div class="banner-section container-fluid wow lightSpeedIn">
    <div class="banner-section__content">
        <div class="banner-section__row row">
            <?php
            echo "<h3 class='banner-section__title text-center'>BANNER- PNV 27</h3>";
            require_once("connect.php");
            $sql = "SELECT image FROM slides WHERE status=2";
            $result = mysqli_query($conn, $sql);

            while ($kq = mysqli_fetch_assoc($result)) {
            ?>
                <div class="banner-section__item col-md-3 col-sm-4">
                    <div class="banner-section__item-thumbnail">
                        <div class="banner-section__image-wrapper">
                            <img class="banner-section__image" src="<?php echo "../../".$kq['image']; ?>" alt="Generic placeholder thumbnail" width="100%"
                                height="160">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>