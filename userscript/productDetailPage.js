const colorPicker = document.getElementById("colorPicker");
const fabricPicker = document.getElementById("fabricPicker");
const previewBox = document.getElementById("previewBox");
const fabricPreview = document.getElementById("fabricPreview");

// Function to Update Preview Box
function updatePreview() {
    const selectedColor = colorPicker.value;
    previewBox.style.backgroundColor = selectedColor;
    console.log("Color Updated:", selectedColor);

    // Reset fabric texture
    fabricPreview.className = "fabric-overlay"; 
    if (fabricPicker.value !== "none") {
        fabricPreview.classList.add(fabricPicker.value);
    }
}

// Event Listeners
colorPicker.addEventListener("change", updatePreview);
fabricPicker.addEventListener("change", updatePreview);
