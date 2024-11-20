<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Assign Grade";

    // Get student ID and subject Code from the URL
    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $student = fetchStudentDetails($studentId); 
    }

    if (isset($_GET['code'])) {
        $subjectCode = $_GET['code'];
        $subject = fetchSubjectDetails($subjectCode); 
    }

    if (isset($_GET['grade'])) {
        $subjectGrade = $_GET['grade'];   
    }
    
    $grade = $subjectGrade;
    // Handle grade assignment logic
    if (isset($_POST['assignButton'])) {
        // Get the grade input from the form
        $grade = $_POST['grade'];
        
        // Validate the grade (it should not be greater than 100)
        if ($grade > 100) {
            $errorMessage = "Error: Grade cannot be greater than 100.";
        } else {
            // Update the grade in the students_subjects table
            assignGradeToSubject($studentId, $subjectCode, $grade);
            header("Location: ./attach-subject.php?id=" . urlencode($studentId));
            exit();
        }
    }

    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h2>Assign Grade to Subject</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
            <li class="breadcrumb-item"><a href="./attach-subject.php?id=<?php echo urlencode($student['student_id']); ?>">Attach Subject to Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assign Grade to Subject</li>
        </ol>
    </nav>
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto my-3" role="alert">
            <strong>System Error:</strong> <?php echo htmlspecialchars($errorMessage); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="card p-5 mb-4">
        <h3>Selected Student and Subject Information</h3>
        <ul>
            <li><strong>Student ID: </strong><?php echo htmlspecialchars($student['student_id'] ?? ''); ?></li>
            <li><strong>Name: </strong><?php echo htmlspecialchars($student['first_name'] ?? '') . " " . htmlspecialchars($student['last_name'] ?? ''); ?></li>
            <li><strong>Subject Code: </strong><?php echo htmlspecialchars($subject['subject_code'] ?? ''); ?></li>
            <li><strong>Subject Name: </strong><?php echo htmlspecialchars($subject['subject_name'] ?? ''); ?></li>
        </ul>
        <hr>
        <form method="post">
            <div class="form-floating mb-3">
                <input type="number" name="grade" class="form-control" id="grade" placeholder="Grade" min="0" step="0.01" value="<?php echo $grade ?>">
                <label for="grade">Grade</label>
            </div>
            <a href="./attach-subject.php?id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="assignButton" class="btn btn-primary">Assign Grade to Subject</button>
        </form>
    </div>
</main>

<?php include '../partials/footer.php'; ?>