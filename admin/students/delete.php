<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Delete Student";
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
                <li><strong>Student ID: </strong></li>
                <li><strong>First Name: </strong></li>
                <li><strong>Last Name: </strong></li>
            </ul>
            <form method="post">
                <a href="./register.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="deleteButton" class="btn btn-primary">Delete Student Record</button>
            </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>