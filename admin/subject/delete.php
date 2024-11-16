<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Edit Subject";
    include '../partials/header.php';
    include '../partials/side-bar.php'; 
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Delete Subject</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./add.php">Add Subject</a></li>
                <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
            </ol>
        </nav>
        <div class="card p-5 mb-4">
            <p>Are you sure you want to delete the following subject record?</p>
            <ul>
                <li><strong>Subject Code: </strong>1001</li>
                <li><strong>Subject Name: </strong>Math</li>
            </ul>
            <form method="POST">
                <a href="./add.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Delete Subject Record</button>
            </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>