<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css/styles.css">
 
</head>

<body>

<!-- Header Start -->
 <header class="header">
        <div class="logo">
            <img class="iglogo" src="images/logo1.png" alt="Library Logo">
        </div>
        <h1 id="changing-heading">Book Adda Digital Library</h1>
    </header>
<!-- Header End -->

<?php
$emailmsg = $pasdmsg = $msg = $ademailmsg = $adpasdmsg = "";

if (!empty($_REQUEST['ademailmsg'])) { $ademailmsg = $_REQUEST['ademailmsg']; }
if (!empty($_REQUEST['adpasdmsg'])) { $adpasdmsg = $_REQUEST['adpasdmsg']; }
if (!empty($_REQUEST['emailmsg'])) { $emailmsg = $_REQUEST['emailmsg']; }
if (!empty($_REQUEST['pasdmsg'])) { $pasdmsg = $_REQUEST['pasdmsg']; }
if (!empty($_REQUEST['msg'])) { $msg = $_REQUEST['msg']; }
?>

<div class="container login-container">

    <?php if(!empty($msg)): ?>
    <div class="alert-message">
        <h4><?php echo $msg; ?></h4>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Admin Login -->
        <div class="login-form login-form-3">
            <h3>Admin Login</h3>
            <form action="loginadmin_server_page.php" method="get">
                <label class="error-label">*<?php echo $ademailmsg ?></label>
                <input type="text" class="form-control" name="login_email" placeholder="Your Email *" required />

                <label class="error-label">*<?php echo $adpasdmsg ?></label>
                <input type="password" class="form-control" name="login_pasword" placeholder="Your Password *" required />

                <input type="submit" class="btnSubmit" value="Login" />
            </form>
        </div>

        <!-- Student Login -->
        <div class="login-form login-form-1">
            <h3>Student Login</h3>
            <form action="login_server_page.php" method="get">
                <label class="error-label">*<?php echo $emailmsg ?></label>
                <input type="text" class="form-control" name="login_email" placeholder="Your Email *" required />

                <label class="error-label">*<?php echo $pasdmsg ?></label>
                <input type="password" class="form-control" name="login_pasword" placeholder="Your Password *" required />

                <input type="submit" class="btnSubmit" value="Login" />
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>
