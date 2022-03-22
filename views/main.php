<?php

session_start();

    require_once '../app/helpers/Database.php';
    $dataBase = new Database();

    if (!$dataBase->isUserLogged()){
        header("Location: login.php");die;
    }

$results = $dataBase->getResults();



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Ip address</th>
                    <th>Button ID</th>
                    <th>Count of clicks</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = $results->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['Y']?></td>
                    <td><?php echo $row['M']?></td>
                    <td><?php echo $row['user_ip']?></td>
                    <td><?php echo $row['button_id']?></td>
                    <td><?php echo $row['clicks']?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <a href="logout.php">
        logout
    </a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>