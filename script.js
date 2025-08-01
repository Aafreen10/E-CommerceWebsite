document.addEventListener("DOMContentLoaded", () => {
    const signupForm = document.getElementById("signupForm");
    const loginForm = document.getElementById("loginForm");

    if (signupForm) {
        signupForm.addEventListener("submit", (event) => {
            event.preventDefault();
            const name = document.getElementById("signupName").value;
            const password = document.getElementById("signupPassword").value;

            if (name && password) {
                localStorage.setItem("username", name);
                localStorage.setItem("password", password);
                alert("Account Created Successfully! Please Login.");
                window.location.href = "login.html";
            }
            
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", (event) => {
            event.preventDefault();
            const name = document.getElementById("loginName").value;
            const password = document.getElementById("loginPassword").value;

            const storedName = localStorage.getItem("username");
            const storedPassword = localStorage.getItem("password");

            if (name === storedName && password === storedPassword) {
                alert("Login Successful!");
                window.location.href = "home.html"; // Redirect to home (not created yet)
            } else {
                alert("Invalid Credentials. Try Again.");
            }
        });
    }
});