<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Edit Subject";
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
        <div class="card p-3 mb-4">
        <form method="POST" class="p-4">
            <div class="form-floating mb-3">
                <input type="text" name="student_id" class="form-control" id="subjectId" placeholder="Subject ID">
                <label for="subjectId">Subject ID</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="first_name" class="form-control" id="subjectName" placeholder="Subject Name">
                <label for="subjectName">Subject Name</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 px-4">Update Subject</button>
        </form>
</div>
    </main>





<?php include '../partials/footer.php'; ?>