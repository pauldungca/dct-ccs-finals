<?php 

    include './functions.php';

    $con = openCon();
  
    if ($con) {
        $email = 'user2@gmail.com';
        $hashedPassword = md5('password'); 
        $name = 'user2';

        $sql = "INSERT INTO users (email, password, name) VALUES ('$email', '$hashedPassword', '$name')";

        if (mysqli_query($con, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        closeCon($con);
    } else {
        echo "Failed to connect to the database.";
    }
    
?>