var Dashboard = function() {

    return {

        initCalendar: function() {
            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if ($('#calendar').width() <= 400) {
                $('#calendar').addClass("mobile");
                h = {
                    left: 'title, prev, next',
                    center: '',
                    right: 'today,month,agendaWeek,agendaDay'
                };
            } else {
                $('#calendar').removeClass("mobile");
                if (App.isRTL()) {
                    h = {
                        right: 'title',
                        center: '',
                        left: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                } else {
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }



            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                disableDragging: false,
                header: h,
                editable: true,
                events: [{
                    title: 'All Day',
                    start: new Date(y, m, 1),
                    backgroundColor: App.getBrandColor('yellow')
                }, {
                    title: 'Long Event',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2),
                    backgroundColor: App.getBrandColor('blue')
                }, {
                    title: 'Repeating Event',
                    start: new Date(y, m, d - 3, 16, 0),
                    allDay: false,
                    backgroundColor: App.getBrandColor('red')
                }, {
                    title: 'Repeating Event',
                    start: new Date(y, m, d + 6, 16, 0),
                    allDay: false,
                    backgroundColor: App.getBrandColor('green')
                }, {
                    title: 'Meeting',
                    start: new Date(y, m, d + 9, 10, 30),
                    allDay: false
                }, {
                    title: 'Lunch',
                    start: new Date(y, m, d, 14, 0),
                    end: new Date(y, m, d, 14, 0),
                    backgroundColor: App.getBrandColor('grey'),
                    allDay: false
                }, {
                    title: 'Birthday',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    backgroundColor: App.getBrandColor('purple'),
                    allDay: false
                }, {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    backgroundColor: App.getBrandColor('yellow'),
                    url: 'http://google.com/'
                }]
            });
        },

        initCharts: function() {
            loadChartTraffic();
            loadChartOrder();
        },        
        
        initDashboardDaterange: function() {
            if (!jQuery().daterangepicker) {
                return;
            }

            $('#dashboard-report-range').daterangepicker({
                "ranges": {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                "locale": {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Su",
                        "Mo",
                        "Tu",
                        "We",
                        "Th",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                    "firstDay": 1
                },
                //"startDate": "11/08/2015",
                //"endDate": "11/14/2015",
                opens: (App.isRTL() ? 'right' : 'left'),
            }, function(start, end, label) {
                $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            $('#dashboard-report-range span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#dashboard-report-range').show();
        },

        init: function() {

            //this.initJQVMAP();
            this.initCalendar();
            this.initCharts();
            //this.initEasyPieCharts();
            //this.initSparklineCharts();
            //this.initChat();
            this.initDashboardDaterange();
            //this.initMorisCharts();

            //this.initAmChart1();
            //this.initAmChart2();
            //this.initAmChart3();
            //this.initAmChart4();

            //this.initWorldMapStats();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Dashboard.init(); // init metronic core componets
        loadNotification();
    });
}

function loadChartTraffic(dateTo_,dateEnd_){
    if (!jQuery.plot) {
        return;
    }

    function showChartTooltip(x, y, xValue, yValue) {
        $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 40,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#fff'
        }).appendTo("body").fadeIn(200);
    }

    var data = [];

    if ($('#site_statistics').size() != 0) {

        $('#site_statistics_loading').hide();
        $('#site_statistics_content').show();
        
        var url = 'home/getChartTraffic';
        var dataAjax = {
                dateTo:dateTo_,
                dateEnd:dateEnd_
            };
        var ajax = $.post(url,dataAjax);
        ajax.success(function(lazi_chart_traffic){
            lazi_chart_traffic = jQuery.parseJSON(lazi_chart_traffic);
            // console.log(lazi_chart_traffic);
            var plot_statistics = $.plot($("#site_statistics"), [{
                
            data: lazi_chart_traffic,
                lines: {
                    fill: 0.6,
                    lineWidth: 0
                },
                color: ['#f89f9f']
            }, {
                data: lazi_chart_traffic,
                points: {
                    show: true,
                    fill: true,
                    radius: 5,
                    fillColor: "#f89f9f",
                    lineWidth: 3
                },
                color: '#fff',
                shadowSize: 0
            }],
    
            {
                xaxis: {
                    tickLength: 0,
                    tickDecimals: 0,
                    mode: "categories",
                    min: 0,
                    font: {
                        lineHeight: 14,
                        style: "normal",
                        variant: "small-caps",
                        color: "#6F7B8A"
                    }
                },
                yaxis: {
                    ticks: 5,
                    tickDecimals: 0,
                    tickColor: "#eee",
                    font: {
                        lineHeight: 14,
                        style: "normal",
                        variant: "small-caps",
                        color: "#6F7B8A"
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1
                }
            });
            
            var previousPoint = null;
            $("#site_statistics").bind("plothover", function(event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' lượt truy cập');
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        });
        
        /** lazi_chart_traffic file: index/include/chart_traffic */
    }
}

function loadChartOrder(dateTo_,dateEnd_){
    function showChartTooltip(x, y, xValue, yValue) {
        $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 40,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#fff'
        }).appendTo("body").fadeIn(200);
    }
    var url = 'home/getChartOrder';
    var dataAjax = {
        'dateTo':dateTo_,
        'dateEnd':dateEnd_
    };
    var ajax = $.post(url,dataAjax);
    
    ajax.success(function(lazi_chart_order){
        lazi_chart_order = jQuery.parseJSON(lazi_chart_order);
        // console.log(lazi_chart_order);
        
        if ($('#site_activities').size() != 0) {
            //site activities
            var previousPoint2 = null;
            $('#site_activities_loading').hide();
            $('#site_activities_content').show();
        
            /** lazi_chart_order file: index/include/chart_order */
            var plot_statistics = $.plot($("#site_activities"),
        
                [{
                    data: lazi_chart_order.chart,
                    lines: {
                        fill: 0.2,
                        lineWidth: 0,
                    },
                    color: ['#BAD9F5']
                }, {
                    data: lazi_chart_order.chart,
                    points: {
                        show: true,
                        fill: true,
                        radius: 4,
                        fillColor: "#9ACAE6",
                        lineWidth: 2
                    },
                    color: '#9ACAE6',
                    shadowSize: 1
                }, {
                    data: lazi_chart_order.chart,
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 3
                    },
                    color: '#9ACAE6',
                    shadowSize: 0
                }],
        
                {
        
                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 18,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#eee",
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    }
                });
        
            $("#site_activities").bind("plothover", function(event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint2 != item.dataIndex) {
                        previousPoint2 = item.dataIndex;
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);
                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' đ');
                    }
                }
            });
        
            $('#site_activities').bind("mouseleave", function() {
                $("#tooltip").remove();
            });
        }
        $('#chart_order_total').html(lazi_chart_order.total_amount);
        $('#chart_order_qty').html(lazi_chart_order.qty);
    });
}

function changeChartTraffic(thisBtn){
    if($(thisBtn).hasClass('active')==false){
        var dateTo = $(thisBtn).find('input').attr('dateto');
        var dateEnd = $(thisBtn).find('input').attr('dateend');
        loadChartTraffic(dateTo,dateEnd);
    }
}

function changeChartOrder(thisBtn){
    if($(thisBtn).parent().hasClass('active')==false){
        $(thisBtn).closest('ul').find('li').map(function(e){
            $(this).removeClass('active');
        });
        
        var dateTo = $(thisBtn).attr('dateto');
        var dateEnd = $(thisBtn).attr('dateend');
        loadChartOrder(dateTo,dateEnd);
        
        $(thisBtn).closest('li').addClass('active');
    }
}

function loadNotification(){
    var url = 'home/getNotification';
    var data = $('#form-notification').serializeObject();
    var ajax = $.post(url,data);
    ajax.success(function(html){
        $('#loadNotification').html(html);
        $("time.lazitimeago").timeago(); 
        $('ul#loadNotification').find('a').map(function(){
            $(this).attr('target','_blank'); 
        });
    });
}