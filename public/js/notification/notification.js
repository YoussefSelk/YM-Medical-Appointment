$(document).ready(function () {
    var POLL_INTERVAL_MS = 15000;
    var RETRY_INTERVAL_MS = 30000;
    var pollTimer = null;
    var activeRequest = null;
    var lastRenderedSignature = "";
    var dropdown = $("#notificationDropdown ul");
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    if (dropdown.length === 0) {
        return;
    }

    function scheduleNextPoll(delay) {
        if (pollTimer) {
            clearTimeout(pollTimer);
        }
        pollTimer = setTimeout(fetchNotifications, delay);
    }

    function renderNotifications(notifications) {
        var normalized = Array.isArray(notifications) ? notifications : [];
        var signature = JSON.stringify(
            normalized.map(function (n) {
                return [n.id, n.title, n.message];
            })
        );

        if (signature === lastRenderedSignature) {
            return;
        }

        lastRenderedSignature = signature;
        dropdown.empty();

        if (normalized.length === 0) {
            dropdown.append(
                '<li class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">No notifications found</li>'
            );
            return;
        }

        normalized.forEach(function (notification) {
            var safeTitle = escapeHtml(notification.title || "");
            var safeMessage = escapeHtml(notification.message || "");

            dropdown.append(
                '<li class="px-4 py-2">' +
                    '<div class="flex items-center justify-between">' +
                        '<div class="flex-1 pr-4 text-sm leading-tight">' +
                            '<span class="font-semibold text-gray-900 dark:text-white">' + safeTitle + '</span>' +
                            '<span class="block mt-1 text-sm text-gray-600 dark:text-gray-400">' + safeMessage + '</span>' +
                        '</div>' +
                        '<div class="flex-shrink-0">' +
                            '<button type="button" class="read-notification-button focus:outline-none" data-notification-id="' + notification.id + '">' +
                                '<svg class="w-6 h-6 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' +
                                "</svg>" +
                            "</button>" +
                        "</div>" +
                    "</div>" +
                "</li>"
            );
        });
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\"/g, "&quot;")
            .replace(/'/g, "&#39;");
    }

    function fetchNotifications() {
        if (document.hidden) {
            scheduleNextPoll(POLL_INTERVAL_MS);
            return;
        }

        if (activeRequest) {
            return;
        }

        activeRequest = $.ajax({
            url: "/notifications",
            type: "GET",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        })
            .done(function (response) {
                renderNotifications(response.notifications);
                scheduleNextPoll(POLL_INTERVAL_MS);
            })
            .fail(function (xhr) {
                console.error(xhr.responseText);
                scheduleNextPoll(RETRY_INTERVAL_MS);
            })
            .always(function () {
                activeRequest = null;
            });
    }

    fetchNotifications();

    $("#notificationDropdownMenuButton").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropdown.toggleClass("hidden");
    });

    $(document).on("click", function () {
        dropdown.addClass("hidden");
    });

    $("#notificationDropdown").on("click", function (e) {
        e.stopPropagation();
    });

    $(document).on("click", ".read-notification-button", function () {
        var notificationId = $(this).data("notification-id");
        var currentButton = $(this);

        $.ajax({
            url: "/notifications/" + notificationId + "/mark-as-read",
            type: "PUT",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function () {
                currentButton.closest("li").remove();
                if ($(".read-notification-button").length === 0) {
                    dropdown.html(
                        '<li class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">No notifications found</li>'
                    );
                    lastRenderedSignature = "";
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            },
        });
    });
});
