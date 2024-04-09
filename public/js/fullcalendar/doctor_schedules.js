document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridWeek",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "timeGridWeek,timeGridDay",
        },
        firstDay: 1, // Set Monday as the first day of the week
        events: {
            url: "/doctor/schedules/index", // Endpoint to fetch schedules
            method: "GET",
            failure: function () {
                console.error("Error fetching schedules.");
            },
            // Custom function to parse the response data
            eventDataTransform: function (eventData) {
                return {
                    id: eventData.id,
                    title: eventData.title,
                    start: eventData.start,
                    end: eventData.end,
                };
            },
        },
    });

    calendar.render();
});
