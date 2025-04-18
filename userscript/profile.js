function showSection(sectionId) {
    console.log(`Clicked section: ${sectionId}`); // Debugging output

    const sidebarItems = document.querySelectorAll(".sidebar ul li");
    const sections = document.querySelectorAll(".section");

    console.log("Found sidebar items:", sidebarItems.length);
    console.log("Found sections:", sections.length);

    // Remove 'active' class from all sidebar items
    sidebarItems.forEach(item => item.classList.remove("active"));

    // Add 'active' class to the clicked sidebar item
    const clickedItem = document.querySelector(`[onclick="showSection('${sectionId}')"]`);
    if (clickedItem) {
        clickedItem.classList.add("active");
        console.log(`Activated sidebar item: ${sectionId}`);
    } else {
        console.warn(`Sidebar item with onclick="showSection('${sectionId}')" not found.`);
    }

    // Hide all sections
    sections.forEach(section => {
        section.classList.remove("active");
        section.style.display = "none"; // Ensure it is hidden
    });

    // Show the selected section
    const activeSection = document.getElementById(sectionId);
    if (activeSection) {
        activeSection.classList.add("active");
        activeSection.style.display = "block"; // Make it visible
        console.log(`Active section: ${sectionId} is now visible`);
    } else {
        console.warn(`Section with ID ${sectionId} not found!`);
    }
}
function editAddress() {
    console.log("✅ Edit button clicked!");

    document.getElementById("address-text").style.display = "none";
    document.getElementById("edit-address-btn").style.display = "none";
    document.getElementById("address-form").style.display = "block";

    console.log("📌 Address form is now visible.");
}

function cancelEdit() {
    console.log("🔄 Cancel button clicked!");

    document.getElementById("address-text").style.display = "inline";
    document.getElementById("edit-address-btn").style.display = "inline-block";
    document.getElementById("address-form").style.display = "none";

    console.log("📌 Address form is now hidden.");
}

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded. Initializing profile page...");

    const editBtn = document.getElementById("edit-address-btn");
    const addressText = document.getElementById("address-text");
    const addressForm = document.getElementById("address-form");
    const cancelBtn = document.getElementById("cancel-btn");

    console.log("Checking elements...");
    console.log("Edit button:", editBtn);
    console.log("Address text:", addressText);
    console.log("Address form:", addressForm);
    console.log("Cancel button:", cancelBtn);

    if (!editBtn) {
        console.error("❌ Edit button NOT found in DOM!");
    }

    if (!addressText) {
        console.error("❌ Address text NOT found in DOM!");
    }

    if (!addressForm) {
        console.error("❌ Address form NOT found in DOM!");
    }

    if (!cancelBtn) {
        console.error("❌ Cancel button NOT found in DOM!");
    }

    if (editBtn && addressText && addressForm && cancelBtn) {
        editBtn.addEventListener("click", function () {
            console.log("✅ Edit button clicked!");
            addressText.style.display = "none"; 
            editBtn.style.display = "none"; 
            addressForm.style.display = "block";
            console.log("📌 Address form is now visible.");
        });

        cancelBtn.addEventListener("click", function () {
            console.log("🔄 Cancel button clicked!");
            addressText.style.display = "inline"; 
            editBtn.style.display = "inline-block"; 
            addressForm.style.display = "none"; 
            console.log("📌 Address form is now hidden.");
        });
    } else {
        console.error("⚠️ One or more elements for address editing are missing!");
    }
    // Show "Personal Details" section by default
    showSection('personal');
});

