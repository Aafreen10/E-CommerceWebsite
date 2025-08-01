console.log("signup.js is loaded correctly!");

// Send OTP Function
document.getElementById("send-otp").addEventListener("click", function () {
    let emailInput = document.getElementById("signup-email").value.trim();
    
    if (emailInput === "") {
        alert("Please enter an email to receive OTP!");
        return;
    }

    fetch("send_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `email=${encodeURIComponent(emailInput)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data.includes("OTP sent")) {
            document.getElementById("otp-section").style.display = "block";
            document.getElementById("otp-input").focus();
            document.getElementById("send-otp").style.display = "none";
        }
    })
    .catch(error => console.error("Error sending OTP:", error));
});

// Verify OTP Function
document.getElementById("verify-otp").addEventListener("click", function () {
    let otpInput = document.getElementById("otp-input").value.trim();
    
    if (otpInput === "") {
        alert("Please enter the OTP!");
        return;
    }

    fetch("verify_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `otp=${encodeURIComponent(otpInput)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data.includes("OTP Verified")) {
            document.getElementById("signup-btn").style.display = "block";
            document.getElementById("verify-otp").style.display = "none";
            document.getElementById("otp-section").style.display = "none";
            document.getElementById("signup-btn").disabled = false;
        }
    })
    .catch(error => console.error("Error verifying OTP:", error));
});

// Sign Up Function
document.getElementById("signup-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this); // Collects all form data

    fetch("signup.php", {
        method: "POST",
        body: formData  // Sends form data directly
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data.includes("✅ Account created successfully")) {
            window.location.href = "index.html"; // Redirect to homepage
        }
    })
    .catch(error => console.error("Error signing up:", error));
});
