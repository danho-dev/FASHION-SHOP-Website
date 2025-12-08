<?php
require_once('connect.php');
$prd = 0;
if (isset($_SESSION['cart'])) {
    $prd = count($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FASHION SHOP | Website bán quần áo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='../../js/wow.js'></script>
    <script type="text/javascript" src="../../js/mylishop.js"></script>
</head>

<body>
    <!-- <a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a> -->

    <?php 
    include("header.php");
    include("banner.php");
    ?>