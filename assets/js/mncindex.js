var data;
function loadTableAndMarquee(url) {
	$.ajax({                                      
		url: url,
		dataType: 'json',
		success: function(_data)
		{
      data = _data;
			var tableString = '<table id="output" border="1"><tr><th>Flag</th><th align="left">Nation name</th><th align="left">MISO</th><th align="left">Value</th></tr>';
			var marqueeString='';
			for (var i = 0; i < data.micronations.length; i++) {
				var value = data.micronations[i].value_to_dollar * data.micronations[i].pegged_value;
        value=value.toFixed(3);
        tableString += '<tr style="cursor:pointer"onclick=\"showCountryInfo(\'' + data.micronations[i].m_iso_code + '\');\" id="' + data.micronations[i].m_iso_code + '">';
				tableString += '<td class="flag"><img src="/api/flag/' + data.micronations[i].m_iso_code + '" /></td>';
				tableString += '<td>' + data.micronations[i].nation_name + '</td>';
				tableString += '<td>' + data.micronations[i].m_iso_code + '</td>';
				tableString += '<td id="value">' + value + '</td>';
				tableString += '</tr>';
        marqueeString += data.micronations[i].m_iso_code + ' = ' + value + ' / ';
      }
			
			tableString += '</table>';
      $('#output').html(tableString);     
      $('.marquee').html(marqueeString);
      initMarquee();
      populateSelectBoxes(data, url);
      date=convert_date_mysql_to_javascript(data.micronations[0].lastUpdated);
          $('#lastUpdated').html(date.toString());
      },

      error: function(data) {
      	console.log("Json error");
      }
    });
}

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

function populateSelectBoxes(data, url){
    var from=$('#from_currency').val() || data.micronations[0].m_iso_code;
    var to=$('#to_currency').val() || data.micronations[1].m_iso_code;

    var ref_currency = url.replace(/.*ref_currency=([a-z]+)$/gi, "$1");
    $('#from_currency option').remove(); 
    $('#to_currency option').remove();
    $('#currselect option').remove(); 
    for (var c_iso_code in data.currencies){
      $('#from_currency,#to_currency,#currselect').append('<option value="' + c_iso_code + '">' + c_iso_code + '</option>');
    }
    $('#from_currency,#to_currency').append('<option></option>');
    for (var i=0;i<data.micronations.length;i++){
      $('#from_currency,#to_currency').append('<option value="' + data.micronations[i].m_iso_code + '">' + data.micronations[i].currency_name + '</option>');

    }
    $('#from_currency').val(from);
    $('#to_currency').val(to);
    $('#currselect').val(ref_currency);

    calculateCurrency();

  }

  function calculateCurrency(){
    if(! ($('#from_value').val() )){
      alert('Please provide amount...')
      return false;

    }
    var from_in_dollars=findDollarValue($('#from_currency').val());
    var to_in_dollars=findDollarValue($('#to_currency').val());
    var result=(from_in_dollars/to_in_dollars) * $('#from_value').val();
    $('#to_value').val(result.toFixed(3));
  }
  function findDollarValue(iso){
    for (var i=0;i < data.currencies.length;i++){
      if(iso==data.currencies[i].c_iso_code){
        return data.currencies[i].value_to_dollar;
      }
    }
    for(var i=0;i < data.micronations.length;i++){

      if(iso==data.micronations[i].m_iso_code){
        return data.micronations[i].value_to_dollar * data.micronations[i].pegged_value;
      }
    }

  }



function convert_date_mysql_to_javascript(string){
  var t = string.split(/[- :]/);
// Apply each element to the Date function
  return new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

}

function showCountryInfo(iso){
  var mn=_findMN(iso);

  $('.modal-title').html(mn.nation_name);
  var body='<img src="/api/flag/' + mn.m_iso_code + '">';
  body+='<div>1 ' + mn.currency_name + ' = ' + mn.pegged_value + ' ' +  mn.c_iso_code + '</div>'; 
  body+='<div id="chart">'+ '</div>';  
  var date=new Date(mn.date_established);
  body += '<div class="established" >Established ' + $.datepicker.formatDate( "dd MM yy", date ) + '</div>' ;
  body += '<div><a target="_blank" href="' + mn.website_link + '">' + mn.website_link + '</a></div>';
  $('.modal-body').html(body);

var ref_currency=mn.c_iso_code=='USD' ? 'EUR' : 'USD';
var chartData=calculateValues(mn, ref_currency);

$('.modal').modal('show');
setTimeout(function(){drawChart('chart',[chartData], ref_currency, "12px")},500);
  

  
  
}

function getHistoricValues(currency,ref_cur,pegged_value){

        var values=[];
        var curr=data.currencies[currency].currency_history;
        var ref=data.currencies[ref_cur].currency_history;
        for (var i =0;i < curr.length;i++){
          if(ref_cur=='USD'){
            values.push([curr[i][0],curr[i][1] * pegged_value]);
          }
          else{
            if (ref[i] && curr[i]) {
              values.push([curr[i][0],(ref[i][1]/curr[i][1]) * pegged_value])
            }
          }
        }
        return values;
      }

function calculateValues(mn, ref_currency){
        var data=mn.historic_currency;
        var struc=[];
        return getHistoricValues(mn.c_iso_code,ref_currency,mn.pegged_value);
}

function _findMN(iso){
        for (var i=0;i<data.micronations.length;i++){
          if(data.micronations[i].m_iso_code == iso ){
            return data.micronations[i];
          }
        }
      }