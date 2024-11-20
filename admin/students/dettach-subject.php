<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Dettach Subject";

    // Get student ID and subject ID from the URL
    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $student = fetchStudentDetails($studentId); 
    }

    if (isset($_GET['code'])) {
        $subjectCode = $_GET['code'];
        $subject = fetchSubjectDetails($subjectCode); 
    }

    if (isset($_POST['dettachButton'])) {
        if ($studentId && $subjectCode) {
            dettachSubjectFromStudent($studentId, $subjectCode);
            // Redirect after detaching
            header("Location: ./attach-subject.php?id=" . urlencode($studentId));
            exit();
        }
    }

    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h2>Dettach Subject from Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
            <li class="breadcrumb-item"><a href="./attach-subject.php">Attach Subject to Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dettach Subject from Student</li>
        </ol>
    </nav>
    <div class="card p-5 mb-4">
        <p>Are you sure you want to detach this subject from the student record?</p>
        <ul>
            <li><strong>Student ID: </strong><?php echo htmlspecialchars($student['student_id'] ?? ''); ?></li>
            <li><strong>First Name: </strong><?php echo htmlspecialchars($student['first_name'] ?? ''); ?></li>
            <li><strong>Last Name: </strong><?php echo htmlspecialchars($student['last_name'] ?? ''); ?></li>
            <li><strong>Subject Code: </strong><?php echo htmlspecialchars($subject['subject_code'] ?? ''); ?></li>
            <li><strong>Subject Name: </strong><?php echo htmlspecialchars($subject['subject_name'] ?? ''); ?></li>
        </ul>
        <form method="post">
            <a href="./attach-subject.php?id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="dettachButton" class="btn btn-primary">Dettach Subject from Student</button>
        </form>
    </div>
</main>

<?php include '../partials/footer.php'; ?>