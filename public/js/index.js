function submitLoginForm() {
    if (document.querySelector("#user-remember").checked) {
        // Assign cookie value
        document.cookie = "rememberedUser=" + document.querySelector("#user-id").value;
        document.cookie = "rememberedPass=" + document.querySelector("#user-pass").value;
    } else {
        // Delete cookie value
        document.cookie = "rememberedUser=";
        document.cookie = "rememberedPass=";
    }
    if (document.querySelector("#user-id").checkValidity() && document.querySelector("#user-pass").checkValidity())
        document.querySelector("#main-login-form").submit();
}