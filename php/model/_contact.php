<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once 'connect.php';

    if (isset($_POST['sendcontact'])) 
    {
        $namect = $_POST['contact-name'];
        $emailct = $_POST['contact-email'];
        $subject = $_POST['contact-subject'];
        $contentct = $_POST['contact-content'];

        // Sử dụng Prepared Statement để bảo mật và tránh lỗi SQL Injection
        $sql = "INSERT INTO contacts(name, email, title, contents, created) VALUES(?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $namect, $emailct, $subject, $contentct);
        
        if (mysqli_stmt_execute($stmt)) 
        {
            header("location:contact.php?cs=success");
        } 
        else 
        {
            header("location:contact.php?cf=failed");
        }
    }
?>