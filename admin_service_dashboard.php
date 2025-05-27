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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <link rel="stylesheet" href="css/styles.css">
    </head>
    <body >

    <?php
    //.......temp for now
    session_start();
    echo 'User ID: ' . $_SESSION['userid'] . '<br>';
    echo 'Role: ' . $_SESSION['role'] . '<br>';
    //
   include("data_class.php");

$msg = "";

if (!empty($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
}
?>

<?php if ($msg == "done"): ?>
    <div class="alert alert-success" role="alert" id="alertBox">Successfully Done</div>
<?php elseif ($msg == "fail"): ?>
    <div class="alert alert-danger" role="alert" id="alertBox">Fail</div>
<?php endif; ?>
<!-- Page Heading -->
    <h1 class="head">BookAdda Digital Library <img  class="h-img" src="images/logo1.png" alt="logo"></h1>

<div class="container">
<!-- Toggle Button for Mobile View -->
<div class="sidebar-toggle" onclick="toggleSidebar()">☰ Menu</div>


<div class="sidebar" id="sidebar">
    <button class="greenbtn" onclick="openpart('addbook')">
        <img class="icons" src="images/icon/book.png" /> ADD BOOK
    </button>
    <button class="greenbtn" onclick="openpart('bookreport')">
        <img class="icons" src="images/icon/open-book.png" /> BOOK REPORT
    </button>
    <button class="greenbtn" onclick="openpart('bookrequestapprove')">
        <img class="icons" src="images/icon/interview.png" /> BOOK REQUESTS
    </button>
    <button class="greenbtn" onclick="openpart('addperson')">
        <img class="icons" src="images/icon/add-user.png" /> ADD STUDENT
    </button>
    <button class="greenbtn" onclick="openpart('studentrecord')">
        <img class="icons" src="images/icon/monitoring.png" /> STUDENT REPORT
    </button>
    <button class="greenbtn" onclick="openpart('issuebook')">
        <img class="icons" src="images/icon/test.png" /> ISSUE BOOK
    </button>
    <button class="greenbtn" onclick="openpart('issuebookreport')">
        <img class="icons" src="images/icon/checklist.png" /> ISSUE REPORT
    </button>
    <a href="index.php">
        <button class="greenbtn">
            <img class="icons" src="images/icon/book.png" /> LOGOUT
        </button>
    </a>
</div>
<!-- ADMIN RIGHT SIDE--> 
            <div class="rightinnerdiv">   
            <div id="bookrequestapprove" class="inerright portion" style="display:none">
            <Button class="greenbtn" >BOOK REQUEST APPROVE</Button>

            <?php
            $u=new data;
            $u->setconnection();
            $u->requestbookdata();
            $recordset=$u->requestbookdata();

            $table="<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'><tr><th style='
            padding: 8px;'>Person Name</th><th>person type</th><th>Book name</th><th>Days </th><th>Approve</th></tr>";
            foreach($recordset as $row){
                $table.="<tr>";
               "<td>$row[0]</td>";
              "<td>$row[1]</td>";
              "<td>$row[2]</td>";

                $table.="<td>$row[3]</td>";
                $table.="<td>$row[4]</td>";
                $table.="<td>$row[5]</td>";
                $table.="<td>$row[6]</td>";
               // $table.="<td><a href='approvebookrequest.php?reqid=$row[0]&book=$row[5]&userselect=$row[3]&days=$row[6]'><button type='button' class='btn btn-primary'>Approved BOOK</button></a></td>";
                 $table.="<td><a href='approvebookrequest.php?reqid=$row[0]&book=$row[5]&userselect=$row[3]&days=$row[6]'><button type='button' class='btn btn-primary'>Approved</button></a></td>";
                // $table.="<td><a href='deletebook_dashboard.php?deletebookid=$row[0]'>Delete</a></td>";
                $table.="</tr>";
                // $table.=$row[0];
            }
            $table.="</table>";

            echo $table;
            ?>

            </div>
            </div>

            <div class="rightinnerdiv">   
            <div id="addbook" class="inerright portion" style="<?php  if(!empty($_REQUEST['viewid'])){ echo "display:none";} else {echo ""; }?>">
            <Button class="greenbtn" >ADD NEW BOOK</Button>
            <br>
            <form action="addbookserver_page.php" method="post" enctype="multipart/form-data">
            <label>Book Name:</label><input type="text"name="bookname"/>
            </br>
            <label>Detail:</label><input  type="text" name="bookdetail"/></br>
            <label>Autor:</label><input type="text" name="bookaudor"/></br>
            <label>Publication</label><input type="text" name="bookpub"/></br>
            <div><label>Branch:</label><input type="radio" name="branch" value="other"/>Other<input type="radio" name="branch" value="CSE"/>CSE<div style="margin-left:80px"><input type="radio" name="branch" value="ME"/>BE<input type="radio" name="branch" value="CA"/>CA</div>
            </div>   
            <label>Price:</label><input  type="number" name="bookprice"/></br>
            <label>Quantity:</label><input type="number" name="bookquantity"/></br>
            <label>Book Photo</label><input  type="file" name="bookphoto"/></br>
            </br>
   
            <input type="submit" value="SUBMIT"/>
            </br>
            </br>

            </form>
            </div>
            </div>


            <div class="rightinnerdiv">   
            <div id="addperson" class="inerright portion" style="display:none">
            <Button class="greenbtn" >ADD Person</Button>
            <form action="addpersonserver_page.php" method="post" enctype="multipart/form-data">
            <label>Name:</label><input type="text" name="addname"/>
            </br>
            <label>Pasword:</label><input type="pasword" name="addpass"/>
            </br>
            <label>Email:</label><input  type="email" name="addemail"/></br>
            <label for="typw">Choose type:</label>
            <select name="type" >
                <option value="student">student</option>
                <option value="teacher">teacher</option>
            </select>

            <input type="submit" value="SUBMIT"/>
            </form>
            </div>
            </div>

            <div class="rightinnerdiv">   
            <div id="studentrecord" class="inerright portion" style="display:none">
            <Button class="greenbtn" >Student RECORD</Button>

            <?php
            $u=new data;
            $u->setconnection();
            $u->userdata();
            $recordset=$u->userdata();

            $table="<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'><tr><th style=' 
            padding: 8px;'> Name</th><th>Email</th><th>Type</th></tr>";
            foreach($recordset as $row){
                $table.="<tr>";
               "<td>$row[0]</td>";
                $table.="<td>$row[1]</td>";
                $table.="<td>$row[2]</td>";
                $table.="<td>$row[4]</td>";
                // $table.="<td><a href='deleteuser.php?useriddelete=$row[0]'>Delete</a></td>";
                $table.="</tr>";
                // $table.=$row[0];
            }
            $table.="</table>";

            echo $table;
            ?>

            </div>
            </div>

            <div class="rightinnerdiv">   
            <div id="issuebookreport" class="inerright portion" style="display:none">
            <Button class="greenbtn" >Issue Book Record</Button>

            <?php
            $u=new data;
            $u->setconnection();
            $u->issuereport();
            $recordset=$u->issuereport();

            $table="<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'><tr><th style='  
            padding: 8px;'>Issue Name</th><th>Book Name</th><th>Issue Date</th><th>Return Date</th><th>Fine</th></th><th>Issue Type</th></tr>";

            foreach($recordset as $row){
                $table.="<tr>";
               "<td>$row[0]</td>";
                $table.="<td>$row[2]</td>";
                $table.="<td>$row[3]</td>";
                $table.="<td>$row[6]</td>";
                $table.="<td>$row[7]</td>";
                $table.="<td>$row[8]</td>";
                $table.="<td>$row[4]</td>";
                // $table.="<td><a href='otheruser_dashboard.php?returnid=$row[0]&userlogid=$userloginid'>Return</a></td>";
                $table.="</tr>";
                // $table.=$row[0];
            }
            $table.="</table>";

            echo $table;
            ?>

            </div>
            </div>

<!--             

issue book -->
            <div class="rightinnerdiv">   
            <div id="issuebook" class="inerright portion" style="display:none">
            <Button class="greenbtn" >ISSUE BOOK</Button>
            <form action="issuebook_server.php" method="post" enctype="multipart/form-data">
            <label for="book">Choose Book:</label>
           
            <select name="book" >
            <?php
            $u=new data;
            $u->setconnection();
            $u->getbookissue();
            $recordset=$u->getbookissue();
            foreach($recordset as $row){

                echo "<option value='". $row[2] ."'>" .$row[2] ."</option>";
        
            }            
            ?>
            </select>
<br>
            <label for="Select Student">Select Student:</label>
            <select name="userselect" >
            <?php
            $u=new data;
            $u->setconnection();
            $u->userdata();
            $recordset=$u->userdata();
            foreach($recordset as $row){
               $id= $row[0];
                echo "<option value='". $row[1] ."'>" .$row[1] ."</option>";
            }            
            ?>
            </select>
<br>
           <label>Days</label> <input type="number" name="days"/>

            <input type="submit" value="SUBMIT"/>
            </form>
            </div>
            </div>

            <div class="rightinnerdiv">   
            <div id="bookdetail" class="portion" style="<?php  if(!empty($_REQUEST['viewid'])){ $viewid=$_REQUEST['viewid'];} else {echo "display:none"; }?>">
            
            <Button class="greenbtn" >BOOK DETAIL</Button>
</br>
<?php
            $u=new data;
            $u->setconnection();
            $u->getbookdetail($viewid);
            $recordset=$u->getbookdetail($viewid);
            foreach($recordset as $row){

                $bookid= $row[0];
               $bookimg= $row[1];
               $bookname= $row[2];
               $bookdetail= $row[3];
               $bookauthour= $row[4];
               $bookpub= $row[5];
               $branch= $row[6];
               $bookprice= $row[7];
               $bookquantity= $row[8];
               $bookava= $row[9];
               $bookrent= $row[10];

            }            
?>

            <img width='150px' height='150px' style='border:1px solid #333333; float:left;margin-left:20px' src="uploads/<?php echo $bookimg?> "/>
            </br>
            <p style="color:black"><u>Book Name:</u> &nbsp&nbsp<?php echo $bookname ?></p>
            <p style="color:black"><u>Book Detail:</u> &nbsp&nbsp<?php echo $bookdetail ?></p>
            <p style="color:black"><u>Book Authour:</u> &nbsp&nbsp<?php echo $bookauthour ?></p>
            <p style="color:black"><u>Book Publisher:</u> &nbsp&nbsp<?php echo $bookpub ?></p>
            <p style="color:black"><u>Book Branch:</u> &nbsp&nbsp<?php echo $branch ?></p>
            <p style="color:black"><u>Book Price:</u> &nbsp&nbsp<?php echo $bookprice ?></p>
            <p style="color:black"><u>Book Available:</u> &nbsp&nbsp<?php echo $bookava ?></p>
            <p style="color:black"><u>Book Rent:</u> &nbsp&nbsp<?php echo $bookrent ?></p>


            </div>
            </div>



           <!-- BOOK REPORT -->
<div class="rightinnerdiv">
    <div id="bookreport" class="portion" style="<?php echo empty($_REQUEST['viewid']) ? '' : 'display:none'; ?>">
        <button class="greenbtn">BOOK REPORT</button><br />
        <?php
        $u = new data;
        $u->setconnection();
        $recordset = $u->getbook();

        echo "<table><tr>
                <th>Book Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>View Book</th>
              </tr>";
        foreach ($recordset as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row[2]) . "</td>";
            echo "<td>" . htmlspecialchars($row[7]) . "</td>";
            echo "<td>" . htmlspecialchars($row[8]) . "</td>";
            echo "<td><a href='admin_service_dashboard.php?viewid=" . urlencode($row[0]) . "'><button type='button'>View Book</button></a></td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
</div>

<!-- BOOK DETAIL -->
<div class="rightinnerdiv">
    <div id="bookdetail" class="portion" style="<?php echo !empty($_REQUEST['viewid']) ? '' : 'display:none'; ?>">
        <button class="greenbtn">BOOK DETAIL</button><br />
        <?php
        if (!empty($_REQUEST['viewid'])) {
            $viewid = $_REQUEST['viewid'];
            $u = new data;
            $u->setconnection();
            $recordset = $u->getbookdetail($viewid);
            if ($recordset) {
                foreach ($recordset as $row) {
                    $bookimg = $row[1];
                    $bookname = $row[2];
                    $bookdetail = $row[3];
                    $bookauthour = $row[4];
                    $bookpub = $row[5];
                    $branch = $row[6];
                    $bookprice = $row[7];
                    $bookava = $row[9];
                    $bookrent = $row[10];
                }
                echo "<img width='150px' height='150px' style='border:1px solid #333; float:left; margin-left:20px;' src='uploads/" . htmlspecialchars($bookimg) . "' alt='Book Image' />";
                echo "<p><u>Book Name:</u> " . htmlspecialchars($bookname) . "</p>";
                echo "<p><u>Book Detail:</u> " . htmlspecialchars($bookdetail) . "</p>";
                echo "<p><u>Book Author:</u> " . htmlspecialchars($bookauthour) . "</p>";
                echo "<p><u>Book Publisher:</u> " . htmlspecialchars($bookpub) . "</p>";
                echo "<p><u>Book Branch:</u> " . htmlspecialchars($branch) . "</p>";
                echo "<p><u>Book Price:</u> " . htmlspecialchars($bookprice) . "</p>";
                echo "<p><u>Book Available:</u> " . htmlspecialchars($bookava) . "</p>";
                echo "<p><u>Book Rent:</u> " . htmlspecialchars($bookrent) . "</p>";
            } else {
                echo "<p>No book found with this ID.</p>";
            }
        }
        ?>
    </div>
</div>

        </div>
        
     
        <script>
        function openpart(portion) {
        var i;
        var x = document.getElementsByClassName("portion");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        document.getElementById(portion).style.display = "block";  
        }
    // Auto hide the alert after 5 seconds
    setTimeout(function() {
        var alertBox = document.getElementById('alertBox');
        if (alertBox) {
            alertBox.style.display = 'none';
        }
    }, 5000);


    function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("open");
        }


        </script>
      <!--  <footer>
        <h4>Download Reports:</h4>
<a href="generate_reports.php?type=issued_books" target="_blank"><button class="btn btn-info">📚 Issued Books</button></a>
<a href="generate_reports.php?type=returned_books" target="_blank"><button class="btn btn-success">📦 Returned Books</button></a>
<a href="generate_reports.php?type=overdue_books" target="_blank"><button class="btn btn-warning">⏳ Overdue Books</button></a>
<a href="generate_reports.php?type=fine_report" target="_blank"><button class="btn btn-danger">💰 Fine Report</button></a>

        </footer>-->
        
    </body>
</html>