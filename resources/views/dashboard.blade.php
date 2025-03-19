@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="admin-heading">Dashboard</h2>
            </div>
        </div>
        <div class="row">
            @php
            $cards = [
                ['icon' => 'fa-user',       'count' => $authors,      'label' => 'Authors Listed',        'bg' => 'primary'],
                ['icon' => 'fa-building',     'count' => $publishers,   'label' => 'Publishers Listed',       'bg' => 'success'],
                ['icon' => 'fa-tags',         'count' => $categories,   'label' => 'Categories Listed',       'bg' => 'warning'],
                ['icon' => 'fa-book',         'count' => $books,        'label' => 'Books Listed',            'bg' => 'info'],
                ['icon' => 'fa-users',        'count' => $students,     'label' => 'Registered Students',     'bg' => 'secondary'],
                ['icon' => 'fa-book-open',    'count' => $issued_books, 'label' => 'Books Issued',            'bg' => 'danger'],
            ];
            @endphp

            @foreach ($cards as $card)
            <div class="col-md-4 col-lg-2 mb-4">
                <div class="card text-white bg-{{ $card['bg'] }} shadow" style="height: 120px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                        <div class="mb-1">
                            <i class="fa {{ $card['icon'] }} fa-lg"></i>
                        </div>
                        <h6 class="card-title text-center small mb-1">{{ $card['label'] }}</h6>
                        <p class="card-text h4 mb-0">{{ $card['count'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-12">
                <canvas id="bookIssueChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Parse the PHP arrays into JavaScript variables
    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);

    const ctx = document.getElementById('bookIssueChart').getContext('2d');
    const bookIssueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Book Issues (Past 5 Days)',
                data: chartData,
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection
