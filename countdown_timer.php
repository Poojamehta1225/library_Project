<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header("Location: index.php");
    exit();
}

// Get issued books with return dates
$user_id = $_SESSION['user_id'];
$query = "SELECT issued_books.*, books.title FROM issued_books
          JOIN books ON books.id = issued_books.book_id
          WHERE issued_books.user_id = $user_id AND return_status = 'pending'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Countdown to Return</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
    function startCountdown(id, returnDate) {
        const countdownEl = document.getElementById('timer-' + id);
        const target = new Date(returnDate).getTime();

        const interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = target - now;

            if (diff <= 0) {
                countdownEl.innerHTML = "❗ Due Today or Overdue";
                clearInterval(interval);
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            countdownEl.innerHTML = `${days}d ${hours}h ${minutes}m left`;
        }, 1000);
    }
    </script>
</head>
<body>
    <div class="container">
        <h2>Your Book Return Countdown</h2>

        <table>
            <tr>
                <th>Book</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Countdown</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['issue_date'] ?></td>
                    <td><?= $row['return_date'] ?></td>
                    <td id="timer-<?= $row['id'] ?>">Loading...</td>
                </tr>

                <script>
                    startCountdown(<?= $row['id'] ?>, "<?= $row['return_date'] ?>");
                </script>
            <?php } ?>
        </table>

        <a href="otheruser_dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
