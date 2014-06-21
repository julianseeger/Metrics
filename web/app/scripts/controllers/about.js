'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('AboutCtrl', ['$scope', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  }]);
