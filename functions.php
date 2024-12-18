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

    function getBaseURL() {
        return 'http://dct-ccs-finals.test/';
    }

    function guard() {
        // Check if the user is logged in
        $isLoggedIn = isset($_SESSION['email']);
        $currentFile = basename($_SERVER['PHP_SELF']);
        $isInAdmin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
    
        // Case 1: If the user is logged in and trying to access index.php, redirect to the dashboard
        if ($isLoggedIn && $currentFile === 'index.php' && !$isInAdmin) {
            header("Location: " . getBaseURL() . "admin/dashboard.php");
            exit();
        }
    
        // Case 2: If not logged in and trying to access any page inside the admin folder, redirect to index.php
        else if (!$isLoggedIn && $isInAdmin) {
            header("Location: " . getBaseURL() . "index.php");
            exit();
        }
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

    function validateSubjectData($subject_data, $isEdit = false) {
        $errorArray = [];
        if (!$isEdit && empty($subject_data['subject_code'])) {
            $errorArray['subject_code'] = 'Subject code is required!';
        }
        if (empty($subject_data['subject_name'])) {
            $errorArray['subject_name'] = 'Subject name is required!';
        }
        return $errorArray;
    }

    function checkDuplicateSubjectData($subject_data, $isEdit = false) {
        $errors = [];
        $con = openCon();
        if ($con) {
            $name = $subject_data['subject_name'];
            $code = $isEdit ? null : $subject_data['subject_code'];
            $sql = "SELECT * FROM subjects WHERE subject_name = ?";
            if (!$isEdit) {
                $sql .= " OR subject_code = ?";
            }
            $stmt = mysqli_prepare($con, $sql);
            if (!$isEdit) {
                mysqli_stmt_bind_param($stmt, "ss", $name, $code);
            } else {
                mysqli_stmt_bind_param($stmt, "s", $name);
            }
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (!$isEdit && $row['subject_code'] == $code) {
                        $errors[] = "A subject with this code already exists.";
                    }
                    if ($row['subject_name'] == $name) {
                        $errors[] = "A subject with this name already exists.";
                    }
                }
            }
            mysqli_stmt_close($stmt);
            closeCon($con);
        } else {
            $errors[] = "Failed to connect to the database.";
        }
        return $errors;
    }

    function updateSubject($code, $name) {
        $con = openCon(); 
        if ($con) { 
            $sql = "UPDATE subjects SET subject_name = '$name' WHERE subject_code = '$code'";
            if (mysqli_query($con, $sql)) {
                echo 'Success';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            closeCon($con); 
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function fetchSubjectDetails($subjectCode) {
        $con = openCon(); // Open the database connection
        $stmt = $con->prepare("SELECT * FROM subjects WHERE subject_code = ?");
        $stmt->bind_param("s", $subjectCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $subject = $result->fetch_assoc();
            $stmt->close();
            closeCon($con); 
            return $subject;
        } else {
            $stmt->close();
            closeCon($con); 
            return null;
        }
    }

    function fetchSubjects() {
        $con = openCon(); 
        $result = $con->query("SELECT * FROM subjects");
        $subjects = [];  
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subjects[] = $row;
            }
        }
        closeCon($con); 
        return $subjects;
    }

    function deleteSubject($subjectCode) {
        $con = openCon(); 
        if ($con) {
            // Begin transaction for safety
            $con->begin_transaction();
    
            try {
                // First, delete related records from the pivot table
                $stmtPivot = $con->prepare("DELETE FROM students_subjects WHERE subject_id = (SELECT id FROM subjects WHERE subject_code = ?)");
                $stmtPivot->bind_param("s", $subjectCode);
                $stmtPivot->execute();
    
                // Then, delete the subject itself
                $stmtSubject = $con->prepare("DELETE FROM subjects WHERE subject_code = ?");
                $stmtSubject->bind_param("s", $subjectCode);
                $stmtSubject->execute();
    
                // Commit the transaction
                $con->commit();
    
                $stmtPivot->close();
                $stmtSubject->close();
            } catch (Exception $e) {
                // Rollback transaction in case of an error
                $con->rollback();
                echo "Error: " . $e->getMessage();
            }
    
            closeCon($con); 
        } else {
            echo "Failed to connect to the database.";
        }
    }
    

    function fetchStudents() {
        $con = openCon(); 
        $result = $con->query("SELECT * FROM students");
        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        closeCon($con); 
        return $students;
    }

    function addStudent($id, $firstName, $lastName) {
        $con = openCon();
        if ($con) {
            $sql = "INSERT INTO students (student_id, first_name, last_name) VALUES ('$id', '$firstName', '$lastName')";
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

    function validateStudentData($student_data, $isEdit = false) {
        $errorArray = [];
        if (!$isEdit && empty($student_data['student_id'])) {
            $errorArray['student_id'] = 'Student ID is required!';
        }
        if (empty($student_data['first_name'])) {
            $errorArray['first_name'] = 'First name is required!';
        }
        if (empty($student_data['last_name'])) {
            $errorArray['last_name'] = 'Last name is required!';
        }
        return $errorArray;
    }

    function checkDuplicateStudentData($student_data, $isEdit = false) {
        $errors = [];
        $con = openCon();
        if ($con) {
            $id = $student_data['student_id'];
            $sql = "SELECT * FROM students WHERE student_id = ?";
            
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (!$isEdit && $row['student_id'] == $id) {
                        $errors[] = "A student with this ID already exists.";
                    }
                }
            }
    
            mysqli_stmt_close($stmt);
            closeCon($con);
        } else {
            $errors[] = "Failed to connect to the database.";
        }
        return $errors;
    }

    function fetchStudentDetails($studentId) {
        $con = openCon(); // Open the database connection
        $stmt = $con->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $stmt->close();
            closeCon($con); 
            return $student;
        } else {
            $stmt->close();
            closeCon($con); 
            return null;
        }
    }

    function updateStudent($studentId, $firstName, $lastName) {
        $con = openCon(); 
        if ($con) { 
            $sql = "UPDATE students SET first_name = '$firstName', last_name = '$lastName' WHERE student_id = '$studentId'";
            if (mysqli_query($con, $sql)) {
                //echo 'Success';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            closeCon($con); 
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function deleteStudent($studentId) {
        $con = openCon(); 
        if ($con) {
            // Begin transaction for safety
            $con->begin_transaction();
    
            try {
                // First, delete related records from the pivot table
                $stmtPivot = $con->prepare("DELETE FROM students_subjects WHERE student_id = ?");
                $stmtPivot->bind_param("s", $studentId);
                $stmtPivot->execute();
    
                // Then, delete the student itself
                $stmtStudent = $con->prepare("DELETE FROM students WHERE student_id = ?");
                $stmtStudent->bind_param("s", $studentId);
                $stmtStudent->execute();
    
                // Commit the transaction
                $con->commit();
    
                $stmtPivot->close();
                $stmtStudent->close();
            } catch (Exception $e) {
                // Rollback transaction in case of an error
                $con->rollback();
                echo "Error: " . $e->getMessage();
            }
    
            closeCon($con); 
        } else {
            echo "Failed to connect to the database.";
        }
    }
    

    function attachSubjectToStudent($studentId, $subjectId) {
        $defaultGrade = 0.00; // Default grade value
        $con = openCon(); // Ensure database connection is open
        if ($con) {
            // Prepare the SQL statement
            $stmt = $con->prepare("INSERT INTO students_subjects (student_id, subject_id, grade) VALUES (?, ?, ?)");
            if ($stmt) {
                // Bind parameters (two integers and a float)
                $stmt->bind_param("iid", $studentId, $subjectId, $defaultGrade);
    
                // Execute the statement and check for errors
                if (!$stmt->execute()) {
                    echo "Error attaching subject: " . $stmt->error;
                }
    
                // Close the statement
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $con->error;
            }
    
            // Close the database connection
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    // Fetch attached subjects with their details
    function fetchStudentSubjects($studentId) {
        $con = openCon();
        $subjects = [];
        if ($con) {
            $stmt = $con->prepare("
                SELECT s.subject_code, s.subject_name, ss.grade, ss.subject_id
                FROM students_subjects ss
                JOIN subjects s ON ss.subject_id = s.id
                WHERE ss.student_id = ?");
            $stmt->bind_param("i", $studentId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $subjects[] = $row;
            }

            $stmt->close();
            closeCon($con);
        }
        return $subjects;
    }

    // Fetch the attached subject IDs for the student
    function fetchAttachedSubjectIds($studentId) {
        $con = openCon();
        $attachedSubjects = [];
        if ($con) {
            $stmt = $con->prepare("SELECT subject_id FROM students_subjects WHERE student_id = ?");
            $stmt->bind_param("i", $studentId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $attachedSubjects[] = $row['subject_id'];
            }

            $stmt->close();
            closeCon($con);
        }
        return $attachedSubjects;
    }

    function dettachSubjectFromStudent($studentId, $subjectCode) {
        $con = openCon();
        if ($con) {
            // First, get the subject ID using the subject code
            $stmt = $con->prepare("SELECT id FROM subjects WHERE subject_code = ?");
            $stmt->bind_param("s", $subjectCode);
            $stmt->execute();
            $result = $stmt->get_result();
            $subject = $result->fetch_assoc();
            
            if ($subject) {
                $subjectId = $subject['id'];
                
                // Now, delete the record from the pivot table
                $deleteStmt = $con->prepare("DELETE FROM students_subjects WHERE student_id = ? AND subject_id = ?");
                $deleteStmt->bind_param("ii", $studentId, $subjectId);
                $deleteStmt->execute();
                
                if ($deleteStmt->affected_rows > 0) {
                    echo "Subject detached successfully.";
                } else {
                    echo "Error detaching subject.";
                }
                
                $deleteStmt->close();
            }
            $stmt->close();
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function assignGradeToSubject($studentId, $subjectCode, $grade) {
        $con = openCon();
        if ($con) {
            // First, get the subject ID using the subject code
            $stmt = $con->prepare("SELECT id FROM subjects WHERE subject_code = ?");
            $stmt->bind_param("s", $subjectCode);
            $stmt->execute();
            $result = $stmt->get_result();
            $subject = $result->fetch_assoc();
            
            if ($subject) {
                $subjectId = $subject['id'];
                
                // Check if the student is already assigned to this subject
                $checkStmt = $con->prepare("SELECT * FROM students_subjects WHERE student_id = ? AND subject_id = ?");
                $checkStmt->bind_param("ii", $studentId, $subjectId);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();
                
                if ($checkResult->num_rows > 0) {
                    // Update the grade if the subject is already assigned to the student
                    $updateStmt = $con->prepare("UPDATE students_subjects SET grade = ? WHERE student_id = ? AND subject_id = ?");
                    $updateStmt->bind_param("dii", $grade, $studentId, $subjectId);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    // Otherwise, insert a new record for this student and subject
                    $insertStmt = $con->prepare("INSERT INTO students_subjects (student_id, subject_id, grade) VALUES (?, ?, ?)");
                    $insertStmt->bind_param("iid", $studentId, $subjectId, $grade);
                    $insertStmt->execute();
                    $insertStmt->close();
                }
                
                $checkStmt->close();
            }
            $stmt->close();
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function fetchGrade($studentId, $subjectCode) {
        $con = openCon();  // Open the database connection
        
        // Simple query to fetch the grade for the specific student and subject
        $query = "SELECT grade FROM students_subjects WHERE student_id = '$studentId' AND subject_id = '$subjectCode'";
        
        // Execute the query
        $result = $con->query($query);
        
        // Directly fetch the grade if a result is returned
        $grade = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['grade'] : null;
    
        closeCon($con);  // Close the database connection
        return $grade;
    }

    function countSubjects() {
        $con = openCon();  
        $query = "SELECT COUNT(*) AS total_subjects FROM subjects";
        $result = $con->query($query);
        $count = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_subjects'] : 0;
        closeCon($con); 
        return $count;
    }

    function countStudents() {
        $con = openCon();  
        $query = "SELECT COUNT(*) AS total_students FROM students";
        $result = $con->query($query);
        $count = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_students'] : 0;
        closeCon($con);  
        return $count;
    }

    function countFailedStudents() {
        $con = openCon();
        
        // SQL query to count students whose average grade is <= 74.00
        $query = "
            SELECT student_id
            FROM students_subjects
            GROUP BY student_id
            HAVING AVG(grade) <= 74.00
        ";
        
        $result = $con->query($query);
        $failedStudentsCount = $result->num_rows;
    
        closeCon($con);
        return $failedStudentsCount;
    }
    
    function countPassedStudents() {
        $con = openCon();
        
        // SQL query to count students whose average grade is > 74.00
        $query = "
            SELECT student_id
            FROM students_subjects
            GROUP BY student_id
            HAVING AVG(grade) > 74.00
        ";
        
        $result = $con->query($query);
        $passedStudentsCount = $result->num_rows;
    
        closeCon($con);
        return $passedStudentsCount;
    }
     
?>