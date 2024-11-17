<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Edit Subject";

    if (isset($_GET['code'])) {
        $subjectCode = $_GET['code'];
        $subject = fetchSubjectDetails($subjectCode); 
    }
    
    $errorArray = [];
    $name = "";

    if (isset($_POST['updateButton'])) {
        $code = $_POST['subCode'];
        $name = $_POST['subName'];

        $errorArray = validateSubjectData([
            'subject_code' => $subjectCode, 
            'subject_name' => $name
        ], true); 
    
        $duplicateErrors = checkDuplicateSubjectData([
            'subject_code' => $subjectCode,
            'subject_name' => $name
        ], true);
    
        $errorArray = array_merge($errorArray, $duplicateErrors);

        if (empty($errorArray)) {
            updateSubject($subjectCode, $name);
            header("Location: /admin/subject/add.php");
            exit();
        }
    }

    include '../partials/header.php';
    include '../partials/side-bar.php';  
    
?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Add a New Subject</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./add.php">Add Subject</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
            </ol>
        </nav>
        <?php echo displayErrors($errorArray); ?>
        <div class="card p-5 mb-4">
        <form method="post" class="p-4">
            <div class="form-floating mb-3">
                <input type="text" name="subCode" class="form-control" id="subjectCode" placeholder="Subject Code" value="<?php echo htmlspecialchars($subject['subject_code'] ?? ''); ?>" readonly>
                <label for="subjectCode">Subject Code</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="subName" class="form-control" id="subjectName" placeholder="Subject Name" value="<?php echo htmlspecialchars($subject['subject_name'] ?? ''); ?>" autofocus>
                <label for="subjectName">Subject Name</label>
        </div>
            <button type="submit" name="updateButton" class="btn btn-primary w-100 px-4">Update Subject</button>
        </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>