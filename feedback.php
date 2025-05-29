<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background:rgb(183, 238, 177);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: white;
            margin: 60px auto;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;    
            color: darkgreen;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="submit"] {
            background:rgb(115, 181, 106);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background:rgb(150, 248, 114);
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
        }

        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Send Us Your Feedback</h2>

    <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<p class='success'>Thank you! Your feedback has been submitted.</p>";
        } elseif (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p class='error'>Please fill all fields.</p>";
        }
    ?>

    <form action="feedback_server.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>

        <input type="email" name="email" placeholder="Your Email" required>

        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

        <input type="submit" value="Submit Feedback">
    </form>
</div>

</body>
</html>
