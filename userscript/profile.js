
    function showSection(sectionId) {
        console.log(`Clicked section: ${sectionId}`); // Debugging output

        const sidebarItems = document.querySelectorAll(".sidebar ul li");
        const sections = document.querySelectorAll(".section");

        // Remove 'active' class from all sidebar items
        sidebarItems.forEach(item => item.classList.remove("active"));

        // Add 'active' class to the clicked sidebar item
        document.querySelector(`[onclick="showSection('${sectionId}')"]`).classList.add("active");

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

    document.addEventListener("DOMContentLoaded", function () {
        console.log("JavaScript is connected!"); // Debugging output
        showSection('personal'); // Show default section on page load
    });

