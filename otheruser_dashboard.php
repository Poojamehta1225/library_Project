
<?php

session_start();
//include("data_class.php");
$userloginid=$_SESSION["userid"] = $_GET['userlogid'];
// echo $_SESSION["userid"];

?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="css/styles.css"> 
    </head>

    <?php
   include("data_class.php");
    ?>
    <!--header.......................................-->
   <header class="header">
        <div class="logo">
            <img class="iglogo" src="images/logo1.png" alt="Library Logo">
        </div>
        <h1 id="changing-heading">Book Adda Digital Library</h1>
    </header>

<!-- Buttons....................-->
    <div class="actionPerform">
    <button class="user_greenbtn" onclick="openpart('myaccount')">
        <img src="images/icon/profile.png" width="20px" /> My Account
    </button>
    <button class="user_greenbtn" onclick="openpart('requestbook')">
        <img src="images/icon/book.png" width="20px" /> Request Book
    </button>
    <button class="user_greenbtn" onclick="openpart('issuereport')">
        <img src="images/icon/monitoring.png" width="20px" /> Book Report
    </button>
     <a href="feedback.php">
        <button class="user_greenbtn">
            <img src="images/icon/feedback.png" width="20px" /> Feedback
        </button>
    </a>
    <a href="index.php">
        <button class="user_greenbtn redbtn">
            <img src="images/icon/logout.png" width="20px" /> Logout
        </button>
    </a>
</div>
<div class="container mt-5">
    <h2 class="text-center">Welcome, User!</h2>
<!-- My Account Section -->
<div class="table-outer-wrapper portion" id="myaccount" style="display:none;">
  <div class="custom-table-container">
    <h5 style="text-align:center; padding: 15px 0;">My Account</h5>

    <?php
    $u = new data;
    $u->setconnection();
    $recordset = $u->userdetail($userloginid);
    foreach ($recordset as $row) {
        $name = $row[1];
        $email = $row[2];
        $type = $row[4];
    }
    ?>
    <table class="custom-table">
      <tr><th>Field</th><th>Details</th></tr>
      <tr><td><strong>Name:</strong></td><td><?= $name ?></td></tr>
      <tr><td><strong>Email:</strong></td><td><?= $email ?></td></tr>
      <tr><td><strong>Account Type:</strong></td><td><?= $type ?></td></tr>
    </table>
  </div>
</div>

<!-- Book Issue Report Section -->
<div class="table-outer-wrapper portion" id="requestbook" style="display:none;">
  <div class="custom-table-container">
    <h5 style="text-align:center; padding-top:10px;">Issued Books</h5>
    <?php
    $recordset = $u->getissuebook($userloginid);
    echo "<table class='custom-table'>
            <thead>
                <tr>
                    <th>Name</th><th>Book Name</th><th>Issue Date</th>
                    <th>Return Date</th><th>Fine</th><th>Return</th>
                </tr>
            </thead><tbody>";
    foreach($recordset as $row){
        echo "<tr>
            <td>{$row['issuename']}</td>
            <td>{$row['issuebook']}</td>
            <td>{$row['issuedate']}</td>
            <td>{$row['issuereturn']}</td>
            <td>₹{$row['fine']}</td>

            
            <td><a href='return_book.php?returnid={$row['id']}&userlogid=$userloginid'>
            <button class='btn btn-sm btn-primary'>Return</button></a></td>
        </tr>";
    }
    echo "</tbody></table>";
    ?>
  </div>

</div>
<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-info">
    <?php
    switch ($_GET['msg']) {
      case 'BookReturned':
        echo "✅ Book returned successfully.";
        break;
      case 'ReturnFailed':
        echo "❌ Failed to return book.";
        break;
      case 'PayFineFirst':
        echo "⚠️ You must pay the fine before returning this book.";
        break;
    }
    ?>
  </div>
<?php endif; ?>

<!-- Return Book (hidden action) -->
<?php
if (!empty($_REQUEST['returnid'])) {
    $returnid = $_REQUEST['returnid'];
    $u->returnbook($returnid);
}
?>

<!-- Request Book Section -->
<div class="table-outer-wrapper portion" id="issuereport" style="display:none;">
  <div class="custom-table-container">
    <h5 style="text-align:center; padding: 15px 0;">Request Book</h5>

    <!-- Search Bar -->
    <form method="POST" style="text-align:center; margin-bottom: 5px;">
      <input type="text" name="searchterm" class="form-control"
             placeholder="Search book..." style="max-width: 350px; display: inline-block;"
             value="<?= isset($_POST['searchterm']) ? htmlspecialchars($_POST['searchterm']) : '' ?>">
      <button type="submit" class="btn btn-info">🔍 Search</button>
    </form>

    <?php
    // Get records
    if (isset($_POST['searchterm'])) {
        $search = $_POST['searchterm'];
        $recordset = $u->searchBooks($search);
    } else {
        $recordset = $u->getbookissue();
    }

    // Display table
    echo "<table class='custom-table'>
            <thead>
              <tr>
                <th>Image</th><th>Book Name</th><th>Author</th>
                <th>Branch</th><th>Price</th><th>Request</th>
              </tr>
            </thead>
            <tbody>";

    foreach ($recordset as $row) {
        echo "<tr>
                <td><img src='uploads/{$row['bookpic']}' width='80'></td>
                <td>{$row['bookname']}</td>
                <td>{$row['bookaudor']}</td>
                <td>{$row['branch']}</td>
                <td>₹{$row['bookprice']}</td>
                <td><a href='requestbook.php?bookid={$row['id']}&userid=$userloginid'>
                  <button class='btn btn-sm btn-success'>Request</button>
                </a></td>
              </tr>";
    }

    echo "</tbody></table>";
    ?>
  </div>
</div>

  </div>

<script>
function openpart(portion) {
  const sections = document.getElementsByClassName("portion");
  for (let i = 0; i < sections.length; i++) {
    sections[i].style.display = "none";
  }
  document.getElementById(portion).style.display = "block";
}

// ✅ On page load, open 'myaccount' by default
window.onload = function () {
  openpart('myaccount');
};

</script>


</body>
<footer>
<?php include "footer.php"; ?>
</footer>
</html>

