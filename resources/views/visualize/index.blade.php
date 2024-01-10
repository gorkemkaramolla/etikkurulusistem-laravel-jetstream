<x-app-layout>
    <div class="flex justify-center w-full flex-col items-center">
        <div id="chartsContainer" class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Charts will be added here dynamically -->
        </div>
        <div class="flex absolute top-0 right-0 gap-4">
            <!-- Dynamically create a dropdown with checkboxes for each column in your data -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Select Columns
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute z-10 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                    style="height: 400px; overflow-y: auto;">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        @if ($forms && $forms->first())
                            @foreach ($forms->first()->getAttributes() as $column => $value)
                                <div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    role="menuitem">
                                    <label>
                                        <input type="checkbox" id="{{ $column }}_checkbox">
                                        {{ ucfirst($column) }}
                                        <select id="{{ $column }}_chart_type">
                                            <option value="bar">Bar</option>
                                            <option value="pie">Pie</option>
                                            <!-- Add more chart types as needed -->
                                        </select>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <button id="visualize_button" class="bg-blue-500 text-white px-4 py-2 rounded ml-4">Visualize</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Convert collection to array
            const formsArray = {!! $forms->toJson() !!};

            // Load previously selected columns from localStorage
            const selectedColumns = JSON.parse(localStorage.getItem('selectedColumns')) || [];
            selectedColumns.forEach(column => {
                document.getElementById(`${column}_checkbox`).checked = true;
            });

            // Initialize charts based on the selected columns
            initializeCharts();

            // Listen for button click
            document.getElementById('visualize_button').addEventListener('click', function() {
                // Clear the charts container
                document.getElementById('chartsContainer').innerHTML = '';

                // Dynamically check which checkboxes are checked and create a chart for
                @if ($forms && $forms->first())

                    @foreach ($forms->first()->getAttributes() as $column => $value)
                        if (document.getElementById('{{ $column }}_checkbox').checked) {
                            createChart('{{ $column }}', document.getElementById(
                                '{{ $column }}_chart_type').value);
                            if (!selectedColumns.includes('{{ $column }}')) {
                                selectedColumns.push('{{ $column }}');
                            }
                        } else {
                            const index = selectedColumns.indexOf('{{ $column }}');
                            if (index > -1) {
                                selectedColumns.splice(index, 1);
                            }
                        }
                    @endforeach
                @endif
                // Save selected columns to localStorage
                localStorage.setItem('selectedColumns', JSON.stringify(selectedColumns));

                // Reinitialize charts based on the updated selected columns
                initializeCharts();
            });

            function initializeCharts() {
                selectedColumns.forEach(column => {
                    createChart(column, document.getElementById(`${column}_chart_type`).value);
                });
            }

            function createChart(filter, chartType) {
                // Extract relevant data for chart
                const labels = [...new Set(formsArray.map(form => form[filter]))];
                const countPerFilter = labels.map(label =>
                    formsArray.filter(form => form[filter] === label).length
                );

                // Create an array of nice-looking colors
                const colors = [
                    '#D1C4E9', '#B39DDB', '#9575CD', '#7E57C2', '#673AB7',
                    '#5E35B1', '#512DA8', '#4527A0', '#311B92', '#B388FF'
                ];

                // Assign each bar a color from the colors array
                const barColors = labels.map((_, i) => colors[i % colors.length]);

                // Create a new div element for the chart
                const chartDiv = document.createElement('div');
                chartDiv.style.height = '50vh'; // Set a specific height for the div
                document.getElementById('chartsContainer').appendChild(chartDiv);

                // Create a new canvas element for the chart
                const canvas = document.createElement('canvas');
                chartDiv.appendChild(canvas);

                // Create the chart based on the selected chart type
                let chart;
                if (chartType === 'bar') {
                    chart = new Chart(canvas, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: `${filter} a göre / Başvuru Sayısı`,
                                data: countPerFilter,
                                backgroundColor: barColors,
                                borderColor: barColors,
                                borderWidth: 1
                            }]
                        },
                        options: getChartOptions(filter)
                    });
                } else if (chartType === 'pie') {
                    chart = new Chart(canvas, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: countPerFilter,
                                backgroundColor: barColors,
                                borderColor: barColors,
                                borderWidth: 1
                            }]
                        },
                        options: getChartOptions(filter)
                    });
                }

                // You can add more chart types as needed

                return chart;
            }

            function getChartOptions(filter) {
                return {
                    title: {
                        display: true,
                        text: `${filter} a göre / Başvuru Sayısı`,
                        fontSize: 20
                    },
                    tooltips: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleFontColor: '#fff',
                        bodyFontColor: '#fff',
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart',
                    },
                    legend: {
                        display: true,
                        labels: {
                            fontColor: 'rgb(255, 99, 132)',
                            fontSize: 16,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1,
                            ticks: {
                                fontColor: 'rgb(255, 99, 132)',
                            },
                            gridLines: {
                                color: 'rgba(255, 99, 132, 0.2)',
                            },
                        },
                        x: {
                            ticks: {
                                fontColor: 'rgb(255, 99, 132)',
                            },
                            gridLines: {
                                color: 'rgba(255, 99, 132, 0.2)',
                            },
                        }
                    },
                    maintainAspectRatio: true,
                    responsive: true
                };
            }
        });
    </script>
</x-app-layout>
