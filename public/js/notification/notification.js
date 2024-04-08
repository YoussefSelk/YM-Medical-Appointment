$(document).ready(function () {
    // Function to fetch notifications
    function fetchNotifications() {
        // Get CSRF token value from meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/notifications", // URL to your Laravel route for fetching notifications
            type: "GET",
            dataType: "json",
            headers: {
                // Include CSRF token in the headers
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                // Clear previous notifications
                $("#notificationDropdown ul").empty();

                // Check if notifications object exists and is not empty
                if (
                    response.notifications &&
                    Object.keys(response.notifications).length > 0
                ) {
                    // Append new notifications
                    Object.values(response.notifications).forEach(function (
                        notification
                    ) {
                        $("#notificationDropdown ul").append(
                            `<li class="px-4 py-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 pr-4 text-sm leading-tight">
                                        <span class="font-semibold text-gray-900 dark:text-white">${notification.title}</span>
                                        <span class="block mt-1 text-sm text-gray-600 dark:text-gray-400">${notification.message}</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button class="read-notification-button focus:outline-none" data-notification-id="${notification.id}">
                                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>`
                        );
                    });
                } else {
                    // Display a message if there are no notifications
                    $("#notificationDropdown ul").append(
                        `<li class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">No notifications found</li>`
                    );
                }

                // After displaying notifications, initiate the next AJAX call after a short delay
                setTimeout(fetchNotifications, 5000); // Fetch notifications every 5 seconds
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);

                // Retry after a short delay
                setTimeout(fetchNotifications, 5000); // Retry after 5 seconds
            },
        });
    }

    // Call fetchNotifications function when document is ready
    fetchNotifications();

    // Toggle dropdown menu
    $("#notificationDropdownMenuButton").click(function () {
        $("#notificationDropdown ul").toggleClass("hidden");
    });

    // Handle click event on read notification button
    $(document).on("click", ".read-notification-button", function () {
        // Get the notification ID from the button's data attribute
        var notificationId = $(this).data("notification-id");

        // Get CSRF token value from meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        // AJAX request to mark the notification as read
        $.ajax({
            url: "/notifications/" + notificationId + "/mark-as-read", // URL to your Laravel route for marking a notification as read
            type: "PUT", // Use PUT method for updating the notification status
            dataType: "json",
            headers: {
                // Include CSRF token in the headers
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                // Display a success message or update UI if needed
                console.log(response.message);
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            },
        });
    });
});
