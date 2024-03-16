<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .chart-container {
            width: 500px;
            /* Adjust width as needed */
            height: 300px;
            /* Adjust height as needed */
            margin: auto;
            /* Center the chart */
            margin-top: 50px;
        }
    </style>
</head>
<div class="chart-container">
    <canvas id="doctorChart" role="img"></canvas>
</div>
<script>
    var ctx = document.getElementById("doctorChart").getContext("2d");
    fetch("{{ route('admin.table.doctors') }}", {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then((response) => response.json())
        .then((data) => {
            console.log("TEST");

            // Initialize counters for each gender
            let maleCount = 0;
            let femaleCount = 0;

            // Count the number of doctors for each gender
            data.forEach((entry) => {
                if (entry.user.gender === 'male') {
                    maleCount++;
                } else if (entry.user.gender === 'female') {
                    femaleCount++;
                }
            });

            // Create the chart using the counted data
            const myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: "Number of Doctors ",
                        data: [maleCount, femaleCount],
                        backgroundColor: [
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(255, 99, 132, 0.2)",
                        ],
                        borderColor: [
                            "rgba(75, 192, 192, 1)",
                            "rgba(255, 99, 132, 1)"
                        ],
                        borderWidth: 1,
                    }, ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 16
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch((error) => console.error("Error fetching data:", error));
</script>
