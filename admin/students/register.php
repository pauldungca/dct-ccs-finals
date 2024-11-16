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
            <form method="POST" class="p-4">
                <input type="text" name="student_id" class="form-control mb-3" placeholder="Student ID">
                <input type="text" name="first_name" class="form-control mb-3" placeholder="First Name">
                <input type="text" name="last_name" class="form-control mb-3" placeholder="Last Name">
                <button type="submit" class="btn btn-primary w-100 px-4">Add Student</button>
            </form>
        </div>
        <div class="card p-5 mb-4">
            <h4>Student List</h4>
            <table class="table">
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
                        <td>John Doe</td>
                        <td>john.doe@example.com</td>
                        <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                            <button class="btn btn-warning btn-sm">Attach Subject</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2021002</td>
                        <td>Jane Smith</td>
                        <td>jane.smith@example.com</td>
                        <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                            <button class="btn btn-warning btn-sm">Attach Subject</button>
                        </td>
                    </tr>
                    <!-- Additional rows can be populated dynamically -->
                </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>