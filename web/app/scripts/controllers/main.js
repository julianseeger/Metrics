'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('MainCtrl', ['$scope', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  }]);
