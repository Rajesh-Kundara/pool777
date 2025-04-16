// function toggleView() {
//     let matchContainer = document.getElementById("matchContainer");
//     if (document.getElementById("toggle").checked) {
//         matchContainer.classList.remove("view-team-name");
//     } else {
//         matchContainer.classList.add("view-numbers-only");
//     }
// }

// function toggleView() {
//     let matchInfos = document.querySelectorAll(".match-info"); 
//     let toggle = document.getElementById("toggle");
//     var label = document.getElementById("toggleLabel");
//     var num = document.querySelectorAll(".numberList");
//     var numadd = document.querySelectorAll(".addNumber");
//     matchInfos.forEach(matchInfo => {
//         if (toggle.checked) {
//             num.classList.add('d-none');
//             matchInfo.classList.remove("d-none"); 
//             numadd.classList.remove("d-none");
//             label.textContent = "View Number Only";
//         } else {
//             num.classList.remove('d-none');
//             matchInfo.classList.add("d-none"); 
//             numadd.classList.add("d-none");
//             label.textContent = "View Team Name";
//         }
//     });
  
   
   
// }

function toggleView() {
    let matchInfos = document.querySelectorAll(".match-info");
    let toggle = document.getElementById("toggle");
    let label = document.getElementById("toggleLabel");
    let numList = document.querySelectorAll(".numberList");

    if (toggle.checked) {
        numList.forEach(num => {
            num.classList.remove('col-auto'); // Remove Bootstrap column class
            num.classList.add('d-flex', 'w-50', 'mb-2'); // Add new classes for layout

            // Select the button inside the current numberList
            let btn = num.querySelector("button.match-btn");
            if (btn) {
                btn.classList.add('mx-1', 'custom-match-btn');
            }

            // Select the span inside the current numberList
            let matchInfo = num.querySelector("span.match-info");
            if (matchInfo) {
                matchInfo.classList.add("mx-1", "custom-match-info");
                matchInfo.classList.remove("d-none"); // Show team names
                matchInfo.style.width = "83%"; // Set span width to 80%
            }
        });

        label.textContent = "View Number Only";
    } else {
        numList.forEach(num => {
            num.classList.add('col-auto'); // Restore Bootstrap column class
            num.classList.remove('d-flex', 'w-50', 'mb-2'); // Remove added classes

            // Select the button inside the current numberList
            let btn = num.querySelector("button.match-btn");
            if (btn) {
                btn.classList.remove('mx-1', 'custom-match-btn'); 
            }

            // Select the span inside the current numberList
            let matchInfo = num.querySelector("span.match-info");
            if (matchInfo) {
                matchInfo.classList.add("d-none","mx-1"); // Hide team names
                matchInfo.classList.remove("custom-match-info"); // Hide team names
            }
        });

        label.textContent = "View Team Name";
    }
}


// Function to Open Popup
// Function to Open Popup
function openPopup() {
    let popup = document.getElementById("oddsPopup");
    if (!popup) {
        console.error("Error: Element with ID 'oddsPopup' not found.");
        return; // Exit function if popup doesn't exist
    }
    popup.style.display = "flex";  
    popup.classList.remove('d-none');  
}

// Function to Close Popup
function closePopup() {
    let popup = document.getElementById("oddsPopup");
    if (!popup) {
        console.error("Error: Element with ID 'oddsPopup' not found.");
        return;
    }
    popup.style.display = "none";  
    popup.classList.add('d-none');  
}


// q popup
function qopenPopup() {
    let popup = document.getElementById("qPopup");
    if (!popup) {
        console.error("Error: Element with ID 'oddsPopup' not found.");
        return; // Exit function if popup doesn't exist
    }
    popup.style.display = "flex";  
    popup.classList.remove('d-none');  
}

// Function to Close Popup
function qclosePopup() {
    let popup = document.getElementById("qPopup");
    if (!popup) {
        console.error("Error: Element with ID 'oddsPopup' not found.");
        return;
    }
    popup.style.display = "none";  
    popup.classList.add('d-none');  
}

function openBetslip(){
    document.getElementById("fullScreenBetslip").style.right = "0";
    document.getElementById("mainContent").style.display = "none";
    document.getElementById("fullScreenBetslip").classList.remove("d-none");
}
function closeBetslip() {
    document.getElementById("fullScreenBetslip").style.right = "-100%";
    document.getElementById("fullScreenBetslip").classList.add("d-none");
    document.getElementById("mainContent").style.display = "block";
}