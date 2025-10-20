// public/backend/assets/js/monthly-sales.js
(function () {
  function initMonthlySales() {
    var el = document.querySelector('#monthly-sales');
    if (!el) {
      console.warn('[MonthlySales] #monthly-sales not found on this page.');
      return;
    }

    // Destroy previous instance if hot-nav or partial reloads
    if (window._monthlySalesChart) {
      try { window._monthlySalesChart.destroy(); } catch (e) {}
      window._monthlySalesChart = null;
    }

    // Example data — replace with real data later
    var options = {
      chart: { type: 'line', height: 350, toolbar: { show: false } },
      series: [{ name: 'Sales', data: [10, 20, 15, 40, 35, 50, 65, 70, 90, 85, 95, 110] }],
      xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
      stroke: { width: 3, curve: 'smooth' },
      markers: { size: 4 },
      dataLabels: { enabled: true },
      grid: { strokeDashArray: 4 }
    };

    try {
      window._monthlySalesChart = new ApexCharts(el, options);
      window._monthlySalesChart.render();
      console.log('[MonthlySales] Chart rendered.');
    } catch (err) {
      console.error('[MonthlySales] Failed to render chart:', err);
    }
  }

  // Run after DOM is ready (works with defer and without)
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMonthlySales);
  } else {
    initMonthlySales();
  }
})();
