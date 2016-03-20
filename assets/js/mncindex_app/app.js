    var mncindex = angular.module('mncindex', []);

    mncindex.service('dataFetcher', ['$http', '$timeout', function ($http, $timeout) {
        var me = this;
        me.micronations= [];
        me.ref_currency = 'USD';
        me.updateData = function () {
            $http.get('/api/micronations?ref_currency=' + me.ref_currency).then(function(response){
                me.micronations = response.data.micronations;
                me.currencies = response.data.currencies;
            });
        };
        me.updateData();
        me.getMicronationData = function (iso) {
            return me.micronations.find(function (element, index) {
                if (element.m_iso_code === iso) {
                    return true;
                }
            });
        }
        me.getHistoricValues = function (currency,ref_cur,pegged_value){
            var values=[];
            var curr=me.currencies[currency].currency_history;
            var ref=me.currencies[ref_cur].currency_history;
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
   }]);
    

    mncindex.controller('currencytable', ["$scope", "dataFetcher", "$timeout", function($scope, dataFetcher, $timeout) {
        var me = this;
        $scope.dataFetcher = dataFetcher;

        $scope.showCountryInfo = function (iso){
            var mn=dataFetcher.getMicronationData(iso);
            $('.modal-title').html(mn.nation_name);
            var body='<img src="/api/flag/' + mn.m_iso_code + '">';
            body+='<div>1 ' + mn.currency_name + ' = ' + mn.pegged_value + ' ' +  mn.c_iso_code + '</div>'; 
            body+='<div id="chart">'+ '</div>';  
            var date=new Date(mn.date_established);
            body += '<div class="established" >Established ' + $.datepicker.formatDate( "dd MM yy", date ) + '</div>' ;
            body += '<div><a target="_blank" href="' + mn.website_link + '">' + mn.website_link + '</a></div>';
            $('.modal-body').html(body);

            var ref_currency=mn.c_iso_code=='USD' ? 'EUR' : 'USD';
            var chartData=dataFetcher.getHistoricValues(mn.c_iso_code,ref_currency,mn.pegged_value);

            $('.modal').modal('show');
            setTimeout(function(){drawChart('chart',[chartData], ref_currency, "12px")},500);
        };

    }]);

    var showMarquee = function (string) {
        $('.marquee').html(string) .marquee({duration: 30000});
    }

    mncindex.controller('marquee', ['$scope', 'dataFetcher', function ($scope, dataFetcher){
        $scope.dataFetcher = dataFetcher;
        $scope.$watch('dataFetcher.micronations', function (newVal){
            var string = '';
            dataFetcher.micronations.forEach(function(nation){
               string = string + " " + nation.m_iso_code + ' = ' + parseFloat(nation.value_to_ref_currency).toFixed(3) + " / ";
           });
            showMarquee(string);
        })
    }]);    

    

