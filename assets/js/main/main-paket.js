require(["../common" ], function (common) {  
    require(["main-function","../app/app-paket"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});