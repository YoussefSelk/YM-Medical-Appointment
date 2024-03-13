function showModal() {
    console.log("showModal function called");
    let modalElement = document.getElementById("create_doctor_modal");
    console.log("Modal Element:", modalElement);

    if (modalElement) {
        // Toggle the 'hidden' class
        modalElement.style.display = "flex";

        // Update the modal_is_showed variable based on the presence of 'hidden' class
        modal_is_showed = modalElement.style.display == "flex" ? true : false;
    } else {
        console.error('Element with ID "create_doctor_modal" not found.');
    }
}
function closeModal() {
    console.log("closeModal function called");
    let modalElement = document.getElementById("create_doctor_modal");
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
