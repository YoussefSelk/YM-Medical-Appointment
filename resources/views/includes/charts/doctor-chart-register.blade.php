<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .chart-container {
            width: 600px;
            /* Adjust width as needed */
            height: 400px;
            /* Adjust height as needed */
            margin: auto;
            /* Center the chart */
            margin-top: 50px;
        }
    </style>
</head>
<div class="chart-container">
    <canvas id="doctorChartRegister" role="img"></canvas>
</div>
<script>
    var ctx1 = document.getElementById("doctorChartRegister").getContext("2d");
    fetch("{{ route('admin.table.doctors') }}", {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then((response) => response.json())
        .then((data) => {
            console.log("TEST");

            // Extracting created_at dates and counting doctors for each month
            const doctorCountsByMonth = {};
            data.forEach((entry) => {
                const createdAt = new Date(entry.created_at);
                const monthYear = `${createdAt.getFullYear()}-${createdAt.getMonth() + 1}`;
                if (doctorCountsByMonth[monthYear]) {
                    doctorCountsByMonth[monthYear]++;
                } else {
                    doctorCountsByMonth[monthYear] = 1;
                }
            });

            // Sorting months chronologically
            const sortedMonths = Object.keys(doctorCountsByMonth).sort();

            // Extracting counts for each month
            const counts = sortedMonths.map(month => doctorCountsByMonth[month]);

            // Create the chart using the counted data
            const myChart1 = new Chart(ctx1, {
                type: "line",
                data: {
                    labels: sortedMonths,
                    datasets: [{
                        label: "Number of Doctors Registered",
                        data: counts,
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })
        .catch((error) => console.error("Error fetching data:", error));
</script>
