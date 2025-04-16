<!-- Footer -->
<div class="container max-width" style="background-color: #e3e6ef;height: 62px;">
    <div class="p-footer p-2" style="background-color: #fff;">
        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <i class="fas fa-th"></i>
            <span>Games</span>
        </a>
        <a href="lotto.php" class="<?= basename($_SERVER['PHP_SELF']) == 'lotto.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-circle-dollar-to-slot"></i>
            <span>Lotto</span>
        </a>
        <a href="result.php" class="<?= basename($_SERVER['PHP_SELF']) == 'result.php' ? 'active' : '' ?> ">
            <i class="fas fa-table"></i>
            <span>Result</span>
        </a>
        <a href="#" class="<?= basename($_SERVER['PHP_SELF']) == 'a.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Betslip</span>
        </a>
        <a href="#" class="<?= basename($_SERVER['PHP_SELF']) == 'c.php' ? 'active' : '' ?>">
            <i class="fas fa-ticket-alt"></i>
            <span>Open Bet</span>
        </a>
    </div>
</div>

<!-- menu card -->


<!-- modal info -->
<div id="modalInfo" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ">
            <div class="modal-header text-white" style="background-color: #2b1a93;">
                <h5 class="modal-title" id="modalInfoTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalInfoBody"></p>
            </div>
            <div class="modal-footer border-top border-dark" style="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- js links -->
<!-- jQuery -->

<!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script> -->
<script src="assets/js/vendor/popper.min.js"></script>
<script src="assets/js/vendor/bootstrap.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>
<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
<script src="assets/js/mdtimepicker.js"></script>
<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">


<script>
    function openurl(url) {

        location.href = url;
    }
    function openMenu() {
        document.getElementById("fullScreenMenu").style.right = "0";
        document.getElementById("mainContent").style.display = "none";
        document.getElementById("fullScreenMenu").classList.remove("d-none");

    }

    function closeMenu() {
        document.getElementById("fullScreenMenu").style.right = "-100%";
        document.getElementById("fullScreenMenu").classList.add("d-none");
        document.getElementById("mainContent").style.display = "block";
    }
</script>


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

    function addNew() {
        $('#couponDetailModel').modal('show');
        //$('#itemText').val($('#name_'+formFillForEditId).html());

        //document.getElementById("saveButton").disabled=true;
        //document.getElementById("updateButton").disabled=false;

        $('#idForUpdate').val("0");

        document.getElementById("saveButton").disabled = false;
        document.getElementById("updateButton").disabled = true;
    }

    function selectUnder(button) {
        if (isLoggedIn() === false) return;

        var id = $(button).data("id");
        var isActive = $(button).hasClass("selected");

        // Toggle button active state
        if (isActive) {
            $(button).removeClass("selected");
        } else {
            $(button).addClass("selected");
        }

        // Update the display
        $("#undersSelected").html("");
        $(".btn-under.selected").each(function() {
            var text = $(this).text();
            var html = '<span class="text-dark">' + text + '</span>';
            $("#undersSelected").append(html);
        });

        // If the button is not selected, show it as gray
        $(".btn-under").not(".selected").each(function() {
            var text = $(this).text();
            var html = '<span style="color:#d8d8d8">' + text + '</span>';
            $("#undersSelected").append(html);
        });
    }


    function selectMatch(sr) {
        if (isLoggedIn() === false) return;

        var checkbox = $('#cb_match_' + sr);
        var button = $('#btn_match_' + sr);
        var matchInfo = button.siblings('.match-info'); // Get the related match-info span
        var matchName = matchInfo.text().trim(); // Extract match name

        // Toggle the checkbox value
        checkbox.prop("checked", !checkbox.prop("checked"));

        // Toggle button styling based on selection
        if (checkbox.prop("checked")) {
            button.addClass('match-btn-b-c text-dark');
            matchInfo.addClass('match-btn-b-c text-dark');

            // Append the match row to the bet slip container
            addToBetSlip(sr, matchName);
        } else {
            button.removeClass('match-btn-b-c text-dark');
            matchInfo.removeClass('match-btn-b-c text-dark');

            // Remove the match row from the bet slip container
            removeFromBetSlip(sr);
        }

        // Update the selected match count
        updateSelectedMatchCount();
    }

    // Function to add match dynamically to the bet slip
    function addToBetSlip(sr, matchName) {
        if ($("#betSlipRow_" + sr).length === 0) { // Check if it already exists
            var betSlipRow = `
                    <div class="d-flex bg-color-3 align-items-center justify-content-between p-2 my-2 rounded-3" 
                        id="betSlipRow_${sr}">
                        <!-- Left Side (Number & Match Name) -->
                        <div class="d-flex align-items-center">
                            <span class="text-white fw-bold me-2">${sr + 1}</span>
                            <span class="text-white fw-bold">${matchName}</span>
                        </div>

                        <!-- Right Side (Status Button) -->
                        <div>
                            <span class="btn btn-sm fw-bold bg-color-2" 
                                style="border-radius: 8px; padding: 5px 20px; color: #9485f0;">
                                B
                            </span>
                        </div>
                    </div>
                `;
            $("#betSlipContainer").append(betSlipRow);
        }
    }

    // Function to remove match from the bet slip
    function removeFromBetSlip(sr) {
        $("#betSlipRow_" + sr).remove();
    }

    // Function to update selected match count
    function updateSelectedMatchCount() {
        var totalMatchesSelected = $('.match-item input[type="checkbox"]:checked').length;
        $('.countMatchesSelected').text(totalMatchesSelected);
    }


    function stack() {
        if (isLoggedIn() === false) return;
        $("#error").alert('close');

        let isUnderSelected = false;
        let minMatchToSelect = 2;
        let underSelections = {};

        // Loop through all under buttons and check which ones are active (selected)
        $(".btn-under.selected").each(function() {
            let underValue = $(this).data("id");
            underSelections[`under${underValue}`] = 1; // Store the selected values
            isUnderSelected = true;
            minMatchToSelect = Math.max(minMatchToSelect, parseInt(underValue));
        });

        if (!isUnderSelected) {
            alert("Please select from unders!");
            return;
        }

        let minStack = parseInt($("#minStack").text());
        let stackAmount = parseInt($("#stackAmount").val());

        if (stackAmount < minStack) {
            alert("Minimum stack value is " + minStack + " N.");
            return;
        }

        let couponId = $("#couponId").val();
        let couponTypeId = $("#couponTypeId").val();
        let week = $("#week").text();
        let totalMatches = parseInt($("#totalMatches").val());
        let matchesSelected = [];

        let msCount = 0;
        for (let i = 0; i < totalMatches; i++) {
            if ($(`#cb_match_${i}`).prop("checked")) {
                matchesSelected.push($(`#matchId_${i}`).val());
                msCount++;
            }
        }

        if (msCount < minMatchToSelect) {
            alert("Please select minimum " + minMatchToSelect + " matches");
            return;
        }

        let form_data = new FormData();

        // Append selected unders dynamically
        Object.keys(underSelections).forEach(key => form_data.append(key, underSelections[key]));

        form_data.append("stackAmount", stackAmount);
        form_data.append("couponId", couponId);
        form_data.append("couponTypeId", couponTypeId);
        form_data.append("week", week);
        form_data.append("matchesSelected", matchesSelected.join(","));

        $.ajax({
            type: "POST",
            url: "<?= $host ?>/api/placeStack.php",
            processData: false,
            contentType: false,
            data: form_data,
            success: function(response) {
                response = JSON.parse(response);
                if (response.success == "1") {
                    $('#smodalInfoTitle').html("");
                    $('#smodalInfoBody').html(response.message);
                    $('#printTicket').attr('href', 'pdf/transactionReceipt.php?id=' + response.id);
                    $('#smodalInfo').modal('show');
                } else {
                    let html = `<div id="error" class="alert alert-danger fade show" role="alert">${response.message}</div>`;
                    $("#errorContainer").html(html);
                }
            },
            error: function(e) {
                alert(e.status);
                alert(e.responseText);
            }
        });
    }


    function isLoggedIn() {
        <?php
        if ($isLoggedIn) {
            echo "return true;";
        } else {
        ?>
            $('#modalInfoTitle').html("!");
            $('#modalInfoBody').html("Please login first to proceed.");

            $('#modalInfo').modal('show');

            return false;
        <?php } ?>
    }

    function resetPage() {
        location.reload();

    }
</script>

<script>
    $(":radio").change(function() {
        var teamValue = jQuery('input[name=team]:checked').val();
        $.ajax({
            type: 'post',
            url: 'memberNameValue.php',
            data: {
                teamValue: teamValue
            },
            success: function(data) {
                $('#members').html(data);
            }
        });
    });

    $(document).ready(function() {
        /*$('#matchDate').bootstrapMaterialDatePicker
        ({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });*/
        $('#matchDate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $('#closeDate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });

        //$('#matchDateTime').mdtimepicker(); //Initializes the time picker

        $('#DataGrid').dataTable({
            "bLengthChange": false,
            "pageLength": 5,
            responsive: true,
        });
    });

</script>