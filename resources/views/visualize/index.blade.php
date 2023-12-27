<x-app-layout>
    <div class="w-[90dvw] h-[90dvh] flex justify-center items-center">
        <div class="w-[70%] h-[70vh]">
            <canvas id="myChart" class="chart" height="400"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $formsByYear->pluck('year') !!}, // Extract years as labels
                datasets: [{
                    label: 'Yıllara Göre Gelen Form Sayısı',
                    data: {!! $formsByYear->pluck('count') !!}, // Extract form counts for each year
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false, // Set this to false to make the chart responsive
                responsive: true
            }
        });
    </script>
</x-app-layout>
