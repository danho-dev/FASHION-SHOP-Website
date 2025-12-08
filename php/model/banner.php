<div class="container">
    <!-- Slider main container -->
    <div class="banner-slider swiper wow fadeIn">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php
            require_once("connect.php");
            $sql = "SELECT image FROM slides WHERE status=2";
            $result = mysqli_query($conn, $sql);
            while ($kq = mysqli_fetch_assoc($result)) {
            ?>
            <div class="swiper-slide">
                <img class="banner-slider__image" src="<?php echo "../../".$kq['image']; ?>" alt="Banner Image">
            </div>
            <?php } ?>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>