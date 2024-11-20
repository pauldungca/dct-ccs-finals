<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Delete Student";

    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $student = fetchStudentDetails($studentId); 
    }

    if (isset($_POST['deleteButton'])) {
        deleteStudent($studentId);
        header("Location: /admin/students/register.php");
        exit();
    }

    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Delete Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
            </ol>
        </nav>
        <div class="card p-5 mb-4">
            <p>Are you sure you want to delete the following student record?</p>
            <ul>
                <li><strong>Student ID: </strong><?php echo htmlspecialchars($student['student_id'] ?? ''); ?></li>
                <li><strong>First Name: </strong><?php echo htmlspecialchars($student['first_name'] ?? ''); ?></li>
                <li><strong>Last Name: </strong><?php echo htmlspecialchars($student['last_name'] ?? ''); ?></li>
            </ul>
            <form method="post">
                <a href="./register.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="deleteButton" class="btn btn-primary">Delete Student Record</button>
            </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>