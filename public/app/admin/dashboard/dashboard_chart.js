var runChart4 = function() {
    function randValue() {
        return (Math.floor(Math.random() * (100 + 1000 - 100))) + 200;
    };

    function createSeries() {
        //var y = date.getFullYear(), m = date.getMonth();
        /**
        for(var d = new Date(new Date().setMonth(new Date().getMonth() - 1)); d <= new Date(); d.setDate(d.getDate() + 1)) {
            series1.push([new Date(d), randValue() + Math.floor(Math.random() * 1000)]);
        }
        ***/

        series1 = [];




    }

    if($("#chart4 > svg").length) {
        var date = new Date();
        var series1 = [];
        //var series2 = [];
        var firstDay, lastDay, fifthDay, tenthDay, fifteenthDay, twentiethDay, twentyfifthDay;
        var dt;
        //createSeries();

        $.get( subdir+'/ajax/admin/dashboard/scd' )
            .done(function( data ) {
                max = 0;
                //for( i = 0 ; i < data.dates.length; i++  ){
                //for(var d = new Date(new Date().getMonth(new Date().getMonth() - 1)); d <= new Date(); d.setDate(d.getDate() + 1)) {
                for(var d = new Date( new Date().setDate( new Date().getDate() - 14 ) ); d <= new Date(); d.setDate( d.getDate() + 1)) {

                    val = 0;
                    for( i = 0 ; i < data.dates.length ; i++ ){

                        dd = data.dates[i];
                        if( dd.day == d.getDate() ){
                            val = dd.cnt;
                            if( val > max ){
                                max = val;
                            }
                        }
                    }
                    series1.push([new Date( d ), val ]);
                }

                dt = [{
                    "key": "Student Registrations",
                    "values": series1
                }];
                nv.addGraph( add( dt , max ) );
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });


        function add( data , max )
        {
            var m_arr=[ 10 , 50 , 100 ,1000 ,10000 ];

            for( i=0  ; i < m_arr.length ; i++ ){
                ml = m_arr[i];
                if( max < ml ){
                    max = ml;
                    break;
                }
                max = ml;
            }


            var chart = nv.models.lineChart().margin({
                top: 30,
                right: 0,
                bottom: 20,
                left: 35
            }).x(function(d) {
                return d[0];
            }).y(function(d) {
                return d[1];
            }).forceY([ 0, max ]).useInteractiveGuideline( true ).color( ['#D9534F'] ).clipEdge(true);

            var options = {
                showControls: false,
                showLegend: true
            };
            chart.options(options);
            chart.xAxis.tickFormat(function(d) {
                return d3.time.format('%x')(new Date(d));
            }).showMaxMin(false);

            chart.yAxis.tickFormat(d3.format(',f'));
            d3.select('#chart4 svg').datum(data).call(chart);

            nv.utils.windowResize(chart.update);

            return chart;
        }

    }
};

runChart4();