document.addEventListener("DOMContentLoaded", function () {
    var appointmentModal = document.getElementById("appointmentModal");
    var appointmentDetails = document.getElementById("appointmentDetails");

    $("#appointmentModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var appointmentId = button.data("appointment-id"); // Extract info from data-* attributes

        // Fetch appointment details from backend
        fetch("/doctor/appointments/" + appointmentId)
            .then((response) => response.json())
            .then((data) => {
                // Display appointment details in modal body
                appointmentDetails.innerHTML = `
                    <b>Title: ${data.title}</b><br/>
                    <span>Start: ${data.start}</span><br/>
                    <span>Patient Name: ${data.extendedProps.patientName}</span><br/>
                    <span>Appointment Date: ${data.extendedProps.appointmentDate}</span><br/>
                    <span>Reason: ${data.extendedProps.reason}</span><br/>
                    <span>Doctor Name: ${data.extendedProps.doctorName}</span>
                `;
            })
            .catch((error) => {
                console.error("Error fetching appointment details:", error);
            });
    });
});
