/**
|--------------------------------------------------------------------------
| PEMUAT GRAFIK OTOMATIS (APEXCHARTS LOADER)
|--------------------------------------------------------------------------
| Berkas ini digunakan untuk mendeteksi kontainer grafik dengan kelas
| '.apex-chart-container', membaca data konfigurasi dari atribut HTML data-*,
| dan menginisialisasi grafik ApexCharts secara aman tanpa inline script.
|
| MITIGASI KEAMANAN:
| 1. Menghilangkan penggunaan inline <script> yang memuat data JSON langsung
|    di dalam berkas Blade. Langkah ini mematuhi standar keamanan CSP yang ketat
|    (tanpa 'unsafe-inline' untuk script-src).
| 2. Data grafik dilewatkan melalui atribut HTML data-* yang otomatis di-escape
|    oleh Laravel (HTML attribute escaping) untuk mencegah injeksi kode XSS.
*/

import ApexCharts from 'apexcharts';

/**
 * Fungsi untuk menginisialisasi satu grafik ApexCharts berdasarkan elemen kontainer.
 * @param {HTMLElement} element 
 */
function initChart(element) {
    if (!element) return;

    try {
        // Ambil data dari atribut HTML data-*
        const chartSeries = JSON.parse(element.getAttribute('data-series') || '[]');
        const chartCategories = JSON.parse(element.getAttribute('data-categories') || '[]');
        const chartHeight = Number(element.getAttribute('data-height') || '300');
        const chartLocale = element.getAttribute('data-locale') || 'id-ID';

        // Ambil gaya warna basis untuk teks dari elemen :root
        const style = getComputedStyle(document.documentElement);

        const colors = [
            '#422ad5', // primary (main)
            '#8f99dc', // secondary/accent (main)
            '#ff6200', // accent
            '#10b981', // success
        ];

        const options = {
            chart: {
                type: 'area',
                height: chartHeight,
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            series: chartSeries,
            xaxis: {
                type: 'datetime',
                categories: chartCategories,
                tickAmount: 6,
                labels: {
                    hideOverlappingLabels: false,
                    style: {
                        colors: '#9CA3AF',
                        fontSize: '11px',
                        fontFamily: 'Inter, sans-serif'
                    },
                    formatter: function(val, timestamp) {
                        return new Date(timestamp).toLocaleDateString(chartLocale, {
                            day: 'numeric',
                            month: 'short'
                        });
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tooltip: { enabled: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#9CA3AF',
                        fontSize: '11px',
                        fontFamily: 'Inter, sans-serif'
                    },
                    formatter: function(val) {
                        return val.toFixed(0);
                    }
                }
            },
            grid: {
                borderColor: '#F3F4F6',
                strokeDashArray: 4,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 10
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            tooltip: {
                theme: 'light',
                style: { fontSize: '12px' },
                x: {
                    show: true,
                    formatter: function(val) {
                        return new Date(val).toLocaleDateString(chartLocale, {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                    }
                },
                marker: { show: true },
            },
            colors: colors,
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -20,
                itemMargin: {
                    horizontal: 10,
                    vertical: 0
                },
                labels: {
                    colors: style.getPropertyValue('--color-base-content').trim() || '#374151',
                    useSeriesColors: false
                }
            }
        };

        const chart = new ApexCharts(element, options);
        chart.render();

        // Pantau perubahan tema (data-theme attr) agar warna legend otomatis terupdate
        const observer = new MutationObserver(function() {
            const newColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-base-content').trim() || '#374151';
            chart.updateOptions({
                legend: {
                    labels: {
                        colors: newColor
                    }
                }
            }, false, false);
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme']
        });

    } catch (error) {
        console.error('Gagal menginisialisasi grafik ApexCharts:', error);
    }
}

/**
 * Fungsi utama untuk mencari dan memuat seluruh grafik di halaman.
 */
function initAllCharts() {
    const chartElements = document.querySelectorAll('.apex-chart-container');
    chartElements.forEach(element => {
        // Hindari inisialisasi ganda pada elemen yang sama
        if (element.classList.contains('chart-initialized')) return;
        element.classList.add('chart-initialized');
        initChart(element);
    });
}

// Tunggu hingga DOM selesai memuat
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllCharts);
} else {
    initAllCharts();
}
