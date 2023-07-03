define([
    "jQuery",
	"bootstrap", 
    "highcharts3d",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "select2",
    "toastr",
	], function (
    $,
	bootstrap, 
    highcharts3d,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    select2,
    toastr,
	) {
    return {  
        table:null,
        init: function () { 
        	App.initFunc(); 
            App.initEvent(); 
            App.initData();
            console.log("LOADED");
            $(".loadingpage").hide();
         
            
		}, 
        initEvent : function(){   
            

        },
        initData : function(){

            //grafik pendapatan
            $.ajax({
                url : App.baseUrl+"dashboard/grafikPendapatan",
                type : "GET",
                success : function(data) {
                    var data = JSON.parse(data);
                    App.grafikPendapatan(data.grafik);
                },
                error : function(data) {
                    // do something
                }
            });

        },
        
        grafikPendapatan : function(data) {
            Highcharts.chart('container-grafik-pendapatan', {
                title: {
                    text: 'Pendapatan Kotor Perbulan'
                },
                subtitle: {
                    text: 'jokiwelah.com'
                },

                xAxis: {
                    categories: data.category
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true
                    }
                },
            
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br />',
                    pointFormat: 'Pendapatan = {point.y}'
                },
            
                series: [{
                    name: data.tahun,
                    data: data.pendapatan,
                    pointStart: 1
                }]
            });
        },
	}
});