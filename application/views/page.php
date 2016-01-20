<!DOCTYPE html>
<html>
<?php $this->view('head'); ?>
<body>
    <script>
        var mncindex = angular.module('mncindex', []);

        mncindex.service('dataFetcher', function($http) {
            var me = this;
            $http.get('/api/micronations').
                success(function(data) {
                me.micronations = data.micronations;
            });
        });

        mncindex.controller('currencytable', function ($scope, dataFetcher) {
            var me = this;
            $scope.micronations = dataFetcher.micronations;
        });
    </script>
    <div ng-app="mncindex">
        <div ng-controller="currencytable as ct">
            table her
            <table>
                <tr ng-repeat="nation in micronations">
                    <td>{{nation.m_iso_code}}</td>
                </tr>
            </table>
        </div>
    </div>
    <?php //$this->view('content'); ?>
    <?php //$this->view('modal'); ?>
</body>
</html>