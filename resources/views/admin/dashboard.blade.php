@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê sản phẩm được thêm vào giỏ hàng nhiều nhất</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="simple_pie_chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-secondary"]'
                        class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê 10 sản phẩm có số lượt xem nhiều nhất</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="bar_chart" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê doanh thu</h4>
                </div><!-- end card header -->
                <form id="date-form" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date">Từ ngày:</label>
                    <input type="date" id="start_date" name="start_date" required>

                    <label for="end_date">Đến ngày:</label>
                    <input type="date" id="end_date" name="end_date" required>

                    <button type="submit">Thống kê</button>

                    <button type="button" id="last-week">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month">1 Tháng Gần Nhất</button>
                </form>

                <div class="card-body">
                    <div id="revenue_chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-secondary"]'
                        class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection

@section('style-libs')
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-libs')
    <!-- apexcharts -->
    <script>
        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var colors = document.getElementById(e).getAttribute("data-colors");
                return JSON.parse(colors).map(function(e) {
                    var t = e.replace(" ", "");
                    return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(t) ||
                        t :
                        2 === (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement)
                        .getPropertyValue(e[0]) + "," + e[1] + ")" :
                        t;
                });
            }
        }

        var chartPieBasicColors = getChartColorsArray("simple_pie_chart");
        var chartDonutBasicColors = getChartColorsArray("simple_dount_chart");

        // Dữ liệu từ PHP
        var productNames = @json($productNames);
        var quantities = @json($quantities);
        var productNamess = @json($productNamess);
        var viewCounts = @json($viewCounts);

        // Chuyển đổi mảng chuỗi thành số
        var numberArray = quantities.map(Number);

        if (chartPieBasicColors) {
            var pieOptions = {
                series: numberArray,
                chart: {
                    height: 300,
                    type: 'pie'
                },
                labels: productNames,
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    dropShadow: {
                        enabled: false
                    }
                },
                colors: chartPieBasicColors
            };

            var pieChart = new ApexCharts(document.querySelector("#simple_pie_chart"), pieOptions);
            pieChart.render();
        }

        if (chartDonutBasicColors) {
            var donutOptions = {
                series: numberArray,
                chart: {
                    height: 300,
                    type: 'donut'
                },
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    dropShadow: {
                        enabled: false
                    }
                },
                colors: chartDonutBasicColors
            };

            var donutChart = new ApexCharts(document.querySelector("#simple_dount_chart"), donutOptions);
            donutChart.render();
        }

        // Dữ liệu mẫu cho các biểu đồ khác
        var chartBarColors = getChartColorsArray("bar_chart");
        if (chartBarColors) {
            var barOptions = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    data: viewCounts
                }],
                colors: chartBarColors,
                grid: {
                    borderColor: '#f1f1f1'
                },
                xaxis: {
                    categories: productNamess
                }
            };

            var barChart = new ApexCharts(document.querySelector("#bar_chart"), barOptions);
            barChart.render();
        }

        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var colors = document.getElementById(e).getAttribute("data-colors");
                return JSON.parse(colors).map(function(e) {
                    var t = e.replace(" ", "");
                    return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(t) ||
                        t : 2 === (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement)
                        .getPropertyValue(e[0]) + "," + e[1] + ")" : t;
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const lastWeekButton = document.getElementById('last-week');
            const lastMonthButton = document.getElementById('last-month');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const dateForm = document.getElementById('date-form');

            lastWeekButton.addEventListener('click', function() {
                const endDate = new Date();
                const startDate = new Date();
                startDate.setDate(endDate.getDate() - 7);

                startDateInput.value = startDate.toISOString().substr(0, 10);
                endDateInput.value = endDate.toISOString().substr(0, 10);
                dateForm.submit();
            });

            lastMonthButton.addEventListener('click', function() {
                const endDate = new Date();
                const startDate = new Date();
                startDate.setMonth(endDate.getMonth() - 1);

                startDateInput.value = startDate.toISOString().substr(0, 10);
                endDateInput.value = endDate.toISOString().substr(0, 10);
                dateForm.submit();
            });
        });

        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var colors = document.getElementById(e).getAttribute("data-colors");
                return JSON.parse(colors).map(function(e) {
                    var t = e.replace(" ", "");
                    return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(t) ||
                        t :
                        2 === (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement)
                        .getPropertyValue(e[0]) + "," + e[1] + ")" :
                        t;
                });
            }
        }

        var chartColors = getChartColorsArray("revenue_chart");

        // Dữ liệu từ PHP
        var dates = @json($dates);
        var totalRevenues = @json($totalRevenues);
        var formattedArray = totalRevenues.map(function(number) {
            return number.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });


        if (chartColors) {
            var options = {
                series: [{
                    name: 'Doanh thu',
                    data: formattedArray
                }],
                chart: {
                    height: 350,
                    type: 'line'
                },
                xaxis: {
                    categories: dates,
                    title: {
                        text: 'Ngày'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Doanh thu (VNĐ)'
                    }
                },
                colors: chartColors,
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new ApexCharts(document.querySelector("#revenue_chart"), options);
            chart.render();
        }
    </script>

    <!-- Vector map-->
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!--Swiper slider js-->
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection
