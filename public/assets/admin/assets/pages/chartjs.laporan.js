/**
Template Name: Ubold Dashboard
Author: CoderThemes
Email: coderthemes@gmail.com
File: Chartjs
*/


!function($) {
    "use strict";

    var ChartJs = function() {};

    ChartJs.prototype.respChart = function(selector,type,data, options) {
        // get selector by context
        var ctx = selector.get(0).getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Line':
                    new Chart(ctx, {type: 'line', data: data, options: options});
                    break;
                case 'Doughnut':
                    new Chart(ctx, {type: 'doughnut', data: data, options: options});
                    break;
                case 'Pie':
                    new Chart(ctx, {type: 'pie', data: data, options: options});
                    break;
                case 'Bar':
                    new Chart(ctx, {type: 'bar', data: data, options: options});
                    break;
                case 'Radar':
                    new Chart(ctx, {type: 'radar', data: data, options: options});
                    break;
                case 'PolarArea':
                    new Chart(ctx, {data: data, type: 'polarArea', options: options});
                    break;
            }
            // Initiate new chart or Redraw

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJs.prototype.init = function() {
        //barchart
        var barChart = {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            datasets: [
                {
                    label: "Masuk",
                    backgroundColor: "rgba(95, 190, 170, 0.3)",
                    borderColor: "#5fbeaa",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(95, 190, 170, 0.6)",
                    hoverBorderColor: "#5fbeaa",
                    data: [20, 23, 22, 25, 24, 23, 20, 22, 23, 25, 23, 24]
                },
                {
                    label: "Tidak Masuk",
                    backgroundColor: "rgba(222, 37, 37, 0.3)",
                    borderColor: "#DF4D4D",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(222, 37, 37, 0.7)",
                    hoverBorderColor: "#DF4D4D",
                    data: [2, 0, 0, 0, 0, 2, 5, 3, 2, 0, 3, 1]
                }
            ]
        };
        this.respChart($("#bar"),'Bar',barChart);
    },
    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.ChartJs.init()
}(window.jQuery);

