<?php
include('config.php');
$isLoggedIn = false;
if (isset($_SESSION['fullname'])) {
    //echo "<script>window.location.href='index.php'</script>";
    $isLoggedIn = true;
}
?>

<html class="no-js" lang="en">
<?php
include('head.php');

?>


<body data-spy="scroll" data-target=".navbar-collapse">
    <div class="max-width container p-0 container-fluid" id="mainContent" style="background-color: #e3e6ef;">

        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="login-container text-center">
                <div class="mb-3">
                    <img alt="Brand" src="assets/images/logo.png" style="max-height:90px;max-width:90px">
                </div>
                <h4 class="fw-bold font-color-2">Log in</h4>
                <p class=" font-color-1">Log in with your username and password</p>
                <div class="input-group mb-3">

                    <input type="text" class="form-control py-2 font-color-1" id="username" placeholder="username">
                </div>
                <div class="input-group mb-3">

                    <input type="text" class="form-control py-2" id="password" placeholder="password">
                </div>
                <button class="proceed-btn" onclick="login()">Log in</button>
                <div id="loginErrorContainer"></div>
                <hr>
                <a href="register.php" class=" font-color-1">Register</a>
                <p class="mt-3  font-color-1">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum.</p>
            </div>
        </div>



    </div>




</body>
<script>
    function login() {
        $("#loginError").alert('close'); // Close previous alert if exists
        var userName = $('#username').val().trim();
        var password = $('#password').val().trim();

        // Clear previous error messages
        $("#loginErrorContainer").html('');

        if (userName === "" || password === "") {
            var errorHtml = '<div id="loginError" class="w-100 alert alert-danger fade show mt-2 d-flex" role="alert" >' +
                'Please enter both username and password.</div>';
            $("#loginErrorContainer").html(errorHtml);
            return; // Stop execution if fields are empty
        }

        var form_data = new FormData();
        form_data.append("userName", userName);
        form_data.append("password", password);

        $.ajax({
            type: "POST",
            url: "<?= $host ?>/api/login.php",
            processData: false,
            contentType: false,
            data: form_data,
            success: function(response) {
                response = JSON.parse(response);
                if (response.success == "1") {
                    window.location.href = "<?= $host ?>/";
                } else {
                    var html = '<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:250px;">' + response.message + '</div>';
                    $("#loginErrorContainer").html(html);
                    //$("#loginError").show('slow');
                }
            },
            error: function(e) {
                alert(e.status);
                alert(e.responseText);
                alert(thrownError);
            }
        });
        //document.getElementById("saveButton").disabled=true;
    }
</script>

</html>