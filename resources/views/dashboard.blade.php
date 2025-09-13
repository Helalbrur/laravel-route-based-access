@extends('layouts.app')
@section('script_before')
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free/css/all.min.css') }}">
    <script src="{{asset('js/chart.js')}}"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 15px 20px;
            background: linear-gradient(135deg, #4c7ee9 0%, #3b5bbf 100%);
            border-radius: 12px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .header-title h1 {
            font-weight: 600;
            font-size: 28px;
        }
        
        .header-title p {
            opacity: 0.9;
            font-size: 15px;
            margin-top: 5px;
        }
        
        .header-controls {
            display: flex;
            gap: 15px;
        }
        
        .header-controls button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .header-controls button:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .supplier-selector {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .supplier-selector h3 {
            font-size: 18px;
            color: #4c7ee9;
        }
        
        .supplier-selector select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            min-width: 250px;
        }
        
        .kpi-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .kpi-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .kpi-card:hover {
            transform: translateY(-5px);
        }
        
        .kpi-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 20px;
        }
        
        .kpi-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .kpi-title {
            color: #666;
            font-weight: 500;
            font-size: 15px;
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        .chart-controls {
            display: flex;
            gap: 10px;
        }
        
        .chart-controls select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .chart-canvas-container {
            height: 300px;
            position: relative;
        }
        
        .half-charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .info-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        
        .info-card h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #4c7ee9;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .progress-bar {
            height: 8px;
            background: #f0f0f0;
            border-radius: 4px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
        }
        
        .currency-note {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 10px;
        }
        
        .supplier-highlight {
            background-color: rgba(76, 126, 233, 0.1);
            border-left: 4px solid #4c7ee9;
        }
        
        @media (max-width: 1200px) {
            .kpi-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .kpi-cards {
                grid-template-columns: 1fr;
            }
            
            .half-charts {
                grid-template-columns: 1fr;
            }
            
            .info-cards {
                grid-template-columns: 1fr;
            }
            
            .header-controls {
                display: none;
            }
            
            .supplier-selector {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection
@section('content')
<div class="dashboard-container">
    <div class="supplier-selector">
        <h3>Select Supplier:</h3>
        <select id="supplierFilter">
            <option value="all">All Suppliers</option>
            @foreach ($supplierTotals as $supp)
                
                <option value="{{ $supp['supplier_name'] }}">{{ $supp['supplier_name'] }}</option>
            @endforeach
        </select>
        <button onclick="updateDashboard()" style="background: #4c7ee9; padding: 10px 20px;">
            <i class="fas fa-filter"></i> Apply Filter
        </button>
    </div>
    
    <div class="kpi-cards">
        <div class="kpi-card">
            <div class="kpi-icon" style="background-color: rgba(76, 126, 233, 0.2); color: #4c7ee9;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="kpi-value" style="color: #4c7ee9;" id="totalSales">২,48,56,000</div>
            <div class="kpi-title">Total Sales</div>
            <div class="currency-note">Amount in BDT</div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon" style="background-color: rgba(52, 168, 83, 0.2); color: #34a853;">
                <i class="fas fa-truck"></i>
            </div>
            <div class="kpi-value" style="color: #34a853;" id="totalSupplier">{{count($lib_supplier_arr)}}</div>
            <div class="kpi-title">Total Suppliers</div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon" style="background-color: rgba(234, 67, 53, 0.2); color: #ea4335;">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="kpi-value" style="color: #ea4335;" id="totalWorkOrder">{{$totalWorkOrders}}</div>
            <div class="kpi-title">Total Work Orders</div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon" style="background-color: rgba(251, 188, 4, 0.2); color: #fbbc04;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="kpi-value" style="color: #fbbc04;" id="totalWorkOrderValue">{{$grandTotalAmount}}</div>
            <div class="kpi-title">Work Order Value</div>
            <div class="currency-note">Amount in BDT</div>
        </div>
    </div>
    
    <div class="charts-grid">
        <div class="chart-container">
            <div class="chart-header">
                <h2 class="chart-title">Supplier Order Analysis</h2>
                <div class="chart-controls">
                    <select id="dateRange">
                        <option value="30">Last 30 Days</option>
                        <option value="7">Last 7 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>
                </div>
            </div>
            <div class="chart-canvas-container">
                <canvas id="supplierChart"></canvas>
            </div>
        </div>
        
        <div class="chart-container">
            <div class="chart-header">
                <h2 class="chart-title">Work Order vs Receive</h2>
            </div>
            <div class="chart-canvas-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="half-charts">
        <div class="chart-container">
            <div class="chart-header">
                <h2 class="chart-title">Work Order vs Receive Over Time</h2>
                <div class="chart-controls">
                    <select id="timeRange">
                        <option value="30">Last 30 Days</option>
                        <option value="7">Last 7 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>
                </div>
            </div>
            <div class="chart-canvas-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        
        <div class="chart-container">
            <div class="chart-header">
                <h2 class="chart-title">Sales by Product</h2>
                <div class="chart-controls">
                    <select id="productLimit">
                        <option value="10">Top 10 Products</option>
                        <option value="5">Top 5 Products</option>
                        <option value="all">All Products</option>
                    </select>
                </div>
            </div>
            <div class="chart-canvas-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="info-cards">
        <div class="info-card">
            <h3><i class="fas fa-info-circle" style="color: #4c7ee9;"></i> Order Status</h3>
            <div class="info-item">
                <span>Completed</span>
                <span id="completedOrders">124</span>
            </div>
            <div class="info-item">
                <span>In Progress</span>
                <span id="progressOrders">42</span>
            </div>
            <div class="info-item">
                <span>Pending</span>
                <span id="pendingOrders">20</span>
            </div>
            <div class="info-item">
                <span>Delayed</span>
                <span id="delayedOrders">8</span>
            </div>
        </div>
        <div class="info-card">
            <h3><i class="fas fa-tachometer-alt" style="color: #34a853;"></i> Performance Metrics</h3>
            <div class="info-item">
                <span>Order Accuracy</span>
                <span id="orderAccuracy">96%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 96%; background: #34a853;"></div>
            </div>
            <div class="info-item">
                <span>On-Time Delivery</span>
                <span id="onTimeDelivery">88%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 88%; background: #34a853;"></div>
            </div>
            <div class="info-item">
                <span>Supplier Quality</span>
                <span id="supplierQuality">91%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 91%; background: #34a853;"></div>
            </div>
        </div>
        
        <div class="info-card">
            <h3><i class="fas fa-bell" style="color: #ea4335;"></i> Recent Alerts</h3>
            <div class="info-item">
                <span>Order #3245 delayed</span>
                <span>2 hrs ago</span>
            </div>
            <div class="info-item">
                <span>Low stock: Product X</span>
                <span>5 hrs ago</span>
            </div>
            <div class="info-item">
                <span>New supplier added</span>
                <span>1 day ago</span>
            </div>
            <div class="info-item">
                <span>Monthly report ready</span>
                <span>2 days ago</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        // Convert PHP data to JS
        const supplierTotals = @json($supplierTotals);
        //const worksOrderData = ($works_order);
        const grandTotalQty = {{ $grandTotalQty }};
        const grandTotalAmount = {{ $grandTotalAmount }};
        const totalWorkOrders = {{ $totalWorkOrders }};
        const totalSuppliers = {{ count($lib_supplier_arr) }};
        const allData = @json($allData);

        // const chartData = worksOrderData.map(wo => {
        //     return {
        //         id: wo.id,
        //         date: wo.created_at,   // Or use wo.order_date if exists
        //         supplier: wo.supplier?.supplier_name ?? "Unknown",
        //         quantity: wo.total_qty,
        //         value: wo.total_value,
        //         status: wo.status ?? "pending"
        //     };
        // });
        // Sample data for all suppliers
        // const allData = [
        //     { date: '2023-10-01', supplier: 'Supplier A', product: 'Product X', sales: 500000, value: 450000, workOrderQty: 25, receiveQty: 20, status: 'completed' },
        //     { date: '2023-10-02', supplier: 'Supplier B', product: 'Product Y', sales: 300000, value: 280000, workOrderQty: 15, receiveQty: 12, status: 'completed' },
        //     { date: '2023-10-03', supplier: 'Supplier C', product: 'Product Z', sales: 700000, value: 650000, workOrderQty: 30, receiveQty: 25, status: 'completed' },
        //     { date: '2023-10-04', supplier: 'Supplier A', product: 'Product X', sales: 450000, value: 420000, workOrderQty: 20, receiveQty: 18, status: 'in-progress' },
        //     { date: '2023-10-05', supplier: 'Supplier B', product: 'Product Y', sales: 320000, value: 300000, workOrderQty: 18, receiveQty: 15, status: 'completed' },
        //     { date: '2023-10-06', supplier: 'Supplier D', product: 'Product W', sales: 600000, value: 550000, workOrderQty: 28, receiveQty: 22, status: 'pending' },
        //     { date: '2023-10-07', supplier: 'Supplier C', product: 'Product Z', sales: 550000, value: 500000, workOrderQty: 22, receiveQty: 20, status: 'delayed' },
        //     { date: '2023-10-08', supplier: 'Supplier A', product: 'Product X', sales: 480000, value: 440000, workOrderQty: 24, receiveQty: 20, status: 'completed' },
        //     { date: '2023-10-09', supplier: 'Supplier E', product: 'Product V', sales: 400000, value: 380000, workOrderQty: 20, receiveQty: 18, status: 'in-progress' },
        //     { date: '2023-10-10', supplier: 'Supplier B', product: 'Product Y', sales: 350000, value: 320000, workOrderQty: 19, receiveQty: 16, status: 'completed' },
        //     { date: '2023-09-25', supplier: 'Supplier F', product: 'Product U', sales: 520000, value: 480000, workOrderQty: 26, receiveQty: 22, status: 'completed' },
        //     { date: '2023-09-26', supplier: 'Supplier C', product: 'Product Z', sales: 610000, value: 570000, workOrderQty: 29, receiveQty: 24, status: 'completed' },
        //     { date: '2023-09-27', supplier: 'Supplier A', product: 'Product X', sales: 470000, value: 430000, workOrderQty: 23, receiveQty: 19, status: 'pending' },
        //     { date: '2023-09-28', supplier: 'Supplier D', product: 'Product W', sales: 580000, value: 540000, workOrderQty: 27, receiveQty: 23, status: 'completed' },
        //     { date: '2023-09-29', supplier: 'Supplier E', product: 'Product V', sales: 420000, value: 390000, workOrderQty: 21, receiveQty: 18, status: 'delayed' },
        //     { date: '2023-09-30', supplier: 'Supplier B', product: 'Product Y', sales: 330000, value: 310000, workOrderQty: 17, receiveQty: 14, status: 'completed' }
        // ];

        // Chart instances
        let supplierChartInstance = null;
        let pieChartInstance = null;
        let barChartInstance = null;
        let salesChartInstance = null;

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            console.log('All Data:', allData);
            allData.forEach(item => {
                console.log(`Date: ${item.date}, Supplier: ${item.supplier}, Product: ${item.product}, Sales: ${item.sales}, Value: ${item.value}, Work Order Qty: ${item.workOrderQty}, Receive Qty: ${item.receiveQty}, Status: ${item.status}`);
            });
            updateDashboard();
        });

        // Update dashboard based on selected supplier
        function updateDashboard() {
            const supplierFilter = document.getElementById('supplierFilter');
            const selectedSupplier = supplierFilter.value;
            
            // Filter data based on selection
            const filteredData = selectedSupplier === 'all' 
                ? allData 
                : allData.filter(item => item.supplier === selectedSupplier);
            
            // Update KPIs
            updateKPIs(filteredData);
            
            // Update charts
            updateSupplierChart(filteredData);
            updatePieChart(filteredData);
            updateBarChart(filteredData);
            updateSalesChart(filteredData);
            
            // Update order status
            updateOrderStatus(filteredData);
            
            // Highlight if a specific supplier is selected
            if (selectedSupplier !== 'all') {
                document.querySelector('.supplier-selector').classList.add('supplier-highlight');
            } else {
                document.querySelector('.supplier-selector').classList.remove('supplier-highlight');
            }
        }

        // Update KPI cards
        function updateKPIs(data) {
            const totalSales = data.reduce((sum, item) => sum + item.sales, 0);
            const uniqueSuppliers = new Set(data.map(item => item.supplier)).size;
            const totalWorkOrder = data.reduce((sum, item) => sum + item.workOrderQty, 0);
            const totalWorkOrderValue = data.reduce((sum, item) => sum + item.value, 0);
            
            document.getElementById('totalSales').textContent = formatNumber(totalSales);
            document.getElementById('totalSupplier').textContent = uniqueSuppliers;
            document.getElementById('totalWorkOrder').textContent = totalWorkOrder;
            document.getElementById('totalWorkOrderValue').textContent = formatNumber(totalWorkOrderValue);
        }

        // Update order status
        function updateOrderStatus(data) {
            const completed = data.filter(item => item.status === 'completed').length;
            const inProgress = data.filter(item => item.status === 'in-progress').length;
            const pending = data.filter(item => item.status === 'pending').length;
            const delayed = data.filter(item => item.status === 'delayed').length;
            
            document.getElementById('completedOrders').textContent = completed;
            document.getElementById('progressOrders').textContent = inProgress;
            document.getElementById('pendingOrders').textContent = pending;
            document.getElementById('delayedOrders').textContent = delayed;
        }

        // Update Supplier Order Analysis Chart
        function updateSupplierChart(data) {
            const ctx = document.getElementById('supplierChart').getContext('2d');
            
            // Destroy previous chart if it exists
            if (supplierChartInstance) {
                supplierChartInstance.destroy();
            }
            
            // Group by supplier and calculate totals
            const supplierStats = {};
            data.forEach(item => {
                if (!supplierStats[item.supplier]) {
                    supplierStats[item.supplier] = {
                        quantity: 0,
                        value: 0
                    };
                }
                supplierStats[item.supplier].quantity += item.workOrderQty;
                supplierStats[item.supplier].value += item.value;
            });
            
            const suppliers = Object.keys(supplierStats);
            const quantities = suppliers.map(supplier => supplierStats[supplier].quantity);
            const values = suppliers.map(supplier => supplierStats[supplier].value);
            
            supplierChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: suppliers,
                    datasets: [{
                        label: 'Order Quantity',
                        data: quantities,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }, {
                        label: 'Order Value (BDT)',
                        data: values,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1,
                        type: 'line',
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Order Quantity'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Order Value (BDT)'
                            },
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('bn-BD');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label.includes('Value')) {
                                        return label + ': ' + context.raw.toLocaleString('bn-BD') + ' BDT';
                                    }
                                    return label + ': ' + context.raw;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Update Pie Chart - Work Order vs Receive
        function updatePieChart(data) {
            const ctx = document.getElementById('pieChart').getContext('2d');
            
            // Destroy previous chart if it exists
            if (pieChartInstance) {
                pieChartInstance.destroy();
            }
            
            const totalWO = data.reduce((sum, item) => sum + item.workOrderQty, 0);
            const totalReceive = data.reduce((sum, item) => sum + item.receiveQty, 0);
            
            pieChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Work Order', 'Receive'],
                    datasets: [{
                        data: [totalWO, totalReceive],
                        backgroundColor: [
                            'rgba(234, 67, 53, 0.8)',
                            'rgba(52, 168, 83, 0.8)'
                        ],
                        borderColor: [
                            'rgb(234, 67, 53)',
                            'rgb(52, 168, 83)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Update Bar Chart - Work Order vs Receive Over Time
        function updateBarChart(data) {
            const ctx = document.getElementById('barChart').getContext('2d');
            
            // Destroy previous chart if it exists
            if (barChartInstance) {
                barChartInstance.destroy();
            }
            
            // Group by date and calculate totals
            const dateStats = {};
            data.forEach(item => {
                if (!dateStats[item.date]) {
                    dateStats[item.date] = {
                        workOrder: 0,
                        receive: 0
                    };
                }
                dateStats[item.date].workOrder += item.workOrderQty;
                dateStats[item.date].receive += item.receiveQty;
            });
            
            // Convert to arrays and sort by date
            const dates = Object.keys(dateStats).sort();
            const workOrderData = dates.map(date => dateStats[date].workOrder);
            const receiveData = dates.map(date => dateStats[date].receive);
            
            barChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Work Order',
                            data: workOrderData,
                            backgroundColor: 'rgba(234, 67, 53, 0.7)',
                            borderColor: 'rgb(234, 67, 53)',
                            borderWidth: 1
                        },
                        {
                            label: 'Receive',
                            data: receiveData,
                            backgroundColor: 'rgba(52, 168, 83, 0.7)',
                            borderColor: 'rgb(52, 168, 83)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Quantity'
                            }
                        }
                    }
                }
            });
        }

        // Update Sales by Product Chart
        function updateSalesChart(data) {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const productLimit = document.getElementById('productLimit').value;
            
            // Destroy previous chart if it exists
            if (salesChartInstance) {
                salesChartInstance.destroy();
            }
            
            // Calculate sales by product
            const salesByProduct = {};
            data.forEach(item => {
                if (!salesByProduct[item.product]) salesByProduct[item.product] = 0;
                salesByProduct[item.product] += item.sales;
            });
            
            // Convert to array and sort by sales
            let products = Object.keys(salesByProduct);
            let totalSalesPerProduct = products.map(product => salesByProduct[product]);
            
            // Sort by sales (descending)
            const combined = products.map((product, i) => {
                return { product, sales: totalSalesPerProduct[i] };
            });
            
            combined.sort((a, b) => b.sales - a.sales);
            
            products = combined.map(item => item.product);
            totalSalesPerProduct = combined.map(item => item.sales);
            
            // Apply limit if not "all"
            if (productLimit !== 'all') {
                const limit = parseInt(productLimit);
                products = products.slice(0, limit);
                totalSalesPerProduct = totalSalesPerProduct.slice(0, limit);
            }
            
            salesChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: products,
                    datasets: [{
                        label: 'Sales (BDT)',
                        data: totalSalesPerProduct,
                        backgroundColor: 'rgba(76, 126, 233, 0.6)',
                        borderColor: 'rgb(76, 126, 233)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales (BDT)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('bn-BD');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Sales: ' + context.raw.toLocaleString('bn-BD') + ' BDT';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Helper function to format numbers
        function formatNumber(num) {
            return num.toLocaleString('bn-BD');
        }
    </script>
@endsection
