<div class="col-md-4 col-md-push-4 bottomRowCol" ng-controller="currencytable">Reference currency: 
    <select id="currselect" ng-change="dataFetcher.updateData()" ng-model="dataFetcher.ref_currency" ng-options="k as k for (k, v) in dataFetcher.currencies">
    </select>
    <div id="output">
        <div>
            <table border="1">
                <tr>
                    <th>Flag</th>
                    <th align="left">Nation name</th>
                    <th align="left">MISO</th>
                    <th align="left">Value</th>
                </tr>
                <tr class="nation" ng-repeat="nation in dataFetcher.micronations" ng-click="showCountryInfo(nation.m_iso_code)">
                    <td class="flag"><img src="/api/flag/{{nation.m_iso_code}}" /></td>
                    <td>{{nation.nation_name}}</td>
                    <td>{{nation.m_iso_code}}</td>
                    <td class="value">{{(nation.value_to_ref_currency * 1).toFixed(3)}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>