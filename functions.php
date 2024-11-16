<?php    
    // All project functions should be placed here

    function checkUserSessionIsActive() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }
    }

    checkUserSessionIsActive();

    function openCon() {
        $con = mysqli_connect("localhost", "root", "", "dct-ccs-finals");  
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        } 
        return $con;
    }
    
    function closeCon($con) {
        return mysqli_close($con);
    }

    function addUser() {

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
    }
    
    function getUsers() {
        return [
            "admin1@gmail.com" => "pass1",
            "admin2@gmail.com" => "pass2",
            "admin3@gmail.com" => "pass3",
            "admin4@gmail.com" => "pass4",
            "admin5@gmail.com" => "pass5"
        ];
    }

    function checkLoginCredentials($email, $password, $users) {
        return isset($users[$email]) && $users[$email] === $password;
    }

    function validateLoginCredentials($email, $password) {
        $errorArray = [];
        $users = getUsers(); 
    
        if (empty($email)) {
            $errorArray['email'] = 'Email Address is required!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorArray['email'] = 'Email Address is invalid!';
        }
    
        if (empty($password)) {
            $errorArray['password'] = 'Password is required!';
        }
    
        if (empty($errorArray)) {
            if (!checkLoginCredentials($email, $password, $users)) {
                $errorArray['credentials'] = 'Incorrect email or password!';
            }
        }
    
        return $errorArray;
    }

    function displayErrors($errors) {
        if (empty($errors)) {
            return ''; 
        }
    
        $output = '
        <div class="alert alert-danger alert-dismissible fade show mx-auto my-5" style="margin-bottom: 20px;" role="alert">
            <strong>System Errors:</strong> Please correct the following errors.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <hr>
            <ul>';
    
        foreach ($errors as $error) {
            $output .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        $output .= '</ul></div>';
    
        return $output;
    }





?>