<head>
    <style>
        .button {
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            border: none;
            background: none;
            color: #0f1923;
            cursor: pointer;
            position: relative;
            padding: 8px;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            transition: all .15s ease;
        }

        .button::before,
        .button::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            left: 0;
            height: calc(50% - 5px);
            border: 1px solid #7D8082;
            transition: all .15s ease;
        }

        .button::before {
            top: 0;
            border-bottom-width: 0;
        }

        .button::after {
            bottom: 0;
            border-top-width: 0;
        }

        .button:active,
        .button:focus {
            outline: none;
        }

        .button:active::before,
        .button:active::after {
            right: 3px;
            left: 3px;
        }

        .button:active::before {
            top: 3px;
        }

        .button:active::after {
            bottom: 3px;
        }

        .button_lg {
            position: relative;
            display: block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0f1923;
            overflow: hidden;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .button_lg::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 2px;
            background-color: #0f1923;
        }

        .button_lg::after {
            content: '';
            display: block;
            position: absolute;
            right: 0;
            bottom: 0;
            width: 4px;
            height: 4px;
            background-color: #0f1923;
            transition: all .2s ease;
        }

        .button_sl {
            display: block;
            position: absolute;
            top: 0;
            bottom: -1px;
            left: -8px;
            width: 0;
            background-image: linear-gradient(to bottom right, #00c6ff,
                    #0072ff);
            transform: skew(-15deg);
            transition: all .2s ease;
        }

        .button_text {
            position: relative;
        }

        .button:hover {
            color: #0f1923;
        }

        .button:hover .button_sl {
            width: calc(100% + 15px);
        }

        .button:hover .button_lg::after {
            background-color: #fff;
        }
    </style>
</head>
<button id="downloadButton" class="button">
    <span class="button_lg">
        <span class="button_sl"></span>
        <span class="button_text">Download Now</span>
    </span>
</button>
<script>
    const downloadButton = document.getElementById("downloadButton");
    const route = "{{ $route }}";

    downloadButton.addEventListener("click", function() {
        // Disable the button to prevent multiple clicks
        this.disabled = true;

        // Change button text to indicate the process
        this.querySelector(".button_text").innerText = "Downloading...";

        // Redirect to Laravel route
        window.location.href = route;

        // Reload the page after a delay (adjust the delay as needed)
        setTimeout(function() {
            window.location.reload();
        }, 1500); // 5000 milliseconds = 5 seconds, adjust as needed
    });
</script>
