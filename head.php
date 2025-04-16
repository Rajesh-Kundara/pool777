<head>
	<meta charset="utf-8">
	<link rel="icon" href="../assets/images/logo.png" sizes="16x16">
	<title>Admin Portal</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="../image/png" href="favicon.ico">
	<link href="login/css/googleFont.css" rel="stylesheet">
	<!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="assets/css/style.css">
	
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap-material-datetimepicker.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap 5 JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery CDN (Latest version) -->
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<!-- Bootstrap JS -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->

	<!-- Bootstrape Icones -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


	<link rel="stylesheet" href="css/profileEdit.css">
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/game.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/game.js" defer></script>
	<script src="js/result.js" defer></script>
	<link rel="stylesheet" href="css/transaction.css">
	<link rel="stylesheet" href="css/bet_history.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/result.css">
	<link rel="stylesheet" href="css/lotto.css">
	<script>
 
 function goBack() {
    if (document.referrer) {
        window.history.back(); // Go to the previous page if available
    } else {
        window.location.href = "/"; // Redirect to home if no history
    }
}

</script>

<?php
function BackButton(){
	echo $btn = ' <a href="javascript:void(0);" class="btn-back text-decoration-none text-white d-flex align-items-center" onclick="goBack()">
                <i class="fas fa-arrow-left border rounded-circle p-1 me-2" style="font-size:14px"></i> Back
            </a>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/print-js@1.6.0/dist/print.min.js"></script>


</head>

