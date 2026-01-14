<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = "your@email.com";  // Your email
    $subject = "New Contact Form Submission";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare the attachment if exists
    $file_attached = false;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_name = $_FILES['attachment']['name'];
        $file_type = $_FILES['attachment']['type'];
        $file_content = chunk_split(base64_encode(file_get_contents($file_tmp)));
        $file_attached = true;

        $boundary = md5(time());
        $headers = "From: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n\r\n";

        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= "Name: $name<br>Email: $email<br>Message:<br>" . nl2br(htmlspecialchars($message)) . "\r\n";

        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: {$file_type}; name=\"{$file_name}\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"{$file_name}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $file_content . "\r\n";
        $body .= "--{$boundary}--";
    } else {
        $headers = "From: $email\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $body = "Name: $name<br>Email: $email<br>Message:<br>" . nl2br(htmlspecialchars($message));
    }

    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message.";
    }
}
?>
