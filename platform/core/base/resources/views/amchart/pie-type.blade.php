@push('js')
    <script>
        function amchartPie(elm, crawData, labelName, valueY) {

            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new(elm);

                //remove logo amcharts
                root._logo.dispose();

                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create chart
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart = root.container.children.push(am5percent.PieChart.new(root, {
                    radius: am5.percent(90),
                    innerRadius: am5.percent(50),
                    layout: root.verticleLayout
                }));

                // Create series
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series = chart.series.push(am5percent.PieSeries.new(root, {
                    name: "Series",
                    valueField: valueY,
                    categoryField: labelName,
                    legendLabelText: "[{fill}]{category}:[/]",
                    legendValueText: "[bold {fill}]{value}[/]",
                    startAngle: 160,
                    endAngle: 380,
                    radius: am5.percent(60),
                    innerRadius: am5.percent(100)
                }));

                // Set data
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data

                var data = JSON.parse(crawData);

                var total = data.reduce(function(accumulator, item) {
                    return accumulator + item.total;
                }, 0);

                var label = chart.seriesContainer.children.push(
                    am5.Label.new(root, {
                        textAlign: "center",
                        centerY: am5.p50,
                        centerX: am5.p50,
                        text: "[fontSize:18px]Tổng[/]\n[bold fontSize:30px]"+ total +"[/]"
                    })
                );

                series.data.setAll(data);

                // Disabling labels and ticks
                // series.labels.template.set("visible", false);
                // series.ticks.template.set("visible", false);

                series.labels.template.set("forceHidden", true);
                series.ticks.template.set("forceHidden", true);

                // Adding gradients
                series.slices.template.set("strokeOpacity", 0);
                // series.slices.template.set("fillGradient", am5.RadialGradient.new(root, {
                //     stops: [{
                //         brighten: -0.8
                //     }, {
                //         brighten: -0.8
                //     }, {
                //         brighten: -0.5
                //     }, {
                //         brighten: 0
                //     }, {
                //         brighten: -0.5
                //     }]
                // }));

                // Create legend
                // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                // var legend = chart.children.push(am5.Legend.new(root, {
                //     centerY: am5.percent(50),
                //     y: am5.percent(50),
                //     layout: root.verticalLayout
                // }));
                // // set value labels align to right
                // legend.valueLabels.template.setAll({
                //     textAlign: "right"
                // })
                // // set width and max width of labels
                // legend.labels.template.setAll({
                //     maxWidth: 140,
                //     width: 140,
                //     oversizedBehavior: "wrap"
                // });

                var legend = chart.children.push( 
                    am5.Legend.new(root, {
                        centerY: am5.percent(50),
                        y: am5.percent(90),
                        centerX: am5.percent(50), // Căn giữa theo chiều ngang
                        x: am5.percent(50),  
                        layout: am5.GridLayout.new(root, {
                            maxColumns: 4, // Số cột tối đa cho các mục trong legend
                            fixedWidthGrid: false
                        })
                    })
                );

                // legend.labels.template.setAll({
                //     maxWidth: 140,
                //     width: 140,
                //     oversizedBehavior: "wrap"
                // });

                legend.data.setAll(series.dataItems);


                // Play initial series animation
                // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                series.appear(1000, 100);

            }); // end am5.ready()
        }

        function amchartPieStyle2(elm, crawData, labelName, valueY) {

            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new(elm);

                //remove logo amcharts
                root._logo.dispose();

                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create chart
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart = root.container.children.push(am5percent.PieChart.new(root, {
                    radius: am5.percent(90),
                    innerRadius: am5.percent(50),
                    layout: root.verticleLayout
                }));

                // Create series
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series = chart.series.push(am5percent.PieSeries.new(root, {
                    name: "Series",
                    valueField: valueY,
                    categoryField: labelName,
                    legendLabelText: "[{fill}]{category}:[/]",
                    legendValueText: "[bold {fill}]{value}[/]",
                    radius: am5.percent(60),
                    innerRadius: am5.percent(100)
                }));

                // Set data
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data

                var data = JSON.parse(crawData);

                var total = data.reduce(function(accumulator, item) {
                    return accumulator + item.total;
                }, 0);

                var label = chart.seriesContainer.children.push(
                    am5.Label.new(root, {
                        textAlign: "center",
                        centerY: am5.p50,
                        centerX: am5.p50,
                        text: "[fontSize:18px]Tổng[/]\n[bold fontSize:30px]"+ total +"[/]"
                    })
                );

                series.data.setAll(data);

                // Disabling labels and ticks
                series.labels.template.set("visible", false);
                series.ticks.template.set("visible", false);

                // Adding gradients
                series.slices.template.set("strokeOpacity", 0);

                // Play initial series animation
                // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                series.appear(1000, 100);

            }); // end am5.ready()
            }
    </script>
@endpush
