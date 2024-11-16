<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Add Subject";
    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Add a New Subject</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
            </ol>
        </nav>
        <div class="card p-3 mb-4">
            <form method="POST" class="p-4">
                <div class="form-floating mb-3">
                    <input type="text" name="student_id" class="form-control" id="subjectCode" placeholder="Subject Code">
                    <label for="subjectCode">Subject Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="first_name" class="form-control" id="subjectName" placeholder="Subject Name">
                    <label for="subjectName">Subject Name</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 px-4">Add Subject</button>
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
                    <tr>
                        <td>1001</td>
                        <td>Math</td>
                        <td>
                            <a href="./edit.php" class="btn btn-info btn-sm">Edit</a>
                            <a href="./delete.php" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>