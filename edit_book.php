<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$msg = "";

// If form is submitted
if (isset($_POST['update'])) {
    $book_id = intval($_POST['book_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = intval($_POST['quantity']);

    if ($title != "" && $author != "" && $category != "" && $quantity > 0) {
        $query = "UPDATE books SET 
                  title='$title', 
                  author='$author', 
                  category='$category', 
                  quantity='$quantity'
                  WHERE id=$book_id";
        if (mysqli_query($conn, $query)) {
            $msg = "Book updated successfully!";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $msg = "Please fill all fields correctly.";
    }
}

// If edit button clicked
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id = $id"));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Book Details</h2>

        <?php if ($msg != "") echo "<p class='success'>$msg</p>"; ?>

        <?php if (isset($book)) { ?>
        <form method="POST">
            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

            <label>Title:</label>
            <input type="text" name="title" value="<?= $book['title'] ?>" required>

            <label>Author:</label>
            <input type="text" name="author" value="<?= $book['author'] ?>" required>

            <label>Category:</label>
            <input type="text" name="category" value="<?= $book['category'] ?>" required>

            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?= $book['quantity'] ?>" min="1" required>

            <button type="submit" name="update">Update Book</button>
        </form>
        <?php } else { ?>
            <p class="error">Invalid book ID</p>
        <?php } ?>

        <a href="admin_service_dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
