<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's notifications
$query = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <h2>Your Notifications</h2>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <p>No notifications at the moment.</p>
    <?php else: ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li>
                    📩 <?= $row['message'] ?> <br>
                    <small><i><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></i></small>
                    <hr>
                </li>
            <?php } ?>
        </ul>
    <?php endif; ?>

    <a href="otheruser_dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
