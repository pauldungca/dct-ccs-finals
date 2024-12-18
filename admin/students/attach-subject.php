<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Attach Subject";

    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $student = fetchStudentDetails($studentId); 
    }

    $errorArray = []; // Initialize the error array

    if (isset($_POST['attachButton'])) {
        if (empty($_POST['subject_ids'])) {
            $errorArray[] = "Please select at least one subject.";
        }
        if (empty($errorArray)) {
            $selectedSubjects = $_POST['subject_ids'];
            $studentId = $student['student_id'];
            
            foreach ($selectedSubjects as $subjectId) {
                attachSubjectToStudent($studentId, $subjectId);
            }
        }
    }

    $attachedSubjects = fetchAttachedSubjectIds($studentId);
    $subjects = fetchSubjects();

    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Attach Subject to Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Attach Subject to Student</li>
            </ol>
        </nav>
        <?php if (!empty($errorArray)): ?>
            <div class="alert alert-danger alert-dismissible fade show mx-auto my-3" role="alert">
                <strong>System Errors:</strong> Please correct the following errors.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <hr>
                <ul>
                    <?php foreach ($errorArray as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="card p-5 mb-4">
            <h3>Selected Student Information</h3>
            <ul>
                <li><strong>Student ID: </strong> <?php echo htmlspecialchars($student['student_id'] ?? ''); ?></li>
                <li><strong>Name: </strong><?php echo htmlspecialchars($student['first_name'] ?? '') . " " . htmlspecialchars($student['last_name'] ?? ''); ?></li>
            </ul>
            <hr>
            <form method="post">
                <div class="subjects-list">
                    <?php 
                    $availableSubjects = array_filter($subjects, function($subject) use ($attachedSubjects) {
                        return !in_array($subject['id'], $attachedSubjects);
                    });
                    // Check if any subjects are available for attachment
                    if (!empty($availableSubjects)): 
                    ?>
                        <?php foreach ($availableSubjects as $subject): ?>
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="subject_ids[]" 
                                    value="<?php echo htmlspecialchars($subject['id']); ?>" 
                                    id="subject-<?php echo htmlspecialchars($subject['id']); ?>"
                                >
                                <label 
                                    class="form-check-label" 
                                    for="subject-<?php echo htmlspecialchars($subject['subject_code']); ?>"
                                >
                                    <?php echo htmlspecialchars($subject['subject_code'] . " - " . $subject['subject_name']); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <label class="form-check-label">No subjects available to attach.</label>
                    <?php endif; ?>
                </div>
                <?php if (!empty($availableSubjects)): ?>
                    <br>
                    <button type="submit" name="attachButton" class="btn btn-primary">Attach Subject</button>
                <?php endif; ?>
            </form>
        </div>
        <div class="card p-5 mb-4">
            <h4>Subject List</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Grade</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Fetch student's attached subjects with details
                    $studentSubjects = fetchStudentSubjects($studentId); 
                    if (!empty($studentSubjects)): 
                        foreach ($studentSubjects as $subject): 
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                            <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                            <td><?php echo htmlspecialchars($subject['grade']); ?></td>
                            <td>
                            <a href="./dettach-subject.php?id=<?php echo urlencode($student['student_id']); ?>&code=<?php echo urlencode($subject['subject_code']); ?>" class="btn btn-danger btn-sm">Detach Subject</a>
                            <a href="./assign-grade.php?id=<?php echo urlencode($student['student_id']); ?>&code=<?php echo urlencode($subject['subject_code']); ?>&grade=<?php echo htmlspecialchars($subject['grade']); ?>" class="btn btn-success btn-sm">Assign Grade</a>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="4" class="text-center">No subjects attached to this student.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>