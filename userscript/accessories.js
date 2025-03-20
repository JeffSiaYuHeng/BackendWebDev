document.addEventListener("DOMContentLoaded", function () {
    // Load selected bridal details from localStorage
    const bridalDetails = localStorage.getItem("bridalDetails");
    document.getElementById("selectedBridalDetails").textContent = bridalDetails || "No selection made.";

    // Object to store selected accessories
    const selectedAccessories = {};

    // Function to handle accessory selection
    document.querySelectorAll(".select-btn").forEach(button => {
        button.addEventListener("click", function () {
            const accessory = this.parentElement;
            const category = accessory.getAttribute("data-category");
            const name = accessory.getAttribute("data-name");

            // Toggle selection
            if (selectedAccessories[category] === name) {
                delete selectedAccessories[category];
                this.textContent = "Select";
                accessory.classList.remove("selected");
            } else {
                selectedAccessories[category] = name;
                this.textContent = "Selected";
                accessory.classList.add("selected");
            }
        });
    });

    // Proceed to order button event
    document.getElementById("proceedOrder").addEventListener("click", function () {
        if (Object.keys(selectedAccessories).length === 0) {
            alert("Please select at least one accessory before proceeding.");
            return;
        }
        
        // Save selected accessories to localStorage
        localStorage.setItem("selectedAccessories", JSON.stringify(selectedAccessories));
        
        // Redirect to order confirmation page (change URL accordingly)
        window.location.href = "order.html";
    });
});