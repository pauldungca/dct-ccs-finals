<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Dettach Subject";
    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Dettach Subject to Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
                <li class="breadcrumb-item"><a href="./attach-subject.php">Attach Subject to Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dettach Subject to Student</li>
            </ol>
        </nav>
        <div class="card p-5 mb-4">
            <p>Are you sure you want to dettach subject to this student record?</p>
            <ul>
                <li><strong>Student ID: </strong></li>
                <li><strong>First Name: </strong></li>
                <li><strong>Last Name: </strong></li>
                <li><strong>Subject Code: </strong></li>
                <li><strong>Subject Name: </strong></li>
            </ul>
            <form method="post">
                <a href="./attach-subject.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="dettachButton" class="btn btn-primary">Dettach Subject from Student</button>
            </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>