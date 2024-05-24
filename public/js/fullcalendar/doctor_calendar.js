document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    fetch("/doctor/appointments/calendar")
        .then((response) => response.json())
        .then((data) => {
            const events = data.map((event) => ({
                id: event.id,
                title: event.title,
                start: event.start,
                extendedProps: event.extendedProps,
            }));

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: "dayGridMonth",
                events: events,
                eventClick: function (info) {
                    if (info.event.id) {
                        console.log("Event ID:", info.event.id);
                        const appointmentModal =
                            document.getElementById("appointmentModal");
                        if (appointmentModal) {
                            appointmentModal.setAttribute(
                                "data-appointment-id",
                                info.event.id
                            );
                            $(appointmentModal).modal("show");
                        }
                    } else {
                        console.error(
                            "Event ID not found for this event:",
                            info.event
                        );
                    }
                },
                eventContent: function (info) {
                    return {
                        html: `
                            <div class="bg-blue-500 text-white p-2 rounded">
                                <b> Appointment Details</b><br/>
                                <span class="fc-event-time">${info.timeText}</span><br/>
                                <span class="fc-event-title">Patient Name: ${info.event.extendedProps.patientName}</span><br/>
                                <span class="fc-event-title">Start Time: ${info.event.extendedProps.startinghour}</span><br/>
                                <span class="fc-event-title">End Time: ${info.event.extendedProps.endingHour}</span>
                            </div>
                        `,
                    };
                },
                dayMaxEventRows: true,
                dayPopoverFormat: {
                    month: "long",
                    day: "numeric",
                    year: "numeric",
                },
                moreLinkClick: "popover",
                moreLinkClassNames: "my-more-link-class",
                themeSystem: "bootstrap",
                bootstrapFontAwesome: {
                    close: "fa-times",
                    prev: "fa-chevron-left",
                    next: "fa-chevron-right",
                    prevYear: "fa-angle-double-left",
                    nextYear: "fa-angle-double-right",
                },
            });

            calendar.render();
        })
        .catch((error) => {
            console.error("Error fetching appointments:", error);
        });
});

