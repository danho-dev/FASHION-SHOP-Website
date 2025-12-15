<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load thủ công các file thư viện PHPMailer
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

function sendEmail($to, $name, $subject, $content) {
    $mail = new PHPMailer(true);
    try {
        // --- Cấu hình Server (Ví dụ dùng Gmail) ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        
        // TODO: Nên chuyển credentials vào biến môi trường (.env) hoặc file config riêng
        // Ví dụ: $mail->Username = getenv('MAIL_USERNAME');
        $mail->Username   = 'st.anhdan09@gmail.com';
        $mail->Password   = 'knao mqbi lglf lokn';
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // --- Người gửi và Người nhận ---
        $mail->setFrom('st.anhdan09@gmail.com', 'FASHION SHOP'); 
        $mail->addAddress($to, $name);                          

        // --- Nội dung ---
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Hiển thị lỗi trực tiếp ra màn hình thay vì ghi vào log ẩn
        echo "<b>Lỗi gửi mail chi tiết:</b> " . $mail->ErrorInfo;
        return false;
    }
}
?>