<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (!$name || !$email || !$subject || !$message) {
        http_response_code(400);
        echo json_encode(["error" => "All fields are required."]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kamblesurajbalaji@gmail.com'; // your Gmail
        $mail->Password = 'Suraj@kamble12345';   // your App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email details
        $mail->setFrom($email, $name);
        $mail->addAddress('kamblesurajbalaji@gmail.com'); // your Gmail again

        $mail->Subject = $subject;
        $mail->Body    = "From: $name <$email>\n\n$message";
        $mail->isHTML(false);

        $mail->send();
        echo json_encode(["success" => "Your message has been sent."]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error: " . $mail->ErrorInfo]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
