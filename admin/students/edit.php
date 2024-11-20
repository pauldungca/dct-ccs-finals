<?php 
    include '../../functions.php';
    guard();
    $pageTitle = "Edit Student";
    include '../partials/header.php';
    include '../partials/side-bar.php';  
?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <h2>Edit Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./register.php">Register Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
            </ol>
        </nav>
        <div class="card p-5 mb-4">
        <form method="post" class="p-4">
            <div class="form-floating mb-3">
                <input type="text" name="studID" class="form-control" id="studID" placeholder="Student ID" readonly>
                <label for="studID">Student ID</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="studFirstName" class="form-control" id="studFirstName" placeholder="First Name" autofocus>
                <label for="studFirstName">First Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="studLastName" class="form-control" id="studLastName" placeholder="Last Name" autofocus>
                <label for="studLastName">Last Name</label>
            </div>
            <button type="submit" name="updateButton" class="btn btn-primary w-100 px-4">Update Student</button>
        </form>
        </div>
    </main>

<?php include '../partials/footer.php'; ?>