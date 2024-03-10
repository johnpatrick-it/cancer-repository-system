function renderBarChart() {
	
    var chart = new CanvasJS.Chart("chartContainer", {
        //theme: "light2", // "light1", "light2", "dark1", "dark2"
        animationEnabled: true,
        exportEnabled: true,
        title:{
            text: "Estimated number of new Cancer Cases in 2025"  
        },
        axisX: {
            lineColor: "black",
            labelFontColor: "black"
        },
        axisY2: {
              gridThickness: 0,
            title: " Number of Cases",
            suffix: "",
            titleFontColor: "black",
            labelFontColor: "black"
        },
        legend: {
            cursor: "pointer",
            itemmouseover: function(e) {
                e.dataSeries.lineThickness = e.chart.data[e.dataSeriesIndex].lineThickness * 2;
                e.dataSeries.markerSize = e.chart.data[e.dataSeriesIndex].markerSize + 2;
                e.chart.render();
            },
            itemmouseout: function(e) {
                e.dataSeries.lineThickness = e.chart.data[e.dataSeriesIndex].lineThickness / 2;
                e.dataSeries.markerSize = e.chart.data[e.dataSeriesIndex].markerSize - 2;
                e.chart.render();
            },
            itemclick: function (e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }
        },
        toolTip: {
            shared: true
        },
        data: [{
            type: "spline",
            name: "null",
            markerSize: 5,
              axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: 47.5 },
                { x: new Date(2019, 0), y: 84.8 },
                { x: new Date(2020, 0), y: 91 },
                { x: new Date(2021, 0), y: 90 },
                { x: new Date(2022, 0), y: 92.8 },
                { x: new Date(2023, 0), y: 93.2 },
                { x: new Date(2024, 0), y: 94.8 },
                { x: new Date(2025, 0), y: 92.5 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: 26.8 },
                { x: new Date(2019, 0), y: 70 },
                { x: new Date(2020, 0), y: 83.6 },
                { x: new Date(2021, 0), y: 85 },
                { x: new Date(2022, 0), y: 85.4 },
                { x: new Date(2023, 0), y: 87.5 },
                { x: new Date(2024, 0), y: 89.8 },
                { x: new Date(2025, 0), y: 91.6 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: 23.6 },
                { x: new Date(2019, 0), y: 40 },
                { x: new Date(2020, 0), y: 64 },
                { x: new Date(2021, 0), y: 68 },
                { x: new Date(2022, 0), y: 78 },
                { x: new Date(2023, 0), y: 85 },
                { x: new Date(2024, 0), y: 86 },
                { x: new Date(2025, 0), y: 90.4 }
            ]
        },
        {
            type: "spline",
            showInLegend: true,
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            yValueFormatString: "#,##0.0\"%\"",
            xValueFormatString: "YYYY",
            dataPoints: [
                { x: new Date(2018, 0), y: 43.1 },
                { x: new Date(2019, 0), y: 68 },
                { x: new Date(2020, 0), y: 71 },
                { x: new Date(2021, 0), y: 71.7 },
                { x: new Date(2022, 0), y: 69.7 },
                { x: new Date(2023, 0), y: 79.3 },
                { x: new Date(2024, 0), y: 84.2 },
                { x: new Date(2025, 0), y: 87 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: 47.1 },
                { x: new Date(2019, 0), y: 70.1 },
                { x: new Date(2020, 0), y: 81.3 },
                { x: new Date(2021, 0), y: 83.9 },
                { x: new Date(2022, 0), y: 85.2 },
                { x: new Date(2023, 0), y: 85.2 },
                { x: new Date(2024, 0), y: 86.7 },
                { x: new Date(2025, 0), y: 87 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: 27.8 },
                { x: new Date(2019, 0), y: 56.9 },
                { x: new Date(2020, 0), y: 69.4 },
                { x: new Date(2021, 0), y: 72 },
                { x: new Date(2022, 0), y: 72.2 },
                { x: new Date(2023, 0), y: 72.9 },
                { x: new Date(2024, 0), y: 74.2 },
                { x: new Date(2025, 0), y: 74.6 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: 2 },
                { x: new Date(2019, 0), y: 15.2 },
                { x: new Date(2020, 0), y: 29 },
                { x: new Date(2021, 0), y: 43 },
                { x: new Date(2022, 0), y: 49 },
                { x: new Date(2023, 0), y: 63.8 },
                { x: new Date(2024, 0), y: 61.4 },
                { x: new Date(2025, 0), y: 70.5 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: .7 },
                { x: new Date(2019, 0), y: 3.7 },
                { x: new Date(2020, 0), y: 17.9 },
                { x: new Date(2021, 0), y: 23.3 },
                { x: new Date(2022, 0), y: 28.7 },
                { x: new Date(2023, 0), y: 35.3 },
                { x: new Date(2024, 0), y: 41.8 },
                { x: new Date(2025, 0), y: 43.4 }
            ]
        },
        {
            type: "spline",
            name: "null",
            markerSize: 5,
            axisYType: "secondary",
            xValueFormatString: "YYYY",
            yValueFormatString: "#,##0.0\"%\"",
            showInLegend: true,
            dataPoints: [
                { x: new Date(2018, 0), y: .5 },
                { x: new Date(2019, 0), y: 2.4 },
                { x: new Date(2020, 0), y: 5.1 },
                { x: new Date(2021, 0), y: 7.5 },
                { x: new Date(2022, 0), y: 10.1 },
                { x: new Date(2023, 0), y: 12.6 },
                { x: new Date(2024, 0), y: 15.1 },
                { x: new Date(2025, 0), y: 18 }
            ]
        }]
    });
    chart.render();
    
    }