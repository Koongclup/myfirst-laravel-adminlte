<div class="row">
    @role('admin')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $category }}</h3>
                    <p>Total Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="{{ route('admin.category.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $product }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="icon">
                    <i class="fas fas fa-th"></i>
                </div>
                <a href="{{ route('admin.product.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $collection }}</h3>
                    <p>Total Collections</p>
                </div>
                <div class="icon">
                    <i class="fas fas fa-file-pdf"></i>
                </div>
                <a href="{{ route('admin.collection.index') }}" class="small-box-footer">View <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

       
        <div class="col-md-6">
            <!-- Pie Chart Container -->
         <div class="card">
            <div class="card-body">
                <div id="pie-chart" style="width:100%; height:300px;"></div>
            </div>
         </div>
        </div>
        <div class="col-md-6">
            <!-- Column Chart Container -->
            <div class="card">
                <div class="card-body">
                    <div id="column-chart" style="width:100%; height:300px;"></div>
                </div>
            </div>
           
        </div>

        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
    // Function to detect current theme (dark or light)
    function isDarkMode() {
        return document.body.classList.contains('dark-mode');
    }

    // Set chart background based on the theme
    function getChartBackgroundColor() {
        return isDarkMode() ? '#343a40' : '#ffffff';  // Dark mode: dark gray, Light mode: white
    }

    // AJAX request to fetch chart data
    $.ajax({
        url: '/chart-data',  // Adjust the URL based on your routing setup
        method: 'GET',
        success: function(response) {
            // Pie Chart for user roles
            Highcharts.chart('pie-chart', {
                chart: {
                    type: 'pie',
                    backgroundColor: getChartBackgroundColor()
                },
                title: {
                    text: 'User Roles Distribution',
                    style: {
                        color: isDarkMode() ? '#ffffff' : '#000000'  // Adjust text color based on theme
                    }
                },
                series: [{
                    name: 'Users',
                    colorByPoint: true,
                    data: response.roleData
                }]
            });

            // Column Chart for user modes
            Highcharts.chart('column-chart', {
                chart: {
                    type: 'column',
                    backgroundColor: getChartBackgroundColor()
                },
                title: {
                    text: 'User Modes Usage',
                    style: {
                        color: isDarkMode() ? '#ffffff' : '#000000'  // Adjust text color based on theme
                    }
                },
                xAxis: {
                    categories: response.modeCategories,
                    crosshair: true,
                    labels: {
                        style: {
                            color: isDarkMode() ? '#ffffff' : '#000000'  // Adjust xAxis label color based on theme
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Number of Users',
                        style: {
                            color: isDarkMode() ? '#ffffff' : '#000000'  // Adjust yAxis title color based on theme
                        }
                    },
                    labels: {
                        style: {
                            color: isDarkMode() ? '#ffffff' : '#000000'  // Adjust yAxis label color based on theme
                        }
                    }
                },
                series: [{
                    name: 'Users',
                    data: response.modeData
                }]
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching chart data:', error);
        }
    });
});

        </script>
        
    @endrole
</div>
