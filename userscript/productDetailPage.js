document.addEventListener("DOMContentLoaded", function () {
    // Element references
    const previewBox = document.getElementById("previewBox");
    const priceDisplay = document.getElementById("dynamicPrice");
    const basePrice = parseFloat(document.getElementById("basePrice").value);
    const finalPriceInput = document.getElementById("finalPrice");

    // Update Price
    function updatePrice() {
        const newPrice = basePrice;
        
        // Update price display
        priceDisplay.textContent = newPrice.toFixed(2);
        // Update hidden input field (so it passes to next page)
        finalPriceInput.value = newPrice.toFixed(2);
    }

    // Initialize price on page load
    updatePrice();
});
