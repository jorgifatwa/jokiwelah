/*
  Highcharts JS v6.0.6 (2018-02-05)
 Wind barb series module

 (c) 2010-2017 Torstein Honsi

 License: www.highcharts.com/license
*/
(function(g){"object"===typeof module&&module.exports?module.exports=g:g(Highcharts)})(function(g){var x=function(f){var g=f.each,p=f.seriesTypes,r=f.stableSort;return{getPlotBox:function(){return f.Series.prototype.getPlotBox.call(this.options.onSeries&&this.chart.get(this.options.onSeries)||this)},translate:function(){p.column.prototype.translate.apply(this);var c=this.options,e=this.chart,d=this.points,a=d.length-1,b,f,q=c.onSeries;b=q&&e.get(q);var c=c.onKey||"y",q=b&&b.options.step,l=b&&b.points,
k=l&&l.length,m=this.xAxis,w=this.yAxis,u=0,h,v,n,t;if(b&&b.visible&&k)for(u=(b.pointXOffset||0)+(b.barW||0)/2,b=b.currentDataGrouping,v=l[k-1].x+(b?b.totalRange:0),r(d,function(a,b){return a.x-b.x}),c="plot"+c[0].toUpperCase()+c.substr(1);k--&&d[a]&&!(h=l[k],b=d[a],b.y=h.y,h.x<=b.x&&void 0!==h[c]&&(b.x<=v&&(b.plotY=h[c],h.x<b.x&&!q&&(n=l[k+1])&&void 0!==n[c]&&(t=(b.x-h.x)/(n.x-h.x),b.plotY+=t*(n[c]-h[c]),b.y+=t*(n.y-h.y))),a--,k++,0>a)););g(d,function(a,b){var c;a.plotX+=u;void 0===a.plotY&&(0<=
a.plotX&&a.plotX<=m.len?a.plotY=e.chartHeight-m.bottom-(m.opposite?m.height:0)+m.offset-w.top:a.shapeArgs={});(f=d[b-1])&&f.plotX===a.plotX&&(void 0===f.stackIndex&&(f.stackIndex=0),c=f.stackIndex+1);a.stackIndex=c})}}}(g);(function(f,g){var p=f.each,r=f.seriesType;r("windbarb","column",{lineWidth:2,onSeries:null,states:{hover:{lineWidthPlus:0}},tooltip:{pointFormat:'\x3cspan style\x3d"color:{point.color}"\x3e\u25cf\x3c/span\x3e {series.name}: \x3cb\x3e{point.value}\x3c/b\x3e ({point.beaufort})\x3cbr/\x3e'},
vectorLength:20,yOffset:-20},{pointArrayMap:["value","direction"],parallelArrays:["x","value","direction"],beaufortName:"Calm;Light air;Light breeze;Gentle breeze;Moderate breeze;Fresh breeze;Strong breeze;Near gale;Gale;Strong gale;Storm;Violent storm;Hurricane".split(";"),beaufortFloor:[0,.3,1.6,3.4,5.5,8,10.8,13.9,17.2,20.8,24.5,28.5,32.7],trackerGroups:["markerGroup"],pointAttribs:function(c,e){var d=this.options;c=c.color||this.color;var a=this.options.lineWidth;e&&(c=d.states[e].color||c,a=
(d.states[e].lineWidth||a)+(d.states[e].lineWidthPlus||0));return{stroke:c,"stroke-width":a}},markerAttribs:function(){},getPlotBox:g.getPlotBox,windArrow:function(c){var e=1.943844*c.value,d,a=this.options.vectorLength/20,b=-10;if(c.isNull)return[];if(0===c.beaufortLevel)return this.chart.renderer.symbols.circle(-10*a,-10*a,20*a,20*a);c=["M",0,7*a,"L",-1.5*a,7*a,0,10*a,1.5*a,7*a,0,7*a,0,-10*a];d=(e-e%50)/50;if(0<d)for(;d--;)c.push(-10===b?"L":"M",0,b*a,"L",5*a,b*a+2,"L",0,b*a+4),e-=50,b+=7;d=(e-
e%10)/10;if(0<d)for(;d--;)c.push(-10===b?"L":"M",0,b*a,"L",7*a,b*a),e-=10,b+=3;d=(e-e%5)/5;if(0<d)for(;d--;)c.push(-10===b?"L":"M",0,b*a,"L",4*a,b*a),e-=5,b+=3;return c},translate:function(){var c=this.beaufortFloor,e=this.beaufortName;g.translate.call(this);p(this.points,function(d){for(var a=0;a<c.length&&!(c[a]>d.value);a++);d.beaufortLevel=a-1;d.beaufort=e[a-1]})},drawPoints:function(){var c=this.chart,e=this.yAxis;p(this.points,function(d){var a=d.plotX,b=d.plotY;c.isInsidePlot(a,0,c.inverted)?
(d.graphic||(d.graphic=this.chart.renderer.path().add(this.markerGroup)),d.graphic.attr({d:this.windArrow(d),translateX:a,translateY:b+this.options.yOffset,rotation:d.direction}).attr(this.pointAttribs(d))):d.graphic&&(d.graphic=d.graphic.destroy());d.tooltipPos=c.inverted?[e.len+e.pos-c.plotLeft-b,this.xAxis.len-a]:[a,b+e.pos-c.plotTop+this.options.yOffset-this.options.vectorLength/2]},this)},animate:function(c){c?this.markerGroup.attr({opacity:.01}):(this.markerGroup.animate({opacity:1},f.animObject(this.options.animation)),
this.animate=null)}},{isValid:function(){return f.isNumber(this.value)&&0<=this.value}})})(g,x)});
