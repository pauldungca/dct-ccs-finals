<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Register Student";
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
        <div class="card p-3 mb-4">
            <form method="post" class="p-4">
                <div class="form-floating mb-3">
                    <input type="text" name="student_id" class="form-control" id="student_id" placeholder="Student ID">
                    <label for="student_id">Student ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                    <label for="first_name">First Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                    <label for="last_name">Last Name</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 px-4">Add Student</button>
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
                <tbody>
                    <tr>
                        <td>2021001</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>
                            <a href="./edit.php" class="btn btn-info btn-sm">Edit</a>
                            <a href="./delete.php" class="btn btn-danger btn-sm">Delete</a>
                            <a href="#" class="btn btn-warning btn-sm">Attach Subject</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>