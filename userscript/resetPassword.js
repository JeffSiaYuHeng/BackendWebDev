$(document).ready(function() {
    $("#reset-password-form").submit(function(e) {
        e.preventDefault();

        var new_password = $("#new_password").val();
        var confirm_password = $("#confirm_password").val();

        $.post("/BackendWebDev/backend/user/authenticate/resetPassword.php", 
            { new_password: new_password, confirm_password: confirm_password }, 
            function(data) {
                var response = JSON.parse(data);
                alert(response.message);
                if (response.status === "success") {
                    window.location.href = "BackendWebDev/userpage/LoginPage.php";
                }
        });
    });
});