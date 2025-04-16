function selectBanker(btn) {
    // Remove 'selected' class from all buttons
    document.querySelectorAll('.btn-banker').forEach(button => {
        button.classList.remove('selected');
    });

    // Add 'selected' class to the clicked button
    btn.classList.add('selected');

    // Get the selected banker name and update the span
    document.getElementById('bankerType').textContent = btn.textContent;
    document.getElementById('selectedBankerId').value = btn.getAttribute('data-id');

    var des = $('#description_' + document.getElementById('selectedBankerId').value).val();
    $('#description').parent().removeClass('d-none'); // Corrected classList issue
    $('#description').text(des); // Corrected value assignment

}
// Store selected numbers in an array
var selectedNumbers = [];

function selectMatchLotto(sr) {
    if (isLoggedIn() === false) return;

    var checkbox = $('#cb_match_' + sr);
    var button = $('#btn_match_' + sr);
    
    // Toggle the checkbox value
    checkbox.prop("checked", !checkbox.prop("checked"));

    // Toggle button styling based on selection
    if (checkbox.prop("checked")) {
        button.addClass('match-btn-b-c text-white');
        addNumber(sr); // Add selected number
    } else {
        button.removeClass('match-btn-b-c text-white');
        removeNumber(sr); // Remove unselected number
    }

    // Update the selected match count
    updateSelectedMatchCount();
}

// Function to add a selected number
function addNumber(number) {
    if (!selectedNumbers.includes(number)) {
        selectedNumbers.push(number);
    }
    updateSelectedNumbers();
}

// Function to remove an unselected number
function removeNumber(number) {
    selectedNumbers = selectedNumbers.filter(num => num !== number);
    updateSelectedNumbers();
}

// Function to update the displayed selected numbers
function updateSelectedNumbers(){
    $('#selectedNumbers').text(selectedNumbers.join(', '));
}


function stackLoto() {
    if (isLoggedIn() === false) return;
    $("#error").alert('close');

    let isBankerSelected = false;
    // let minMatchToSelect = 2;
    // let underSelections = {};

    // Loop through all under buttons and check which ones are active (selected)
    // $(".btn-under.selected").each(function () {
    //     let underValue = $(this).data("id");
    //     underSelections[`under${underValue}`] = 1; 
    //     isUnderSelected = true;
    //     minMatchToSelect = Math.max(minMatchToSelect, parseInt(underValue));
    // });

    // if (!isUnderSelected) {
    //     alert("Please select from unders!");
    //     return;
    // }

    let selectedBankerId = $("#selectedBankerId").val();
    let selectedNumbers = $("#selectedNumbers").text().trim();
    let numbersArray = selectedNumbers ? selectedNumbers.split(", ") : [];
    let count = numbersArray.length;
    let stackAmount = $("#stackAmount").val();

    var minSelectedNo = $("#minSelectedNo_"+selectedBankerId).val();
    var minStackValue = $("#minStack_"+selectedBankerId).val();
    if(count < minSelectedNo){
        $("#alert").removeClass("d-none").addClass("d-block"); // Show alert
        $("#alert").html("Please select at least " + minSelectedNo + " numbers"); // Set message
        
        // Hide alert after 5 seconds
        setTimeout(function () {
            $("#alert").removeClass("d-block").addClass("d-none");
        }, 5000);
        return;
    }
    if(minStackValue >= stackAmount){
    // if(300 >= 2){
        $("#alert").removeClass("d-none").addClass("d-block"); // Show alert
        $("#alert").html("Minimum stack value is " + minStackValue + " N"); // Set message
        
        // Hide alert after 5 seconds
        setTimeout(function () {
            $("#alert").removeClass("d-block").addClass("d-none");
        }, 5000);
        return;
    }
// alert(selectedNumbers);


    if(selectedBankerId == ''){
        let html = `<div id="error" class="alert alert-danger fade show" role="alert">Please select from bankers!</div>`;
                $("#errorContainer").html(html);
       
    }
    if(selectedNumbers == ''){
        let html = `<div id="error" class="alert alert-danger fade show" role="alert">Please select numbers!</div>`;
                $("#errorContainer").html(html);
       
    }
    let form_data = new FormData();
    
    // Append selected unders dynamically
    // Object.keys(underSelections).forEach(key => form_data.append(key, underSelections[key]));

    form_data.append("stackAmount", stackAmount);
    form_data.append("selectedBankerId", selectedBankerId);
    form_data.append("selectedNumbers", selectedNumbers);

    $.ajax({
        type: "POST",
        url: "api/lotto.php",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (response) {
            response = JSON.parse(response);
            if (response.success == "1") {
                $('#smodalInfoTitle').html("Success!");
                $('#smodalInfoBody').html(response.message);
                $('#smodalInfo').modal('show');
            } else {
                let html = `<div id="error" class="alert alert-danger fade show" role="alert">${response.message}</div>`;
                $("#errorContainer").html(html);
            }
        },
        error: function (e) {
            alert(e.status);
            alert(e.responseText);
        }
    });
}

