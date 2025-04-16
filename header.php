<div class="container max-width p-0">
    <nav class="navbar   navbar-default navbar-fixed-top px-2 mx-auto" style="max-width: 612px; width: 100%;">
        <div class="container-fluid">
            <div class="navbar-header">
                <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>-->
                <a class="navbar-brand" href="index.php">
                    <img alt="Brand" src="assets/images/logo.png" style="max-height:90px;max-width:90px">
                </a>
            </div>

            <div class="d-flex align-items-center">
                <!-- Wallet Icon & Balance -->
                <?php
                if (isset($_SESSION['id'])) {
                    $sql = "SELECT SUM(amount) as balance from balance WHERE userId=" . $_SESSION['id'];

                    $result = $connection->query($sql);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $balance = $row['balance'];
                    }

                ?>

                    <span class="badge text-white px-2 me-2">
                        <i class="fas fa-wallet mr-1"></i> &#8358; <?= $balance ?>
                    </span>
                <?php } ?>
                <!-- Profile Icon -->
                <!-- <a href="#" class="text-white" > -->
                <i class="fas fa-user-circle fa-2x text-white " onclick="openMenu()" style="cursor: pointer;"></i>
                <!-- </a> -->
                <!-- <a href="account.php" class="text-white">
                    <i class="fas fa-user-circle fa-2x"></i>
                </a> -->
            </div>


        </div>

    </nav><!--<span>Welcome <?= $_COOKIE['fullname'] ?></span>-->

    <?php
    $sql = "SELECT * FROM greetings order by id desc limit 1";
    $result = $connection->query($sql);
    $greetingMessage = "";
    //echo mysql_error();
    // if ( $result ){ 
    // 	while( $row3 = mysql_fetch_array($result)){
    // 		$greetingMessage=$row3['text'];
    // 	}
    // }
    if ($result) {
        // Fetch the latest greeting message
        while ($row3 = $result->fetch_assoc()) {
            $greetingMessage = $row3['text'];
        }
    } else {
        // Handle query failure
        die("Query failed: " . $connection->error);
    }
    ?>
    <!-- <div class="row text-white text-right py-1 px-0 mx-0 mx-auto theme-background " style="max-width: 612px; width: 100%;">
        <div class="col">
        <marquee direction="left"><?= $greetingMessage ?></marquee>
        </div>
    </div> -->
</div>


<script>
    function login() {
        $("#loginError").alert('close');
        var userName = $('#userName').val();
        var password = $('#password').val();

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
                    window.location.href = "<?= $host ?>";
                    // location.reload();
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
<!-- Begin of Chaport Live Chat code -->
<script type="text/javascript">
    (function(w, d, v3) {
        w.chaportConfig = {
            appId: '5d08d78178b3b63a0789ac92'
        };

        if (w.chaport) return;
        v3 = w.chaport = {};
        v3._q = [];
        v3._l = {};
        v3.q = function() {
            v3._q.push(arguments)
        };
        v3.on = function(e, fn) {
            if (!v3._l[e]) v3._l[e] = [];
            v3._l[e].push(fn)
        };
        var s = d.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://app.chaport.com/javascripts/insert.js';
        var ss = d.getElementsByTagName('script')[0];
        ss.parentNode.insertBefore(s, ss)
    })(window, document);
</script>
<!-- End of Chaport Live Chat code -->