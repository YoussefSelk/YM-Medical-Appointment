function showEditModal(doctorId) {
    console.log("showModal function called with doctor ID:", doctorId);
    let modalElement = document.getElementById("edit_doctor_modal");
    console.log("Modal Element:", modalElement);

    if (modalElement) {
        // Set the doctor's ID in the hidden input field
        let doctorIdInput = modalElement.querySelector("#editDoctorId");
        if (doctorIdInput) {
            doctorIdInput.value = doctorId;
        } else {
            console.error(
                'Input field with ID "editDoctorId" not found in the modal.'
            );
        }

        // Toggle the modal display
        modalElement.style.display = "flex";

        // Update the modal_is_showed variable
        modal_is_showed = true;
    } else {
        console.error('Element with ID "edit_doctor_modal" not found.');
    }
}

function closeEditModal() {
    console.log("closeModal function called");
    let modalElement = document.getElementById("edit_doctor_modal");
    console.log("Modal Element:", modalElement);
    if (modalElement) {
        // Toggle the 'hidden' class
        modalElement.style.display = "none";
        // Update the modal_is_showed variable based on the presence of 'hidden' class
        modal_is_showed = modalElement.style.display == "flex" ? true : false;
    } else {
        console.error('Element with ID "create_doctor_modal" not found.');
    }
}
