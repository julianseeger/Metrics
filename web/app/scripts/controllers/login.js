'use strict';

var LoginCtl = ['$scope', '$rootScope', '$modalInstance', 'ProjectScope', 'Api', function ($scope, $rootScope, $modalInstance, ProjectScope, Api) {
  $scope.user = {
    name: '',
    password: ''
  };

  $scope.login = function () {
    Api.login($scope.user.name, $scope.user.password).$promise.then(function () {
      $rootScope.$emit('login');
      $modalInstance.close();
      $scope.loginOpen = false;
    });
  };

  if ($scope.loginOpen) {
    $modalInstance.close();
  }
  console.log('init ' + this);
  $scope.loginOpen = false;
}];

/**
 * @ngdoc function
 * @name metricsApp.controller:LoginCtl
 * @description
 * # LoginCtl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('LoginCtl', LoginCtl);
