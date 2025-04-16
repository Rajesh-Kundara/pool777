<?php if(isset($_SESSION['fullname'])){ ?>
<div class="bg-primary">
	<ul class="nav nav-tabs">
	  <li class="nav-item">
		<a class="nav-link <?=($activePage=="account")?"active":"text-white"?>" href="account.php">My Account</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link <?=($activePage=="couponsPlayed")?"active":"text-white"?>" href="coupons_played.php">Coupons Played</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link <?=($activePage=="statement")?"active":"text-white"?>" href="statement.php">Statement</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link <?=($activePage=="deposit")?"active":"text-white"?>" href="deposit.php">Deposit</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link <?=($activePage=="requestWithdraw")?"active":"text-white"?>" href="request_withdraw.php">Request Withdraw</a>
	  </li>
	  <!--<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
		<div class="dropdown-menu">
		  <a class="dropdown-item" href="#">Action</a>
		  <a class="dropdown-item" href="#">Another action</a>
		  <a class="dropdown-item" href="#">Something else here</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="#">Separated link</a>
		</div>
	  </li>-->
	</ul>
</div>

<?php } ?>