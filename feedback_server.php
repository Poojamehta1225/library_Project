<?php
$host = "localhost";
$user = "root";         // change if not root
$password = "";         // add your DB password
$dbname = "library_management"; // change this to your actual DB name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);

// Send confirmation email (to admin or user)
$to = "mehtapooja38170@gmail.com"; // Replace with your email
$subject = "New Feedback Received";
$body = "Name: $name\nEmail: $email\nMessage:\n$message";
$headers = "From: noreply@yourdomain.com";

mail($to, $subject, $body, $headers);


if ($name != "" && $email != "" && $message != "") {
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        header("Location: feedback.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: feedback.php?error=1");
}

$conn->close();
?>
