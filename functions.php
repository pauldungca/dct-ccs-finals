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

    function addSubject($code, $name) {
        $con = openCon();
        if ($con) {  
            $sql = "INSERT INTO subjects (subject_code, subject_name) VALUES ('$code', '$name')";
            if (mysqli_query($con, $sql)) {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function getUsers() {
        $con = openCon();       
        $sql = "SELECT email, password FROM users";
        $result = mysqli_query($con, $sql);    
        $users = [];   
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[$row['email']] = $row['password'];
            }
        }    
        closeCon($con);     
        return $users;
    }

    function checkLoginCredentials($email, $password, $users) {
        return isset($users[$email]) && $users[$email] === md5($password);  
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
        <div class="alert alert-danger alert-dismissible fade show mx-auto my-3" style="margin-bottom: 20px;" role="alert">
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
 
    function getBaseURL() {
        return 'http://dct-ccs-finals.test/';
    }

    function guard() { 
        if (!isset($_SESSION['email'])) {
            header("Location: " . getBaseURL() . "index.php");
            session_destroy();
            exit();  
        }
    }

    function validateSubjectData($subject_data) {
        $errorArray = [];
        if (empty($subject_data['subject_code'])) {
            $errorArray['subject_code'] = 'Subject code is required!';
        }
        if (empty($subject_data['subject_name'])) {
            $errorArray['subject_name'] = 'Subject name is required!';
        }
        return $errorArray;
    }

    function fetchSubjects() {
        $subjects = [];
        $con = openCon();
        if ($con) {
            $result = mysqli_query($con, "SELECT * FROM subjects");
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $subjects[] = $row;
                }
            }
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
        return $subjects;
    }


?>