@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Dashboard - Super Admin</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <!-- Total Businesses Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Businesses</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalBusinesses }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-600 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                </svg>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Customers</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalCustomers }}</p>
                </div>
                <svg class="w-12 h-12 text-green-600 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
        </div>

        <!-- Total Visits Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Visits</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalVisits }}</p>
                </div>
                <svg class="w-12 h-12 text-purple-600 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-3xl font-bold text-orange-600" id="totalProducts">-</p>
                </div>
                <svg class="w-12 h-12 text-orange-600 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Business Filter and Chart -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="mb-4">
            <label class="block mb-2">
                <span class="text-gray-700">Filter by Business:</span>
                <select id="businessFilter" class="w-full md:w-64 border rounded px-3 py-2 mt-1">
                    <option value="">All Businesses</option>
                    @foreach($businesses as $business)
                        <option value="{{ $business->id }}">{{ $business->name }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <h2 class="text-xl font-bold mb-4">Monthly Visits (Last 12 Months)</h2>
        <canvas id="visitsChart" class="mb-4"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let visitsChart;
    const monthlyData = {!! json_encode($monthlyVisitsData) !!};
    const businesses = {!! json_encode($businesses->toArray()) !!};

    function initChart(data) {
        const ctx = document.getElementById('visitsChart').getContext('2d');
        
        if (visitsChart) {
            visitsChart.destroy();
        }
        
        visitsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Visits',
                    data: data.counts,
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#8B5CF6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: { font: { size: 12 } }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    document.getElementById('businessFilter').addEventListener('change', async (e) => {
        const businessId = e.target.value;
        
        if (businessId) {
            try {
                const response = await fetch(`/dashboard/visits/${businessId}`);
                const data = await response.json();
                initChart(data);
                
                // Update products count
                const productsResponse = await fetch(`/dashboard/products/${businessId}`);
                const productsData = await productsResponse.json();
                document.getElementById('totalProducts').textContent = productsData.totalProducts;
            } catch (error) {
                console.error('Error:', error);
            }
        } else {
            initChart(monthlyData);
            document.getElementById('totalProducts').textContent = '-';
        }
    });

    // Initialize chart on load
    initChart(monthlyData);
</script>
@endsection
