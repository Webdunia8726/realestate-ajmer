<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer autoload (Composer se install kiya hai to)
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form fields ko retrieve karna (sanitize and trim to avoid extra spaces)
    $name = htmlspecialchars(trim($_POST['name']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $email = htmlspecialchars(trim($_POST['email']));

    // PHPMailer ka instance banaiye
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'connect.invesco@gmail.com'; // Aapka Gmail address
        $mail->Password = 'pmrc tbmh qfwi vnfh'; // Gmail password ya App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and receiver settings
        $mail->setFrom('connect.invesco@gmail.com', 'realestate'); // Sender email
        $mail->addAddress('connect.invesco@gmail.com'); // Receiver email

        // Email content (HTML)
        $mail->isHTML(true);
        $mail->Subject = 'New Enquiry Received';
        $mail->Body = "
            <h1>Enquiry Details</h1>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Mobile:</strong> $mobile</p>
            <p><strong>Email:</strong> $email</p>
        ";

        // Send email
        $mail->send();

        // Redirect to thank-you page
        header('Location: thank-you.html'); // Thank-You page ka URL
        exit; // Ensure further code execution stops after redirect
    } catch (Exception $e) {
        // In case of error, display error message
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
