
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".account-tabs button");
    const form = document.getElementById("loginForm");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const emailGroup = document.getElementById("emailGroup");
    const passwordGroup = document.getElementById("passwordGroup");
    const togglePassword = document.getElementById("togglePassword");
    const message = document.getElementById("formMessage");
    const registerText = document.getElementById("registerText");
    const forgotPassword = document.getElementById("forgotPassword");

    let selectedRole = "customer";

    function showMessage(text) {
        message.textContent = text;
        message.classList.add("show");
    }

    function clearMessage() {
        message.textContent = "";
        message.classList.remove("show");
    }

    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            tabs.forEach(function (item) {
                item.setAttribute(
                    "aria-selected",
                    item === tab ? "true" : "false"
                );
            });

            selectedRole = tab.dataset.role;

            registerText.style.display =
                selectedRole === "admin" ? "none" : "block";

            forgotPassword.style.display =
                selectedRole === "admin" ? "none" : "inline";

            clearMessage();
        });
    });

    togglePassword.addEventListener("click", function () {
        const shouldShow = password.type === "password";

        password.type = shouldShow ? "text" : "password";

        togglePassword.setAttribute(
            "aria-label",
            shouldShow ? "Sembunyikan kata sandi" : "Tampilkan kata sandi"
        );
    });

    email.addEventListener("input", function () {
        emailGroup.classList.remove("has-error");
        clearMessage();
    });

    password.addEventListener("input", function () {
        passwordGroup.classList.remove("has-error");
        clearMessage();
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        clearMessage();

        const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
            email.value.trim()
        );

        const validPassword = password.value.length > 0;

        emailGroup.classList.toggle("has-error", !validEmail);
        passwordGroup.classList.toggle("has-error", !validPassword);

        if (!validEmail || !validPassword) {
            showMessage("Periksa kembali email dan kata sandi kamu.");
            return;
        }

        showMessage(
            "Tampilan berhasil diuji. Login belum terhubung ke autentikasi Laravel."
        );
    });

    document.getElementById("registerLink").addEventListener("click", function (event) {
        event.preventDefault();
        showMessage("Halaman pendaftaran pelanggan belum dibuat.");
    });

    forgotPassword.addEventListener("click", function (event) {
        event.preventDefault();
        showMessage("Fitur lupa kata sandi belum tersedia.");
    });
});
