'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('MainCtrl', ['$scope', '$rootScope', 'ProjectScope', 'Api', function ($scope, $rootScope, ProjectScope, Api) {
    $scope.options = {
      "options": {"chart": {"type": "areaspline"}, "plotOptions": {"series": {"stacking": ""}}},
      "series": [
      ],
      "title": {"text": "loading..."},
      "credits": {"enabled": true},
      "loading": false,
      "size": {}
    };


    $scope.reloadChart = function() {
      Api.getTimeSeries(ProjectScope.project, {name: 'coverage'}).$promise.then(function(timeseries){
        $scope.timeseries = timeseries;
        var data = [];
        $.each($scope.timeseries.values, function(i, element){
          data.push(element);
        });
        $scope.options.title.text = ProjectScope.project.name;
        $scope.options.series = [
          {
            "name": "coverage",
            "data": data,
            "connectNulls": true,
            type: "spline"
          }
        ];
        console.log($scope.options);
        $('#container').highcharts($scope.options);
      });
    };

    $rootScope.$on('projectChange', $scope.reloadChart);

    if (ProjectScope.project) {
      $scope.reloadChart();
    }
  }]);
