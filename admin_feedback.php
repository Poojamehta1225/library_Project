<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "library_management"; // Replace with your DB

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Feedback Panel</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #667eea;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

<h2>All Feedback Submissions</h2>

<table>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Submitted At</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        $sn = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$sn}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['message']}</td>
                    <td>{$row['submitted_at']}</td>
                </tr>";
            $sn++;
        }
    } else {
        echo "<tr><td colspan='5'>No feedback found</td></tr>";
    }
    ?>
</table>

</body>
</html>
