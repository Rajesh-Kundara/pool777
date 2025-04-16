
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default navbar-fixed-top">
	<div class="container-fluid"> 
		<div class="navbar-header">
			<!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
				<i class="fa fa-bars"></i>
			</button>-->
			<a class="navbar-brand" href="../index.php">
				<img alt="Brand" src="../assets/images/logo.png" style="height:100px;widht:100px">
			</a>
		</div>
		<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbar-menu"
			aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		<div class="collapse navbar-collapse" id="navbar-menu" align="center">
			<ul class="nav nav-tabs navbar-nav mr-auto">
				<li role="presentation" class="<?=($activePage=="dashboard")?"active":""?>"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
				<li role="presentation" class="<?=($activePage=="clients")?"active":""?>"><a class="nav-link" href="users.php">Clients</a></li>
				<li role="presentation" class="<?=($activePage=="clients")?"active":""?>"><a class="nav-link" href="bankers.php">Bankers</a></li>
				<li role="presentation" class="<?=($activePage=="coupons")?"active":""?>"><a class="nav-link" href="coupons.php">Coupons</a></li>
				<li role="presentation" class="<?=($activePage=="matches")?"active":""?>"><a class="nav-link" href="matches.php">Matches</a></li>
				<li role="presentation" class="<?=($activePage=="declareWinners")?"active":""?>"><a class="nav-link" href="declare_winners.php">Declare Winners</a></li>
				<li role="presentation" class="<?=($activePage=="withdrawRequests")?"active":""?>"><a class="nav-link" href="withdraw_requests.php">Withdraw Requests</a></li>
				<li role="presentation" class="<?=($activePage=="contacts")?"active":""?>"><a class="nav-link" href="contacts.php">Contacts</a></li>
				<!--<li role="presentation" class="active"><a class="nav-link" href="premium-tips.php">Premium Tips</a></li>
				<li><a href="contacts.php">Premium Contacts</a></li>-->
				<li role="presentation"><a class="nav-link" href="<?=$host?>index.php?logout=rdr">Logout</a></li>
			</ul>
			<a class="text-blue mx-3" href="../">Home</a>
		</div>
		
	</div> 
	
</nav><!--<span>Welcome <?=$_COOKIE['fullname']?></span>-->
