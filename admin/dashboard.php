<!-- Template Files here -->
<?php 
    include '../functions.php';
    guard();
    $pageTitle = "Dashboard";

    $totalSubjects = countSubjects();
    $totalStudents = countStudents();
    $failedStudents = countFailedStudents();
    $passedStudents = countPassedStudents();

    include './partials/header.php';
    include './partials/side-bar.php';  
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <h1 class="h2">Dashboard</h1>        
    
    <div class="row mt-5">
        <div class="col-12 col-xl-3">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white border-primary">Number of Subjects:</div>
                <div class="card-body text-primary">
                    <h5 class="card-title"><?php echo $totalSubjects ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white border-primary">Number of Students:</div>
                <div class="card-body text-success">
                    <h5 class="card-title"><?php echo $totalStudents ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-danger mb-3">
                <div class="card-header bg-danger text-white border-danger">Number of Failed Students:</div>
                <div class="card-body text-danger">
                    <h5 class="card-title"><?php echo $failedStudents ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white border-success">Number of Passed Students:</div>
                <div class="card-body text-success">
                    <h5 class="card-title"><?php echo $passedStudents ?></h5>
                </div>
            </div>
        </div>
    </div>    
</main>
<!-- Template Files here -->

<!--<iframe
    src="https://www.chatbase.co/chatbot-iframe/kZYX1CmnGYPrqYubVg17x"
    width="100%"
    style="height: 100%; min-height: 700px"
    frameborder="0"
></iframe>-->

<script>
    window.embeddedChatbotConfig = {
        chatbotId: "kZYX1CmnGYPrqYubVg17x",
        domain: "www.chatbase.co"
    }
</script>
<script
    src="https://www.chatbase.co/embed.min.js"
    chatbotId="kZYX1CmnGYPrqYubVg17x"
    domain="www.chatbase.co"
    defer>
</script>

<?php include './partials/footer.php'; ?>