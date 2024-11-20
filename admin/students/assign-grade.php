<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Assign Grade";
    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Assign Grade to Subject</h2>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
                <li class="breadcrumb-item"><a href="./attach-subject.php">Attach Subject to Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Assign Grade to Subject</li>
            </ol>
        </nav>
        <div class="card p-5 mb-4">
            <h3>Selected Student and Subject Information</h3>
            <ul>
                <li><strong>Student ID: </strong></li>
                <li><strong>Name: </strong></li>
                <li><strong>Subject Code: </strong></li>
                <li><strong>Subject Name: </strong></li>
            </ul>
            <hr>
            <form method="post">
                <div class="form-floating mb-3">
                    <input type="number" name="grade" class="form-control" id="grade" placeholder="Grade" min="1" step="0.01" value="0.00">
                    <label for="grade">Grade</label>
                </div>
                <a href="./attach-subject.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="assignButton" class="btn btn-primary">Assign Grade to Subject</button>
            </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>