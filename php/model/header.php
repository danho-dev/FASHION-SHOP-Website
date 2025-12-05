<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once('connect.php');
    $prd = 0;
    if (isset($_SESSION['cart']))
    {
        $prd = count($_SESSION['cart']);
    }

    if (isset($_GET['ls'])) {
        echo "<script type=\"text/javascript\">alert(\"Bạn đã đăng nhập thành công!\");</script>";
    }
?>

<header>
    <div class="header__top-banner wow bounceIn" data-wow-delay="0.1s">
        <div class="header__social-links-column">
            <div class="header__social-links">
                <a href="https://www.facebook.com/" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>
                <a href="https://twitter.com/" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a>
                <a href="https://www.rss.com/" target="_blank" title="rss"><i class="fa fa-rss"></i></a>
                <a href="https://www.youtube.com/" target="_blank" title="youtube"><i class="fa fa-youtube"></i></a>
                <a href="https://plus.google.com/" target="_blank" title="google"><i class="fa fa-google-plus"></i></a>
                <a href="https://linkedin.com/" target="_blank" title="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
        <div class="header__clearfix"></div>
    </div>
    <div class="header__main-container site-container">
        <div class="header__logo">
            <a href="index.php" title="MyLiShop"> <img src="../../images/logohong.png"> </a>
        </div>
        <div class="header__account-section">
            <div class="header__account-info-row">
                <?php
                    if(isset($_SESSION['username']))
                    {
                ?>
                <i class="fa fa-user fa-lg"></i>
                <span><?php echo $_SESSION['username']?></span> &nbsp;
                <span><i class="fa fa-sign-out"></i><a href="user/logout.php"> Đăng xuất </a></span>
                <?php   }
                    else {
            ?>
                <i class="fa fa-user fa-lg"></i>
                <a href="user/login.php"> Đăng nhập </a> &nbsp;
                <i class="fa fa-users fa-lg"></i>
                <a href="user/register.php"> Đăng ký </a>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="header__clearfix-div"></div>

        <nav class="header__navbar" role="navigation">
            <div class="header__navbar-container">
                <div class="header__navbar-mobile-header">
                    <button type="button" class="header__navbar-mobile-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1"> <span class="header__screen-reader-only">Toggle navigation</span>
                        <span class="header__navbar-toggle-icon-bar"></span> <span class="header__navbar-toggle-icon-bar"></span> <span class="header__navbar-toggle-icon-bar"></span>
                    </button>
                </div>
                <div class="header__navbar-collapsible-menu" id="bs-example-navbar-collapse-1">
                    <ul class="header__navbar-links">
                        <li><a href="index.php"> Trang Chủ </a>
                        </li>
                        <li><a href="introduceshop.php"> Dịch Vụ </a>
                        </li>
                        <li class="header__navbar-dropdown"> <a href="#" class="header__navbar-dropdown-toggle" data-toggle="dropdown">Sản Phẩm <b
                                    class="fa fa-caret-down"></b></a>
                            <ul class="header__navbar-dropdown-menu">
                                <li><a href="fashionboy.php"><i class="fa fa-caret-right"></i> Thời Trang Nam</a>
                                </li>
                                <li class="header__navbar-dropdown-divider"></li>
                                <li><a href="fashiongirl.php"><i class="fa fa-caret-right"></i> Thời Trang Nữ</a>
                                </li>
                                <li class="header__navbar-dropdown-divider"></li>
                                <li><a href="newproduct.php"><i class="fa fa-caret-right"></i> Hàng Mới Về</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="lienhe.php"> Liên Hệ </a>
                        </li>
                    </ul>
                    <ul class="header__navbar-links-right">
                        <form role="search" action="search.php" method="POST">
                            <div class="header__search-group">
                                <input type="text" maxlength="50" name="search" id="searchs" class="header__search-input"
                                    placeholder="Nhập từ khóa..." style="font-size: 14px;">
                                <button class="header__search-button" type="submit"><span
                                            class="fa fa-search"></span></button>
                            </div>
                            <div class="header__cart-total">
                                <a class="header__cart-background" href="view-cart.php" title="Giỏ hàng">
                                    <button type="button" class="header__cart-button">
                                        <span class="fa fa-shopping-cart"></span>&nbsp;
                                        <span id="cart-total">
                                            <?php
                                                if(isset($_SESSION['cart']))
                                                {
                                                    $cart = $_SESSION['cart'];
                                                    $sl = count($_SESSION['cart']);
                                                    echo $sl;
                                                }
                                                else {
                                                    echo "0";
                                                }
                                            ?>
                                        </span> sản phẩm
                                    </button>
                                </a>
                                <div class="header__mini-cart">

                                </div>
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>