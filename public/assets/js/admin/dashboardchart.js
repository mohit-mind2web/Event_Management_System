document.addEventListener("DOMContentLoaded",function(){
    if(!window.eventstatusdata) return ;
    const series = [
        eventstatusdata.approved,
        eventstatusdata.pending,
        eventstatusdata.rejected
    ];

    const options = {
        chart: { 
            type: 'pie', 
            height: 300 
        },
        labels: ['Approved', 'Pending', 'Rejected'],
        series: series,
        colors: ['#28a745', '#ffc107', '#dc3545']
    };
  new ApexCharts(document.querySelector("#eventStatusChart"),options).render();
    //payment revenue chart

      if (window.paymentChartData) {
        new ApexCharts(
            document.querySelector("#paymentsChart"),
            {
                chart: { type: 'bar', height: 250 },
                series: [{
                    name: 'Revenue (₹)',
                    data: paymentChartData.totals
                }],
                xaxis: {
                    categories: paymentChartData.months
                },
                colors: ['#0d6efd'],
                dataLabels: { enabled: false }
            }
        ).render();
    }

    //registartion trend chart
     if (window.registrationChartData) {
        new ApexCharts(
            document.querySelector("#registrationsChart"),
            {
                chart: { type: 'line', height: 250 },
                series: [{
                    name: 'Registrations',
                    data: registrationChartData.totals
                }],
                xaxis: {
                    categories: registrationChartData.dates
                },
                stroke: { curve: 'smooth' },
                colors: ['#198754']
            }
        ).render();
    }
})
