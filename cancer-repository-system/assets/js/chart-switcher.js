$(document).ready(function () {
    // Initially render the pie chart
    renderPieChart();

    // Button click handlers
    $('#pieChartBtn').click(function () {
        renderPieChart();
    });

    $('#barChartBtn').click(function () {
        renderBarChart();
    });
});