
<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$msg = "";

// On Issue Submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userselect = intval($_POST['userselect']);
    $book= intval($_POST['book']);
    $issue_date = date("d/m/Y");
    $return_date = date("d/m/Y", strtotime("+7 days"));

    // Check book quantity
    $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity FROM books WHERE id=$book_id"));
    if ($book['quantity'] > 0) {
        // Insert into issued_books
        $query = "INSERT INTO issued_books (user_id, book_id, issue_date, return_date) 
                  VALUES ($user_id, $book_id, '$issue_date', '$return_date')";
        mysqli_query($conn, $query);

        // Decrease book quantity
        mysqli_query($conn, "UPDATE books SET quantity = quantity - 1 WHERE id=$book_id");

        $msg = "Book issued successfully!";
    } else {
        $msg = "Book is not available!";
    }
}

// Fetch users & books
$users = mysqli_query($conn, "SELECT id, name FROM users WHERE role='user'");
$books = mysqli_query($conn, "SELECT id, title FROM books WHERE quantity > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <h2>Issue Book to User</h2>

    <?php if ($msg != "") echo "<p class='success'>$msg</p>"; ?>

    <form method="POST">
        <label>Select User:</label>
        <select name="user_id" required>
            <option value="">-- Select User --</option>
            <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
            <?php } ?>
        </select>

        <label>Select Book:</label>
        <select name="book_id" required>
            <option value="">-- Select Book --</option>
            <?php while ($b = mysqli_fetch_assoc($books)) { ?>
                <option value="<?= $b['id'] ?>"><?= $b['title'] ?></option>
            <?php } ?>
        </select>

        <button type="submit">Issue Book</button>
    </form>

    <a href="admin_service_dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
