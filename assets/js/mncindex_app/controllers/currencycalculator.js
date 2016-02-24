mncindex.controller('currencycalculator', function ($scope, dataFetcher) {
        $scope.dataFetcher = dataFetcher;
        $scope.selectedFromValue = 'EUR';
        $scope.selectedToValue = 'USD';
        $scope.calculateCurrency = function (){
            if(! ($('#from_value').val() )){
                alert('Please provide amount...')
                return false;
            }
            var from_in_dollars=findDollarValue($scope.selectedFromValue);
            var to_in_dollars=findDollarValue($scope.selectedToValue);
            var result=(from_in_dollars/to_in_dollars) * $('#from_value').val();
            $('#to_value').val(result.toFixed(3));
        }
        function findDollarValue(iso){
            console.log('finding for ' + iso);
            if (dataFetcher.currencies[iso]) {
                return dataFetcher.currencies[iso].value_to_dollar;
            }
            
            for(var i=0;i < dataFetcher.micronations.length;i++){
                if(iso==dataFetcher.micronations[i].m_iso_code){
                 return dataFetcher.micronations[i].value_to_dollar * dataFetcher.micronations[i].pegged_value;
             }
         }
     }
});