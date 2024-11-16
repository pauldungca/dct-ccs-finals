<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Add Subject";
    include '../partials/header.php';
    include '../partials/side-bar.php';  

    $errorArray = [];
    $code = "";
    $name = "";

    if (isset($_POST['addSubject'])) {
        $code = $_POST['subCode'];
        $name = $_POST['subName'];
        
        $errorArray = validateSubjectData([
            'subject_code' => $code,
            'subject_name' => $name
        ]);
        if (empty($errorArray)) {
            addSubject($code, $name);
        }
    }

    $subjects = fetchSubjects();
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Add a New Subject</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
            </ol>
        </nav>
        <?php echo displayErrors($errorArray); ?>
        <div class="card p-3 mb-4">
            <form method="POST" class="p-4">
                <div class="form-floating mb-3">
                    <input type="text" name="subCode" class="form-control" id="subjectCode" placeholder="Subject Code" value="<?php echo $code ?>">
                    <label for="subjectCode">Subject Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="subName" class="form-control" id="subjectName" placeholder="Subject Name" value="<?php echo $name ?>">
                    <label for="subjectName">Subject Name</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 px-4" name="addSubject">Add Subject</button>
            </form>
        </div>
        <div class="card p-5 mb-4">
            <h4>Student List</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                <td>
                                    <a href="./edit.php?id=<?php echo $subject['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                    <a href="./delete.php?id=<?php echo $subject['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No subjects found.</td>
                        </tr>
                    <?php endif; ?>
            </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>