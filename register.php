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
				<h4 class="fw-bold font-color-2">Register</h4>
				<?php
				if (empty($_GET['success'])) {
				?>
					<div class="input-group mb-3">
						<input type="text" class="form-control py-2" id="userNameValue" placeholder="username">
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control py-2" id="passwordValue" placeholder="password">
					</div>

					<div class="input-group mb-3">
						<input type="password" class="form-control py-2" id="rePassword" placeholder="re-enter password">
					</div>
					<div class="input-group mb-3">
						<div class="form-control py-2">
							<?php
							$sql = "SELECT * FROM countries";
							$result = $connection->query($sql);
							$string = "<select id='countryCode' name='countries' class='form-control py-2' onChange='getStates(0)'><option value='0'>select</option>";
							if ($result) {
								while ($row = $result->fetch_assoc()) {
									$string = $string . '<option value="' . $row['code'] . '">' . $row['code'] . '</option>';
								}
							}
							$string = $string . '</select>';
							echo $string;
							?>
							<!-- <input type="text" class="input-group-text" style="width:80px;background-color:#ffffff" id="countryCode" placeholder="code" value="<?= $countryCode ?>"> -->
						</div>
						<input type="tel" class="form-control" id="phone" placeholder="phone">
					</div>

					<button class="proceed-btn" onclick="register()">Register</button>
					<div id="loginErrorContainer"></div>
				<?php } else { ?>
					<div class="card mt-4 mb-3">
						<div class="card-header text-center text-white p-1 bg-success">Success</div>
						<div class="card-body p-2">
							<p class="card-text">Registered successfuly!</br>Please login now.</p>
							<!--<a href="<?= $host; ?>" class="btn btn-primary">Login</a>-->
						</div>
					</div>
				<?php } ?>
				<p class="mt-3  font-color-1">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum.</p>
			</div>
		</div>



	</div>

	<div id="modalInfo" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalInfoTitle"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p id="modalInfoBody"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="javascript:window.location.href='register.php?success=true';">Close</button>
				</div>
			</div>
		</div>
	</div>



	<script>
		function register() {
			$("#error").alert('close');

			var form_data = new FormData();
			var userName = $("#userNameValue").val();
			var password = $("#passwordValue").val();
			var rePassword = $("#rePassword").val();
			var countryCode = $("#countryCode").val();
			var phone = $("#phone").val();
		
			form_data.append("countryCode", countryCode);
			form_data.append("phone", phone);
		

			if (password != rePassword) {
				alert("Confirm password does not match!");
				return;
			}
			form_data.append("userName", userName);
			form_data.append("password", password);

			$.ajax({
				type: "POST",
				url: "<?= $host ?>/api/register.php",
				processData: false,
				contentType: false,
				data: form_data,
				//data: "idForUpdate=" + idForUpdate,  
				success: function(response) {
					response = JSON.parse(response);
					if (response.success == "1") {
						$('#modalInfoTitle').html("Success!");
						$('#modalInfoBody').html(response.message);

						$('#modalInfo').modal('show');
					} else {
						var html = '<div id="error" class="alert alert-danger fade show" role="alert">' + response.message + '</div>';
						$("#errorContainer").html(html);
					}
				},
				error: function(e) {
					alert(e.status);
					alert(e.responseText);
					alert(thrownError);
				}
			});
		}
	</script>
</body>

</html>