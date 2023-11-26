$(document).ready(function () {
    // RENDERING YUGN CHART
    renderPieChart();

    // BUTTON FUNCTION PARA MALIPAT MGA CHART
    $('#pieChartBtn').click(function () {
        renderPieChart();
    });

    $('#barChartBtn').click(function () {
        renderBarChart();
    });
});