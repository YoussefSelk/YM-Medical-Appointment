document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm()) {
            this.submit();
        }
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
    const degree = document.getElementById("degree_input").value;
    const speciality = document.getElementById("speciality_input").value;

    // Reset error messages
    document.querySelectorAll(".error_input").forEach(function (errorInput) {
        errorInput.innerText = ""; // Clear previous error messages
    });

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

    if (degree === "") {
        isValid = false;
        document.getElementById("degree_error").innerText =
            "Degree is required";
    }

    if (speciality === "") {
        isValid = false;
        document.getElementById("speciality_error").innerText =
            "Speciality is required";
    }

    return isValid;
}
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const resetButton = form.querySelector('input[type="reset"]');

    resetButton.addEventListener("click", function (event) {
        clearErrors();
        resetForm();
    });

    function clearErrors() {
        document
            .querySelectorAll(".error_input")
            .forEach(function (errorInput) {
                errorInput.innerHTML = ""; // Clear error messages
            });
    }

    function resetForm() {
        const inputs = form.querySelectorAll(
            'input[type="text"], input[type="date"], input[type="email"], input[type="password"], select'
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
});
