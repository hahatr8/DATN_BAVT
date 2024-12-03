@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê sản phẩm được thêm vào giỏ hàng nhiều nhất</h4>
                </div><!-- end card header -->
                <form id="date-form1" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date1">Từ ngày:</label>
                    <input type="date" id="start_date1" name="start_date" required>

                    <label for="end_date1">Đến ngày:</label>
                    <input type="date" id="end_date1" name="end_date" required>

                    <button type="submit" class="btn btn-success">Thống kê</button>
                    <button type="button" id="last-week1" class="btn btn-primary mt-2 mb-2">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month1" class="btn btn-primary">1 Tháng Gần Nhất</button>
                </form>
                <div id="notification" style="display: none; color: red; font-weight: bold;">
                    Không có dữ liệu để hiển thị.
                </div>
                <div class="card-body">
                    <div id="simple_pie_chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-secondary"]'
                        class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê 10 sản phẩm có số lượt xem nhiều nhất</h4>
                </div><!-- end card header -->
                <form id="date-form2" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date2">Từ ngày:</label>
                    <input type="date" id="start_date2" name="start_date" required>

                    <label for="end_date2">Đến ngày:</label>
                    <input type="date" id="end_date2" name="end_date" required>

                    <button type="submit" class="btn btn-success">Thống kê</button>
                    <button type="button" id="last-week2" class="btn btn-primary mt-2 mb-2">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month2" class="btn btn-primary">1 Tháng Gần Nhất</button>
                </form>
                <div class="card-body">
                    <div id="bar_chart" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê doanh thu của cửa hàng</h4>
                </div><!-- end card header -->
                <form id="date-form3" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date3">Từ ngày:</label>
                    <input type="date" id="start_date3" name="start_date" required>

                    <label for="end_date3">Đến ngày:</label>
                    <input type="date" id="end_date3" name="end_date" required>

                    <button type="submit" class="btn btn-success">Thống kê</button>
                    <button type="button" id="last-week3" class="btn btn-primary mt-2 mb-2">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month3" class="btn btn-primary">1 Tháng Gần Nhất</button>
                </form>

                <div class="card-body">
                    <div id="revenue_chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-secondary"]'
                        class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div> <!-- end col -->

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê doanh thu sản phẩm</h4>
                </div><!-- end card header -->
                <form id="date-form4" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date4">Từ ngày:</label>
                    <input type="date" id="start_date4" name="start_date" required>

                    <label for="end_date4">Đến ngày:</label>
                    <input type="date" id="end_date4" name="end_date" required>

                    <button type="submit" class="btn btn-success">Thống kê</button>
                    <button type="button" id="last-week4" class="btn btn-primary mt-2 mb-2">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month4" class="btn btn-primary">1 Tháng Gần Nhất</button>
                </form>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="revenue_product_chart"
                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-secondary"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div> <!-- end col -->
                </div>
            </div><!-- end card -->
        </div> <!-- end col -->

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê doanh thu hãng nước hoa</h4>
                </div><!-- end card header -->
                <form id="date-form5" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date5">Từ ngày:</label>
                    <input type="date" id="start_date5" name="start_date" required>

                    <label for="end_date5">Đến ngày:</label>
                    <input type="date" id="end_date5" name="end_date" required>

                    <button type="submit" class="btn btn-success">Thống kê</button>
                    <button type="button" id="last-week5" class="btn btn-primary mt-2 mb-2">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month5" class="btn btn-primary">1 Tháng Gần Nhất</button>
                </form>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="revenue_brand_chart"
                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-secondary"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
            </div><!-- end card -->
        </div> <!-- end col -->

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thống kê theo chi tiêu khách hàng</h4>
                </div>
                <form id="date-form6" action="{{ route('admin.') }}" method="GET">
                    <label for="start_date6">Từ ngày:</label>
                    <input type="date" id="start_date6" name="start_date" required>

                    <label for="end_date6">Đến ngày:</label>
                    <input type="date" id="end_date6" name="end_date" required>

                    <button type="submit" class="btn btn-success">Thống kê</button>
                    <button type="button" id="last-week6" class="btn btn-primary mt-2 mb-2">1 Tuần Gần Nhất</button>
                    <button type="button" id="last-month6" class="btn btn-primary">1 Tháng Gần Nhất</button>
                </form>
                <!-- end card header -->
                <div id="top-10-customers">
                    <table id="customer-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Khách Hàng</th>
                                <th>Tổng Chi Tiêu (VNĐ)</th>
                            </tr>
                        </thead>
                        <tbody id="customer-list">
                            <!-- Danh sách khách hàng sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                    <button id="show-more" class="btn btn-dark" style="display: none;">Xem thêm</button>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <!-- end col -->

        <!-- end col -->

    </div>
@endsection

@section('script-libs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupDateForm(buttonWeek, buttonMonth, startDateId, endDateId, formId) {
                const startDateInput = document.getElementById(startDateId);
                const endDateInput = document.getElementById(endDateId);
                const dateForm = document.getElementById(formId);
                const customerList = document.getElementById('customer-list');
                const showMoreButton = document.getElementById('show-more');
                const notification = document.getElementById('notification');

                let displayedCustomers = 10;

                // Dữ liệu từ PHP
                var revenues = @json($revenues);

                if (revenues.length === 0) {
                    notification.style.display = 'block';
                } else {
                    notification.style.display = 'none';

                    renderCustomers(revenues.slice(0, displayedCustomers));

                    if (revenues.length > displayedCustomers) {
                        showMoreButton.style.display = 'block';
                        showMoreButton.addEventListener('click', function() {
                            displayedCustomers += 10;
                            renderCustomers(revenues.slice(0, displayedCustomers));
                            if (displayedCustomers >= revenues.length) {
                                showMoreButton.style.display = 'none';
                            }
                        });
                    }
                }

                function renderCustomers(customers) {
                    customerList.innerHTML = '';
                    customers.forEach(function(customer, index) {
                        const tr = document.createElement('tr');
                        tr.innerHTML =
                            `<td>${index + 1}</td><td>${customer.customer_name}</td><td>${new Intl.NumberFormat('vi-VN').format(customer.total_revenue)} VNĐ</td>`;
                        customerList.appendChild(tr);
                    });
                }


                // Khôi phục vị trí cuộn từ localStorage
                if (localStorage.getItem('scrollPosition')) {
                    window.scrollTo(0, localStorage.getItem('scrollPosition'));
                    localStorage.removeItem('scrollPosition');
                }

                buttonWeek.addEventListener('click', function() {
                    const endDate = new Date();
                    const startDate = new Date();
                    startDate.setDate(endDate.getDate() - 7);

                    startDateInput.value = startDate.toISOString().substr(0, 10);
                    endDateInput.value = endDate.toISOString().substr(0, 10);

                    // Lưu vị trí cuộn hiện tại vào localStorage
                    localStorage.setItem('scrollPosition', window.scrollY);
                    dateForm.submit();
                });

                buttonMonth.addEventListener('click', function() {
                    const endDate = new Date();
                    const startDate = new Date();
                    startDate.setMonth(endDate.getMonth() - 1);

                    startDateInput.value = startDate.toISOString().substr(0, 10);
                    endDateInput.value = endDate.toISOString().substr(0, 10);

                    // Lưu vị trí cuộn hiện tại vào localStorage
                    localStorage.setItem('scrollPosition', window.scrollY);
                    dateForm.submit();
                });
            }

            setupDateForm(
                document.getElementById('last-week1'),
                document.getElementById('last-month1'),
                'start_date1', 'end_date1', 'date-form1'
            );

            setupDateForm(
                document.getElementById('last-week2'),
                document.getElementById('last-month2'),
                'start_date2', 'end_date2', 'date-form2'
            );

            setupDateForm(
                document.getElementById('last-week3'),
                document.getElementById('last-month3'),
                'start_date3', 'end_date3', 'date-form3'
            );

            setupDateForm(
                document.getElementById('last-week4'),
                document.getElementById('last-month4'),
                'start_date4', 'end_date4', 'date-form4'
            );

            setupDateForm(
                document.getElementById('last-week5'),
                document.getElementById('last-month5'),
                'start_date5', 'end_date5', 'date-form5'
            );

            setupDateForm(
                document.getElementById('last-week6'),
                document.getElementById('last-month6'),
                'start_date6', 'end_date6', 'date-form6'
            );
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

        var chartPieBasicColors = getChartColorsArray("simple_pie_chart");
        var chartDonutBasicColors = getChartColorsArray("simple_dount_chart");

        // Biểu đồ sản phẩm được thêm vào giỏ hàng nhiều nhất
        var productNamesInCart = @json($productNamesInCart);
        var quantitiesInCart = @json($quantitiesInCart);
        quantitiesInCart = quantitiesInCart.map(Number);

        if (chartPieBasicColors) {
            var pieOptions = {
                series: quantitiesInCart,
                chart: {
                    height: 500,
                    type: 'pie'
                },
                labels: productNamesInCart,
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

        // Biểu đồ lượt xem sản phẩm
        var productNamesByViews = @json($productNamesByViews);
        var viewCounts = @json($viewCounts);
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
                    enabled: true
                },
                series: [{
                    data: viewCounts
                }],
                colors: chartBarColors,
                grid: {
                    borderColor: '#f1f1f1'
                },
                xaxis: {
                    categories: productNamesByViews
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return value.toLocaleString('vi-VN', {
                                minimumFractionDigits: 0
                            }) + ' VNĐ';
                        }
                    }
                }
            };

            var barChart = new ApexCharts(document.querySelector("#bar_chart"), barOptions);
            barChart.render();
        }

        // Biểu đồ doanh thu theo ngày
        var chartColors = getChartColorsArray("revenue_chart");
        var dates = @json($dates);
        var totalRevenuesByDate = @json($totalRevenuesByDate);


        if (chartColors) {
            var options = {
                series: [{
                    name: 'Doanh thu',
                    data: totalRevenuesByDate
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
                    },
                    labels: {
                        formatter: function(value) {
                            return value.toLocaleString('vi-VN', {
                                minimumFractionDigits: 0
                            }) + ` VNĐ`;
                        }
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

        // Biểu đồ doanh thu theo sản phẩm
        var revenueProductChartColors = getChartColorsArray("revenue_product_chart");
        var productNamesByRevenue = @json($productNamesByRevenue);
        var totalRevenuesByProduct = @json($totalRevenuesByProduct);

        if (revenueProductChartColors) {
            var revenueProductOptions = {
                series: [{
                    name: 'Doanh thu',
                    data: totalRevenuesByProduct
                }],
                chart: {
                    height: 350,
                    type: 'bar'
                },
                plotOptions: {
                    bar: {
                        horizontal: true
                    }
                },
                xaxis: {
                    categories: productNamesByRevenue,
                    title: {
                        text: 'Sản phẩm'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Doanh thu (VNĐ)',
                    },
                    labels: {
                        formatter: function(value) {
                            return value.toLocaleString('vi-VN', {
                                minimumFractionDigits: 0
                            }) + ` VNĐ`;
                        }
                    }
                },
                colors: revenueProductChartColors,
                dataLabels: {
                    enabled: true
                },
                legend: {
                    position: 'bottom'
                }
            };

            var revenueProductChart = new ApexCharts(document.querySelector("#revenue_product_chart"),
                revenueProductOptions);
            revenueProductChart.render();
        }
        // Biểu đồ doanh thu theo hãng nước hoa
        var revenueBrandChartColors = ["#299CDB", "#00E396", "#FEB019", "#FF4560", "#775DD0", "#546E7A", "#26a69a",
            "#D10CE8", "#F15BB5", "#1E88E5"
        ];

        // Dữ liệu từ PHP
        var brandNamesByRevenue = @json($brandNamesByRevenue);
        var totalRevenuesByBrand = @json($totalRevenuesByBrand);

        if (revenueBrandChartColors) {
            var revenueBrandOptions = {
                series: [{
                    name: 'Doanh thu',
                    data: totalRevenuesByBrand
                }],
                chart: {
                    height: 350,
                    type: 'bar'
                },
                plotOptions: {
                    bar: {
                        horizontal: true
                    }
                },
                xaxis: {
                    categories: brandNamesByRevenue,
                    title: {
                        text: 'Thương hiệu'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Doanh thu (VNĐ)'
                    },
                    labels: {
                        formatter: function(value) {
                            return value.toLocaleString('vi-VN', {
                                minimumFractionDigits: 0
                            }) + ` VNĐ`;
                        }
                    }
                },
                colors: revenueBrandChartColors,
                dataLabels: {
                    enabled: true
                },
                legend: {
                    position: 'bottom'
                }
            };

            var revenueBrandChart = new ApexCharts(document.querySelector("#revenue_brand_chart"), revenueBrandOptions);
            revenueBrandChart.render();
        }
    </script>
@endsection

@section('style-libs')
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@yield('js')
