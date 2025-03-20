document.addEventListener("DOMContentLoaded", function () {
    // Element references
    const colorPicker = document.getElementById("colorPicker");
    const fabricPicker = document.getElementById("fabricPicker");
    const previewBox = document.getElementById("previewBox");
    const fabricPreview = document.getElementById("fabricPreview");
    const priceDisplay = document.getElementById("dynamicPrice");
    const basePrice = parseFloat(document.getElementById("basePrice").value);
    const finalPriceInput = document.getElementById("finalPrice");

    // Fabric price adjustments
    const fabricPrices = {
        "None": 0,
        "fabric1": 50,  // Lace adds RM50
        "fabric2": 70,  // Satin adds RM70
        "fabric3": 40,  // Tulle adds RM40
    };

    // Update Preview Box
    function updatePreview() {
        previewBox.style.backgroundColor = colorPicker.value;
        console.log("Color Updated:", colorPicker.value);

        // Reset fabric texture
        fabricPreview.className = "fabric-overlay";
        if (fabricPicker.value !== "None") {
            fabricPreview.classList.add(fabricPicker.value);
        }
    }

    // Update Price
    function updatePrice() {
        const selectedFabric = fabricPicker.value;
        const fabricPrice = fabricPrices[selectedFabric] || 0;
        const newPrice = basePrice + fabricPrice;

        // Update price display
        priceDisplay.textContent = newPrice.toFixed(2);
        // Update hidden input field (so it passes to next page)
        finalPriceInput.value = newPrice.toFixed(2);
    }

    // Event Listeners
    colorPicker.addEventListener("input", updatePreview);
    fabricPicker.addEventListener("change", () => {
        updatePreview();
        updatePrice();
    });

    // Initialize preview and price on page load
    updatePreview();
    updatePrice();
});
