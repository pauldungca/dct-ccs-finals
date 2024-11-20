<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Attach Subject";
    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Attach Subject to Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Attach Subject to Student</li>
            </ol>
        </nav>
        <div class="card p-5 mb-4">
            <h3>Selected Student Information</h3>
            <ul>
                <li><strong>Student ID: </strong></li>
                <li><strong>Name: </strong></li>
            </ul>
            <hr>
            <form method="post">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="subject1">
                    <label class="form-check-label" for="subject1">
                        1001 - English
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="subject2">
                    <label class="form-check-label" for="subject2">
                        1002 - Mathematics
                    </label>
                </div>
                <br>
                <button type="submit" name="attachButton" class="btn btn-primary">Attach Subject</button>
            </form>
        </div>
        <div class="card p-5 mb-4">
            <h4>Student List</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Grade</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2021001</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>
                            <a href="./dettach-subject.php" class="btn btn-danger btn-sm">Dettach Subject</a>
                            <a href="./delete.php" class="btn btn-success btn-sm">Assign Grade</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>