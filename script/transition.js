window.transitionToPage = function (href) {
    const body = document.querySelector('body');

    // Disable interactions
    body.style.pointerEvents = "none";

    // Ensure animation runs fully before navigating
    body.style.transition = "opacity 0.5s ease-out";
    body.style.opacity = 0;

    // Wait for the transition to complete before changing the page
    setTimeout(() => {
        window.location.href = href;
    }, 500);
};

document.addEventListener('DOMContentLoaded', function (event) {
    const body = document.querySelector('body');
    body.style.opacity = 0;
    
    // Ensure transition applies smoothly after page load
    requestAnimationFrame(() => {
        body.style.transition = "opacity 0.5s ease-in";
        body.style.opacity = 1;
        
        // Re-enable interactions after animation completes
        setTimeout(() => {
            body.style.pointerEvents = "auto";
        }, 500);
    });
});
