<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.3') }}"></script>

<script>

    "use strict";

    // Shared Colors Definition
    const primary = '#6993FF';
    const success = '#1BC5BD';
    const info = '#8950FC';
    const warning = '#FFA800';
    const danger = '#F64E60';

    // Class definition
    function generateBubbleData(baseval, count, yrange) {
        var i = 0;
        var series = [];
        while (i < count) {
            var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;
            ;
            var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
            var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

            series.push([x, y, z]);
            baseval += 86400000;
            i++;
        }
        return series;
    }

    function generateData(count, yrange) {
        var i = 0;
        var series = [];
        while (i < count) {
            var x = 'w' + (i + 1).toString();
            var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

            series.push({
                x: x,
                y: y
            });
            i++;
        }
        return series;
    }

    var safeTotalSpan = $("#safeTotalSpan");
    var createReceiptButton = $("#createReceiptButton");

    /////////////////////////////////////////////////////////////////////////////////

    var dailyChartOptions = {
        series: [
            {
                name: 'Gelir',
                data: [0]
            },
            {
                name: 'Gider',
                data: [0]
            }
        ],
        chart: {
            type: 'bar',
            height: 250
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Gün Sonu'],
        },
        yaxis: {
            title: {
                text: 'TL'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " TL"
                }
            }
        },
        colors: [success, danger]
    };

    var dailyChart = new ApexCharts(document.querySelector("#dailyCard"), dailyChartOptions);
    dailyChart.render();

    function dailyChartUpdater() {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax.receipts.receiptsByDate') }}',
            data: {
                start_date: '{{ date('Y-m-d') }}',
                end_date: '{{ date('Y-m-d') }}'
            },
            success: function (receipts) {
                dailyChart.updateSeries([
                    {
                        name: 'Gelir',
                        data: [receipts.incoming]
                    },
                    {
                        name: 'Gider',
                        data: [receipts.outgoing]
                    }
                ]);
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    /////////////////////////////////////////////////////////////////////////////////

    var weeklyChartOptions = {
        series: [
            {
                name: 'Gelir',
                data: [0]
            },
            {
                name: 'Gider',
                data: [0]
            }
        ],
        chart: {
            type: 'bar',
            height: 250
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Haftalık Durum'],
        },
        yaxis: {
            title: {
                text: 'TL'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " TL"
                }
            }
        },
        colors: [success, danger]
    };

    var weeklyChart = new ApexCharts(document.querySelector("#weeklyCard"), weeklyChartOptions);
    weeklyChart.render();

    function weeklyChartUpdater() {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax.receipts.receiptsByDate') }}',
            data: {
                start_date: '{{ date("Y-m-d", strtotime('monday this week')) }}',
                end_date: '{{ date("Y-m-d", strtotime('sunday this week')) }}'
            },
            success: function (receipts) {
                weeklyChart.updateSeries([
                    {
                        name: 'Gelir',
                        data: [receipts.incoming]
                    },
                    {
                        name: 'Gider',
                        data: [receipts.outgoing]
                    }
                ]);
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    /////////////////////////////////////////////////////////////////////////////////

    var monthlyChartOptions = {
        series: [
            {
                name: 'Gelir',
                data: [0]
            },
            {
                name: 'Gider',
                data: [0]
            }
        ],
        chart: {
            type: 'bar',
            height: 250
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Aylık Durum'],
        },
        yaxis: {
            title: {
                text: 'TL'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " TL"
                }
            }
        },
        colors: [success, danger]
    };

    var monthlyChart = new ApexCharts(document.querySelector("#monthlyCard"), monthlyChartOptions);
    monthlyChart.render();

    function monthlyChartUpdater() {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax.receipts.receiptsByDate') }}',
            data: {
                start_date: '{{ date('Y-m-01') }}',
                end_date: '{{ date('Y-m-t') }}'
            },
            success: function (receipts) {
                monthlyChart.updateSeries([
                    {
                        name: 'Gelir',
                        data: [receipts.incoming]
                    },
                    {
                        name: 'Gider',
                        data: [receipts.outgoing]
                    }
                ]);
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    /////////////////////////////////////////////////////////////////////////////////

    dailyChartUpdater();
    weeklyChartUpdater();
    monthlyChartUpdater();

    function safeTotal() {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax.receipts.safeTotal') }}',
            data: {},
            success: function (safeTotal) {
                safeTotalSpan.html(safeTotal);
            },
            error: function () {

            }
        });
    }

    safeTotal();

    $('.decimal').on("copy cut paste drop", function () {
        return false;
    }).keyup(function () {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);
    });

    createReceiptButton.click(function () {
        var user_id = '{{ auth()->user()->id() }}';
        var safe_id = 1;
        var direction = $("#create_receipt_direction").val();
        var date = $("#create_receipt_date").val();
        var price = $("#create_receipt_price").val();
        var description = $("#create_receipt_description").val();

        if (user_id === '') {
            toastr.error('Kullanıcıda Sistemsel Bir Hata Oluştu. Sayfayı Yenilemeyi Deneyin.');
        } else if (safe_id === '') {
            toastr.error('Kasada Sistemsel Bir Hata Oluştu. Sayfayı Yenilemeyi Deneyin.');
        } else if (direction == null || direction === '') {
            toastr.warning('Gelir/Gider Türü Seçmediniz!');
        } else if (date == null || date === '') {
            toastr.warning('Tarih Seçmediniz!');
        } else if (price == null || price === '') {
            toastr.warning('Tutar Girmediniz!');
        } else {
            $.ajax({
                type: 'post',
                url: '{{ route('ajax.receipts.save') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id,
                    safe_id: safe_id,
                    direction: direction,
                    date: date,
                    price: price,
                    description: description
                },
                success: function () {
                    toastr.success('Fiş Başarıyla Oluşturuldu');
                    $("#CreateReceiptModal").modal('hide');
                    $("#CreateReceiptForm").trigger('reset');
                    $("#create_receipt_direction").selectpicker('refresh');
                    safeTotal();
                    dailyChartUpdater();
                    weeklyChartUpdater();
                    monthlyChartUpdater();
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    });

</script>
