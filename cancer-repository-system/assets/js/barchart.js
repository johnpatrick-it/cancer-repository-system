function renderBarChart() {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "TOP CANCER CASES PPC REPOSITORY 2023"
            },
            axisX: {
                valueFormatString: "MMM YYYY"
            },
            axisY2: {
                title: "Cancer Cases",
                prefix: "",
                suffix: ""
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                verticalAlign: "top",
                horizontalAlign: "center",
                dockInsidePlotArea: true,
                itemclick: toogleDataSeries
            },
            data: [{
                type:"line",
                axisYType: "secondary",
                name: "Null",
                showInLegend: true,
                markerSize: 0,
                yValueFormatString: "#,###",
                dataPoints: [		
                    { x: new Date(2019, 0, 1), y: 850 },
                    { x: new Date(2019, 1, 1), y: 889 },
                    { x: new Date(2019, 2, 1), y: 890 },
                    { x: new Date(2019, 3, 1), y: 899 },
                    { x: new Date(2019, 4, 1), y: 903 },
                    { x: new Date(2020, 5, 1), y: 925 },
                    { x: new Date(2020, 6, 1), y: 899 },
                    { x: new Date(2020, 7, 1), y: 875 },
                    { x: new Date(2020, 8, 1), y: 927 },
                    { x: new Date(2020, 9, 1), y: 949 },
                    { x: new Date(2020, 10, 1), y: 946 },
                    { x: new Date(2021, 11, 1), y: 927 },
                    { x: new Date(2021, 0, 1), y: 950 },
                    { x: new Date(2021, 1, 1), y: 998 },
                    { x: new Date(2021, 2, 1), y: 998 },
                    { x: new Date(2021, 3, 1), y: 1050 },
                    { x: new Date(2021, 4, 1), y: 1050 },
                    { x: new Date(2021, 5, 1), y: 999 },
                    { x: new Date(2021, 6, 1), y: 998 },
                    { x: new Date(2021, 7, 1), y: 998 },
                    { x: new Date(2022, 8, 1), y: 1050 },
                    { x: new Date(2022, 9, 1), y: 1070 },
                    { x: new Date(2022, 10, 1), y: 1050 },
                    { x: new Date(2022, 11, 1), y: 1050 },
                    { x: new Date(2022, 0, 1), y: 995 },
                    { x: new Date(2022, 1, 1), y: 1090 },
                    { x: new Date(2022, 2, 1), y: 1100 },
                    { x: new Date(2023, 3, 1), y: 1150 },
                    { x: new Date(2022, 4, 1), y: 1150 },
                    { x: new Date(2022, 5, 1), y: 1150 },
                    { x: new Date(2022, 6, 1), y: 1100 },
                    { x: new Date(2022, 7, 1), y: 1100 },
                    { x: new Date(2022, 8, 1), y: 1150 },
                    { x: new Date(2022, 9, 1), y: 1170 },
                    { x: new Date(2022, 0, 1), y: 1150 },
                    { x: new Date(2023, 1, 1), y: 1150 },
                    { x: new Date(2023, 0, 1), y: 1150 },
                    { x: new Date(2023, 1, 1), y: 1200 },
                    { x: new Date(2023, 2, 1), y: 1200 },
                    { x: new Date(2023, 3, 1), y: 1200 },
                    { x: new Date(2023, 4, 1), y: 1190 },
                    { x: new Date(2023, 5, 1), y: 1170 }
                ]
            },
            {
                type: "line",
                axisYType: "secondary",
                name: "Null",
                showInLegend: true,
                markerSize: 0,
                yValueFormatString: "#,###",
                dataPoints: [
                    { x: new Date(2014, 0, 1), y: 1200 },
                    { x: new Date(2014, 1, 1), y: 1200 },
                    { x: new Date(2014, 2, 1), y: 1190 },
                    { x: new Date(2014, 3, 1), y: 1180 },
                    { x: new Date(2014, 4, 1), y: 1250 },
                    { x: new Date(2014, 5, 1), y: 1270 },
                    { x: new Date(2014, 6, 1), y: 1300 },
                    { x: new Date(2014, 7, 1), y: 1300 },
                    { x: new Date(2014, 8, 1), y: 1358 },
                    { x: new Date(2014, 9, 1), y: 1410 },
                    { x: new Date(2014, 10, 1), y: 1480 },
                    { x: new Date(2014, 11, 1), y: 1500 },
                    { x: new Date(2015, 0, 1), y: 1500 },
                    { x: new Date(2015, 1, 1), y: 1550 },
                    { x: new Date(2015, 2, 1), y: 1550 },
                    { x: new Date(2015, 3, 1), y: 1590 },
                    { x: new Date(2015, 4, 1), y: 1600 },
                    { x: new Date(2015, 5, 1), y: 1590 },
                    { x: new Date(2015, 6, 1), y: 1590 },
                    { x: new Date(2015, 7, 1), y: 1620 },
                    { x: new Date(2015, 8, 1), y: 1670 },
                    { x: new Date(2015, 9, 1), y: 1720 },
                    { x: new Date(2015, 10, 1), y: 1750 },
                    { x: new Date(2015, 11, 1), y: 1820 },
                    { x: new Date(2016, 0, 1), y: 2000 },
                    { x: new Date(2016, 1, 1), y: 1920 },
                    { x: new Date(2016, 2, 1), y: 1750 },
                    { x: new Date(2016, 3, 1), y: 1850 },
                    { x: new Date(2016, 4, 1), y: 1750 },
                    { x: new Date(2016, 5, 1), y: 1730 },
                    { x: new Date(2016, 6, 1), y: 1700 },
                    { x: new Date(2016, 7, 1), y: 1730 },
                    { x: new Date(2016, 8, 1), y: 1720 },
                    { x: new Date(2016, 9, 1), y: 1740 },
                    { x: new Date(2016, 10, 1), y: 1750 },
                    { x: new Date(2016, 11, 1), y: 1750 },
                    { x: new Date(2017, 0, 1), y: 1750 },
                    { x: new Date(2017, 1, 1), y: 1770 },
                    { x: new Date(2017, 2, 1), y: 1750 },
                    { x: new Date(2017, 3, 1), y: 1750 },
                    { x: new Date(2017, 4, 1), y: 1730 },
                    { x: new Date(2017, 5, 1), y: 1730 }
                ]
            },
           ]
        });
        chart.render();
        
        function toogleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }
        
        }