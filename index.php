<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "event";

if(isset($_POST['delete'])) {
    $con = mysqli_connect($server, $username, $password, $database);
    
    if(!$con){
        die("Connection to the database failed: " . mysqli_connect_error());
    }

    $idToDelete = $_POST['delete_id'];

    // Delete
    $sql = "DELETE FROM `event` WHERE `sr` = $idToDelete";

    if(mysqli_query($con, $sql)){
        echo "<p class='deleteMsg'>Record deleted successfully!</p>";
    } else{
        echo "ERROR: Unable to execute $sql. " . mysqli_error($con);
    }

    mysqli_close($con);
}

if(isset($_POST['update'])){
    $con = mysqli_connect($server, $username, $password, $database);

    if(!$con){
        die("Connection to the database failed: " . mysqli_connect_error());
    }

    $idToUpdate = $_POST['update_id'];
    $updatedAge = $_POST['updated_age'];
    $updatedGender = $_POST['updated_gender'];
    $updatedPhone = $_POST['updated_phone'];
    $updatedEmail = $_POST['updated_email'];

    // Update 
    $sql = "UPDATE `event` SET `age`='$updatedAge', `gender`='$updatedGender', `phone`='$updatedPhone', `email`='$updatedEmail' WHERE `sr`='$idToUpdate'";

    if(mysqli_query($con, $sql)){
        echo "<p class='updateMsg'>Record updated successfully!</p>";
    } else{
        echo "ERROR: Unable to execute $sql. " . mysqli_error($con);
    }

    mysqli_close($con);
}

$insert = false;
if(isset($_POST['name'])){
    $con = mysqli_connect($server, $username, $password, $database);

    if(!$con){
        die("Connection to this database failed due to" . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

   
    if(!preg_match("/^[a-zA-Z]*$/", $name)) {
        echo "<p class='errorMsg'>Name should only contain alphabets.</p>";
    } elseif($age < 18 || $age > 60) {
        echo "<p class='errorMsg'>Age must be between 18 and 60.</p>";
    } elseif(strlen($phone) !== 10 || !is_numeric($phone)) {
        echo "<p class='errorMsg'>Phone number must be exactly 10 digits and contain only numbers.</p>";
    } elseif($gender !== 'male'||'Male' && $gender !== 'female'||'Female'||'m'||'M'||'F'||'f') {
        echo "<p class='errorMsg'>Gender must be either 'male' or 'female'.</p>";
    } else {
        
        // Insert
        $sql = "INSERT INTO `$database`.`event` (`name`, `age`, `gender`, `phone`, `email`, `dt`) VALUES ('$name', '$age', '$gender', '$phone', '$email', current_timestamp())";

        if(mysqli_query($con, $sql)){
            $insert = true;
        } else{
            echo "ERROR: $sql <br> " . mysqli_error($con);
        }
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Event Registration Form</h1>

    <p>Enter your details and submit this form to confirm participation in the event.</p>
    <br>
    <?php
    if($insert == true){
        echo "<p class='submitMsg'>Thanks for submitting your form!</p>";
    }
    ?>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="name">Enter Your Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="age">Enter Your Age</label>
            <input type="text" name="age" id="age" placeholder="Enter Age">
        </div>
        <div class="form-group">
            <label for="gender">Enter Your Gender</label>
            <input type="text" name="gender" id="gender" placeholder="Enter Gender">
        </div>
        <div class="form-group">
            <label for="phone">Enter Your Phone number</label>
            <input type="phone" name="phone" id="phone" placeholder="Enter Phone number">
        </div>
        <div class="form-group">
            <label for="email">Enter Your Email</label>
            <input type="email" name="email" id="email" placeholder="Enter Email">
        </div>
        <button class="btn">Submit</button>
    </form>

    <hr> 

    <h2>Delete Entry</h2>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="delete_id">Enter ID to Delete</label>
            <input type="text" name="delete_id" id="delete_id" placeholder="Enter ID to delete">
        </div>
        <button class="btn" name="delete">Delete</button>
    </form>

    <hr> 

    <h2>Update Entry</h2>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="update_id">Enter ID to Update</label>
            <input type="text" name="update_id" id="update_id" placeholder="Enter ID to update">
        </div>
        <div class="form-group">
            <label for="updated_age">Enter Updated Age</label>
            <input type="text" name="updated_age" id="updated_age" placeholder="Enter updated age">
        </div>
        <div class="form-group">
            <label for="updated_gender">Enter Updated Gender</label>
            <input type="text" name="updated_gender" id="updated_gender" placeholder="Enter updated gender">
        </div>
        <div class="form-group">
            <label for="updated_phone">Enter Updated Phone number</label>
            <input type="phone" name="updated_phone" id="updated_phone" placeholder="Enter updated phone number">
        </div>
        <div class="form-group">
            <label for="updated_email">Enter Updated Email</label>
            <input type="email" name="updated_email" id="updated_email" placeholder="Enter updated email">
        </div>
        <button class="btn" name="update">Update</button>
    </form>
</div>
<script src="index.js"></script>
</body>
</html>
