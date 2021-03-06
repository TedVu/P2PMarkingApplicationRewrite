<?php
if (empty($_COOKIE['auth'])) {
    header("Location: ./login.php");
}

# Create connection to gcloud datastore (NoSQL db) 
$servername = "localhost";
$username = "root";
$password = "4658GB!rQb7yr_33";
$dbname = "p2pmarking";
$conn = new mysqli($servername, $username, $password, $dbname);

$err = '';
$email = $_COOKIE['auth'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['newpwd']) || empty($_POST['oldpwd'])) {
        $err = '<small class="form-text text-danger">New Password and Old Password cannot be empty.</small>';
    } else {
        $sql = "SELECT * from users WHERE email = '{$email}' and Password = '{$_POST['oldpwd']}'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sql = "UPDATE `p2pmarking`.`users` SET `Password` = '{$_POST['newpwd']}' WHERE (`email` = '{$email}');";
            echo $sql;
            $conn -> query($sql);
            $conn -> close();
            header("Location: ./main.php");
        } else {
            $err = '<small class="form-text text-danger">Old Password is wrong.</small>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="Peer-to-Peer marking system thats empower teachers.">
    <title>P2P Marking System</title>
    <link rel="shortcut icon" href="/favicon.svg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="bg-light">
    <form action="./password.php" class="container-sm py-4 my-5 bg-dark text-white rounded-lg" method="POST">
        <div class="form-group">
            <label for="oldpwd">Old Password</label>
            <input id="oldpwd" type="text" class="form-control" placeholder="Enter old Password" name="oldpwd">
            <?php echo $err ?>
        </div>
        <div class="form-group">
            <label for="newpwd">New Password</label>
            <input id="newpwd" type="text" class="form-control" placeholder="Enter new Password" name="newpwd">
            <?php echo $err ?>
        </div>
        <button type="submit" class="btn btn-danger btn-lg btn-block">Change</button>
    </form>
</body>

</html>