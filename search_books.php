<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header("Location: ../auth/index.php");
    exit();
}

$search = "";
$result = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM books 
              WHERE title LIKE '%$search%' 
              OR author LIKE '%$search%' 
              OR category LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Books</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <h2>Search Books</h2>

    <form method="POST">
        <input type="text" name="search" placeholder="Search by title, author, category" value="<?= $search ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($search != ""): ?>
        <h3>Search Results for: "<?= htmlspecialchars($search) ?>"</h3>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Available</th>
                </tr>
                <?php while ($book = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['category'] ?></td>
                        <td><?= $book['quantity'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php else: ?>
            <p>No books found matching your search.</p>
        <?php endif; ?>
    <?php endif; ?>

    <a href="otheruser_dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
