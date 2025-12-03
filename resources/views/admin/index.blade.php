@extends('admin.admin_master')
@section('admin')
    @php
        $totalUsers = App\Models\User::count();
        $newUsers = App\Models\User::whereMonth('created_at', now()->month)->count();
        $percentage = $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100, 2) : 0;
    @endphp

    @php
        $totalproduct = App\Models\Product::count();
        $newproduct = App\Models\Product::whereMonth('created_at', now()->month)->count();
        $percentage = $totalproduct > 0 ? round(($newproduct / $totalproduct) * 100, 2) : 0;
    @endphp

    @php
        $totalAmount = App\Models\Sale::sum('paid_amount'); // all sales
        $paidAmount = App\Models\Sale::where('paid_amount', '>', 0)->sum('paid_amount'); // all paid
        $percentage = $totalAmount > 0 ? round(($paidAmount / $totalAmount) * 100, 2) : 0;
    @endphp





    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid my-0">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                </div>
            </div>

            <!-- start row -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">



                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">All User Chart</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $totalUsers }}</div>
                                        <div class="me-auto">
                                            <span class="text-primary d-inline-flex align-items-center">
                                                {{ $percentage }}%
                                                <i data-feather="trending-up" class="ms-1"
                                                    style="height: 22px; width: 22px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="website-visitors" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">All Product Chart</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $totalproduct }}</div>
                                        <div class="me-auto">

                                            <span class="text-info d-inline-flex align-items-center">
                                                {{ $percentage }}%
                                                <i data-feather="trending-up" class="ms-1"
                                                    style="height: 22px; width: 22px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="conversion-visitors" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Sale Total Amount</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $totalAmount }}</div>
                                        <div class="me-auto">
                                            <span class="text-success d-inline-flex align-items-center">
                                                {{ $percentage }}%
                                                <i data-feather="trending-up" class="ms-1"
                                                    style="height: 22px; width: 22px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="session-visitors" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        @php
                            $allwarehouses = App\Models\WareHouse::count();
                        @endphp

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Active Warehouse</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">{{ $allwarehouses }}</div>
                                        <div class="me-auto">
                                            <span class="text-success d-inline-flex align-items-center">

                                                <i data-feather="trending-up" class="ms-1"
                                                    style="height: 22px; width: 22px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="active-users" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end sales -->
            </div> <!-- end row -->

            @php
                use App\Models\Sale;
                use Illuminate\Support\Facades\DB;

                // Last 6 months Paid vs Due
                $salesData = Sale::select(
                    DB::raw("DATE_FORMAT(date, '%b') as month"),
                    DB::raw('SUM(paid_amount) as paid'),
                    DB::raw('SUM(due_amount)  as due'),
                )
                    ->whereYear('date', date('Y'))
                    ->where('date', '>=', now()->subMonths(6))
                    ->groupBy('month')
                    ->get();

                $months = $salesData->pluck('month');
                $paidTotals = $salesData->pluck('paid');
                $dueTotals = $salesData->pluck('due');
            @endphp

            <!-- Start Monthly Sales -->
            <div class="row">

               <div class="col-md-6 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="bar-chart" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Monthly Sales ({{ $chart['year'] ?? now()->year }})</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="monthly-sales" class="apex-charts"></div>
                    </div>
                </div>
            </div>

                {{-- Recent Actions Section --}}
                @php
                    $recentActivities = \App\Models\Activity::with('user')->latest()->take(10)->get();
                @endphp

                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                    <i data-feather="clock" class="widgets-icons"></i>
                                </div>
                                <h5 class="card-title mb-0">Recent Actions</h5>
                            </div>
                        </div>

                        <div class="card-body" style="max-height: 345px; overflow-y: auto;">
                            @forelse($recentActivities as $activity)
                                <div class="mb-2">
                                    <strong>
                                        @if ($activity->user)
                                            {{ $activity->user->name }}
                                        @else
                                            System
                                        @endif
                                        — {{ ucfirst($activity->action) }} {{ $activity->model }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                <hr>
                            @empty
                                <p>No recent activity found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>


            <a href="{{ asset('download/MyAppInstaller.exe') }}" class="btn btn-primary">
    Install App
</a>






            </div>
            <!-- End Monthly Sales -->



        </div> <!-- container-fluid -->
    </div>

    {{-- ApexCharts CDN (once per page) --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
let deferredPrompt;
const installBtn = document.getElementById('installBtn');

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the default mini-infobar from appearing
    e.preventDefault();
    deferredPrompt = e;
    installBtn.style.display = 'block';
});

installBtn.addEventListener('click', async () => {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        console.log(`User response: ${outcome}`);
        deferredPrompt = null;
        installBtn.style.display = 'none';
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // PHP → JS
    const categories = @json($chart['categories'] ?? []);
    const paid       = @json($chart['paid'] ?? []);
    const due        = @json($chart['due'] ?? []);

    // Fallback if no data
    if (!categories.length) {
        document.querySelector('#monthly-sales').innerHTML =
            '<div class="text-muted">No sales data yet.</div>';
        return;
    }

    const options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        series: [
            { name: 'Paid Amount', data: paid },
            { name: 'Due Amount',  data: due  }
        ],
        xaxis: {
            categories: categories,
            axisBorder: { show: false },
            axisTicks:  { show: false }
        },
        dataLabels: { enabled: false },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                borderRadius: 6
            }
        },
        stroke: { show: true, width: 2 },
        grid: { strokeDashArray: 4 },
        legend: { position: 'top' },
        tooltip: {
            y: {
                formatter: function (val) {
                    // Format with 2 decimals; change to your currency if you like
                    return new Intl.NumberFormat(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(val);
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#monthly-sales"), options);
    chart.render();
});
</script>
@endsection
