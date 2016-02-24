
function drawChart(chartId,data,ref_currency) {
  var plot2 = $.jqplot(chartId, data, {
      /*title:'Micronation currency index',
      seriesDefaults:{
        shadow:true,
      },*/
       
     //stackSeries:true,
     

      axes:{
        xaxis:{
          renderer:$.jqplot.DateAxisRenderer, 
          tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
          tickOptions:{formatString:'%b %#d',
                      angle: -30,
                      fontSize:"40px"},
          //min:'May 30, 2008', 
          tickInterval:'5 day'
        },
        yaxis:{
         labelrenderer:$.jqplot.CanvasAxisLabelRenderer,
         
          label:ref_currency,
          labelOptions:{
            fontSize:"40px",
          },
          numberTicks:4
          //tickOptions:{formatString:'$%.3f',angle: -30},
        }
      },
      /*legend:{
      renderer: $.jqplot.EnhancedLegendRenderer,
            show:true,
            //placement:"outside",
            location: 'e', 
            showSwatches: true,   
            rendererOptions:{
               seriesToggle: true,
               numberRows:1
           },  

      },*/
     highlighter: {
        show: true,
        sizeAdjust: 7.5,
      },
      cursor: {
        show: false
      }
    });

   
}





function convert_date_mysql_to_javascript(string){
  var t = string.split(/[- :]/);
// Apply each element to the Date function
  return new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

}
