// Purpose: Contains the javascript for the forgot password page.
$(document).ready(function() {
    // Handle email submission
    $("#email-form").submit(function(e) {
        e.preventDefault();
        var email = $("#email").val();

        $.post("/backend/forgotPassword.php", { email: email }, function(data) {
            var response = JSON.parse(data);
            if (response.status === "success") {
                $("#safe-key-question").text(response.question);
                $("#safe-key-section").show();
                $("#email-form").hide();
            } else {
                alert(response.message);
            }
        });
    });

    // Handle safe key verification
    $("#verify-safe-key").click(function() {
        var safe_key_answer = $("#safe_key_answer").val();

        $.post("/backend/verifySafeKey.php", { safe_key_answer: safe_key_answer }, function(data) {
            var response = JSON.parse(data);
            if (response.status === "success") {
                alert(response.message);
                window.location.href = "/userpage/resetPassword.php";
            } else {
                alert(response.message);
            }
        });
    });
});
    