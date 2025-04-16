

function toggleViewResult() {
    let matchInfos = document.querySelectorAll(".match-info"); // Select all match-info elements
    let toggle = document.getElementById("toggle");
    var label = document.getElementById("toggleLabel");
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
    // var toggle = document.getElementById("toggle");
}