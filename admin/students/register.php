<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Register Student";

    $errorArray = [];
    $studId = "";
    $firstName = "";
    $lastName = "";

    if (isset($_POST['addStudent'])) {
        $studId = $_POST['studentIdText'];
        $firstName = $_POST['studentFNameText'];
        $lastName = $_POST['studentLNameText'];

        $errorArray = validateStudentData([
            'student_id' => $studId,
            'first_name' => $firstName,
            'last_name' => $lastName
        ], false);

        $duplicateErrors = checkDuplicateStudentData([
            'student_id' => $studId
        ], false);

        $errorArray = array_merge($errorArray, $duplicateErrors);

        if (empty($errorArray)) {
            addStudent($studId, $firstName, $lastName);
            $studId = "";
            $firstName = "";
            $lastName = "";
        }
    }

    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Register a New Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Register Student</li>
            </ol>
        </nav>
        <?php echo displayErrors($errorArray); ?>
        <div class="card p-3 mb-4">
            <form method="post" class="p-4">
                <div class="form-floating mb-3">
                    <input type="text" name="studentIdText" class="form-control" id="studentIdText" placeholder="Student ID" value="<?php echo $studId ?>">
                    <label for="studentIdText">Student ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="studentFNameText" class="form-control" id="studentFNameText" placeholder="First Name" value="<?php echo $firstName ?>">
                    <label for="studentFNameText">First Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="studentLNameText" class="form-control" id="studentLNameText" placeholder="Last Name" value="<?php echo $lastName ?>">
                    <label for="studentLNameText">Last Name</label>
                </div>
                <button type="submit" name="addStudent" class="btn btn-primary w-100 px-4">Add Student</button>
            </form>
        </div>
        <div class="card p-5 mb-4">
            <h4>Student List</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <?php 
                $students = fetchStudents(); 
                ?>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-info btn-sm">Edit</a>
                                    <a href="delete.php?id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                    <a href="attach-subject.php?id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-warning btn-sm">Attach Subject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>