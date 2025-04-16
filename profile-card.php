  <!-- Full-Screen Menu -->
     <!-- Full-Screen Menu -->
<div id="fullScreenMenu" class="d-none">
    <div class="menu-card-first  px-5 pt-2">
        <div class="d-flex justify-content-between mt-2 align-items-center">
            <span id="closeMenu" onclick="closeMenu()">&times;</span> <!-- Close Button -->
            <?php 
                if(!isset($_SESSION['fullname']) ){
            ?>
                    <a  href="login.php" class="btn  btn-sm text-white justify-content-right " type="button"  >
                    <i id="dLabel" class="fa-solid fa-arrow-right-to-bracket"></i>
                </a>
                  
            <?php

                }else{
            ?>
                
                        <a class="text-white text-decoration-none" href="logout.php"><i class="pe-1 fa-solid fa-arrow-right-from-bracket"></i><span style="font-size: 10px;padding-left: 3px;">LOGOUT</span></a>
            
            <?php } ?>
        </div>
        <div class="row mt-5">
            <div class="col-4">
            <img src="images/profile-image.png" alt="Profile Image" class="rounded-circle profile-t-image">
            </div>
            <div class="col-8">
                <h5 class="text-white"><?=(!isset($_SESSION['fullname']))?'Name':$_SESSION['fullname']?> <a href="profileEdit.php"><i class="fa fa-edit text-white ps-2 " style="font-size: 12px;"></i></a></h5>
                <h5 class="text-white"><?=(!isset($_SESSION['username']))?'Username':$_SESSION['username']?> </h5>
            </div>
        </div>
        
        

        <?php
            if(isset($_SESSION['fullname']) ){
        ?>
            <div class="row pb-2">
                <div class="col-6">
                    <a class="btn btn-success w-100 rounded-pill fw-bold" href="deposit.php">Deposit</a>
                </div>
                <div class="col-6">
                    <a id="requestWithdraw" class="btn bg-color-1 w-100  fw-bold rounded-pill font-color-1" href="request_withdraw.php">Withdrawal</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="menu-card-second p-3">
        <!-- Progress Section -->
        <div class="text-white p-3 rounded-4 d-flex justify-content-between align-items-center shadow-lg" style="background-color: #002F9A;">
            <div class="w-100">
                <!-- Top Section -->
                <div class="d-flex justify-content-between">
                    <small>Level 5 Player</small>
                    <small>456/7000</small>
                </div>
                
                <!-- Middle Text -->
                <div class="mt-1">
                    <span class="fw-bold">Play 5 More Tickets to get Reward</span>
                </div>

                <!-- Progress Bar -->
                <div class="progress mt-2 bg-white d-none" style="height: 8px;">
                    <div class="progress-bar  rounded-pill" style="width: 40%; background-color:#ed1f8e;"></div>
                </div>
            </div>

            <!-- Gift Icon -->
            <div class="ms-3 d-flex flex-column align-items-center">
                <i class="bi bi-gift-fill fs-3"></i>
                <small>Reward</small>
            </div>
        </div>

        <!-- Menu Items -->
        <ul class="list-group mt-4 px-1">
            <li class="bg-color-1 list-group-item lgi-c mb-3 cursor-pointer d-flex justify-content-between align-items-center rounded shadow-sm" onclick="openurl('bet_history.php')">
                 <div>
                 <i class="fa-solid fa-gear"></i> <label class="ps-2 fw-semibold">Bet History </label>
                 </div>
                 <div>
                 <i class="fa-solid fa-play"></i>
                 </div>
               
                
            </li>
            <li class="bg-color-1 list-group-item lgi-c mb-3 cursor-pointer d-flex justify-content-between align-items-center rounded shadow-sm" onclick="openurl('transactions.php')">
                <div>
                    <i class="fa-solid fa-clock-rotate-left"></i> <label class="ps-2 fw-semibold"> Transaction History </label>
                </div>
                <div>
                <i class="fa-solid fa-play"></i>
                </div>
            
            </li>
            <li class="bg-color-1 list-group-item lgi-c mb-3 d-flex cursor-pointer justify-content-between align-items-center rounded shadow-sm" onclick="openurl('index.php')">
            <div>
            <i class="bi bi-chat-left-text-fill"></i> </i> <label class="px-2 fw-semibold">Messages </label><label class=" badge bg-color-2">4</label>
                </div>
                <div>
                
                <i class="fa-solid fa-play"></i>
                </div>
                
            </li>
            <li class="bg-color-1 list-group-item lgi-c mb-3 cursor-pointer d-flex justify-content-between align-items-center rounded shadow-sm" onclick="openurl('result.php')">
            <div>
            <i class="fa-solid fa-square-poll-horizontal"></i> </i> <label class="ps-2 fw-semibold">Results </label>
                </div>
                <div>
                <i class="fa-solid fa-play"></i>
                </div>
               
            </li>
            <li class="bg-color-1 list-group-item lgi-c mb-3 cursor-pointer d-flex justify-content-between align-items-center rounded shadow-sm" onclick="openurl('accountDetail.php')">
            <div>
            <i class="bi bi-person-lines-fill"></i> </i> <label class="ps-2 fw-semibold">Account </label>
                </div>
                <div>
                <i class="fa-solid fa-play"></i>
                </div>

            </li>
            <li class="bg-color-1 list-group-item lgi-c mb-3 cursor-pointer d-flex justify-content-between align-items-center rounded shadow-sm" onclick="openurl('changePassword.php')">
            <div>
            <i class="fa-solid fa-key"></i> </i> <label class="ps-2 fw-semibold">Change Password </label>
                </div>
                <div>
                <i class="fa-solid fa-play"></i>
                </div>
                
                </a>
            </li>
        </ul>
    </div>
</div>