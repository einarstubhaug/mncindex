<div class="col-md-4 col-md-pull-4 bottomRowCol" >
  <div ng-controller="currencycalculator">
  <h4>Currency Calculator</h4>
  <table id="currencyCalculator" style="margin-bottom:10px">
    <tr>
      <td><input id="from_value" value="10" size="6"></td>
      <td><select id="from_currency" ng-model="selectedFromValue" >
        <option ng-repeat="(iso, currency) in dataFetcher.currencies">{{currency.c_iso_code}}</option>
        <option ng-repeat="nation in dataFetcher.micronations">{{nation.m_iso_code}}</option></select></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size:120%;padding-left:10px">=</td>
    </tr>
    <tr>
      <td colspan=1>
        <input disabled id="to_value" size="6">
      </td>
      <td colspan=1>
        <select id="to_currency" ng-model="selectedToValue">
           <option ng-repeat="(iso, currency) in dataFetcher.currencies" value="{{iso}}">{{currency.c_iso_code}}</option>
           <option ng-repeat="nation in dataFetcher.micronations" value="{{nation.m_iso_code}}">{{nation.m_iso_code}}</option>
         </select></td>
    </tr>
      </td>
    </tr>
  </table>
  <button class="btn"  ng-click="calculateCurrency()" >Calculate</button>
</div>
  <hr />
  <h4>News</h4>
  <b>03.01.2014</b>
  <br />
  The micronation currency index opens today, and it will be celebrated at Sound of mu (<a href="http://soundofmu.no">soundofmu.no</a>) from today of till end of January<br>   
  <a target="_blank"href="/assets/img/physical_apperence_at_sound_of_mu.jpg">
  <img src="/assets/img/physical_apperence_at_sound_of_mu.jpg" style="width:90%"/></a>
  <br /><br />
  <b>03.01.2014</b>
  <br />
  Fill in form for micronations who wants to register is <a href="form.php">now available</a>
</div>