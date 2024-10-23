<?php
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Database connection
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "eventmanagement";
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch user details and events
    $query = "SELECT r.Name, e.Event, e.Date 
              FROM register r
              JOIN eventhistory e ON r.Id = e.UID
              WHERE r.Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $userDetails = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_close($conn);

        $name = $userDetails[0]['Name'];

        // Prepare email body with multiple events
        $eventsHtml = "<ul>";
        foreach ($userDetails as $details) {
            //$eventsHtml .= "<li><strong>Event:</strong> " . htmlspecialchars($details['Event']) . " - <strong>Date:</strong> " . htmlspecialchars($details['Date']) . "</li>";
            $eventsHtml .= "<li><strong>Date:</strong> " . htmlspecialchars($details['Date']) . " - <strong>Event:</strong> " . htmlspecialchars($details['Event']) . "</li>";
       

	   }
        $eventsHtml .= "</ul>";

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP(); 
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true; 
            $mail->Username = 'dhanushmpanruti@gmail.com'; 
            $mail->Password = 'dnsi gplm wluh cbmo'; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 

            // Recipients
            $mail->setFrom('dhanushmpanruti@gmail.com', 'Event Management');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Hi $name, Your event registrations are confirmed";
            $mail->Body    = "Hello $name,<br><br>We are excited to confirm your participation in the following events:<br>$eventsHtml<br>Best regards,<br>Event Management Team";

            $mail->send();
            echo 'Email sent successfully';
        } catch (Exception $e) {
            echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        mysqli_close($conn);
        echo "No events found for the provided email.";
    }
} else {
    echo "Invalid request";
}
?>
