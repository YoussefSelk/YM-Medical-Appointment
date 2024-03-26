document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");

    // Prevent default form submission and validate form
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm()) {
            this.submit();
        }
    });

    // Reset button event listener
    const resetButton = form.querySelector('input[type="reset"]');
    resetButton.addEventListener("click", function (event) {
        clearErrors();
        resetForm();
    });
});

function validateForm() {
    let isValid = true;
    const nom = document.getElementById("nom_input").value.trim();
    const birthday = document.getElementById("birthday_input").value;
    const city = document.getElementById("city_input").value.trim();
    const rue = document.getElementById("rue_input").value.trim();
    const email = document.getElementById("email_input").value.trim();
    const password = document.getElementById("password_input").value.trim();
    const phone = document.getElementById("phone_input").value.trim();
    const gender = document.getElementById("gender_input").value;
    const cin = document.getElementById("cin_input").value.trim();

    // Reset error messages
    clearErrors();

    // Validation rules
    if (nom === "") {
        isValid = false;
        document.getElementById("nom_error").innerText = "Name is required";
    }

    if (birthday === "") {
        isValid = false;
        document.getElementById("birthday_error").innerText =
            "Birthday is required";
    }

    if (city === "") {
        isValid = false;
        document.getElementById("city_error").innerText = "City is required";
    }

    if (rue === "") {
        isValid = false;
        document.getElementById("rue_error").innerText = "Street is required";
    }

    if (email === "") {
        isValid = false;
        document.getElementById("email_error").innerText = "Email is required";
    }

    if (password === "") {
        isValid = false;
        document.getElementById("password_error").innerText =
            "Password is required";
    }

    if (phone === "") {
        isValid = false;
        document.getElementById("phone_error").innerText =
            "Phone number is required";
    }

    if (gender === "") {
        isValid = false;
        document.getElementById("gender_error").innerText =
            "Gender is required";
    }

    if (cin === "") {
        isValid = false;
        document.getElementById("cin_error").innerText = "CIN is required";
    }

    return isValid;
}

function clearErrors() {
    document.querySelectorAll(".error_input").forEach(function (errorInput) {
        errorInput.innerText = ""; // Clear error messages
    });
}

function resetForm() {
    const form = document.getElementById("form");
    const inputs = form.querySelectorAll(
        'input[type="text"], input[type="date"], input[type="email"], input[type="password"], input[type="number"], select'
    );
    inputs.forEach(function (input) {
        // Clear input values
        if (input.tagName === "SELECT") {
            // Reset select element to its initial state
            input.selectedIndex = 0;
        } else {
            // Reset input values to an empty string
            input.value = "";
        }
    });
}
