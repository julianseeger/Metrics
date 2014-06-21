'use strict';

var AddProjectCtl = function ($scope, $modalInstance, Api) {
  /** @type ApiService Api */
  $scope.project = new Project();
  $scope.project.name = 'projectname';

  $scope.ok = function () {
    Api.addProject($scope.project);
    $modalInstance.close($scope.project);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};

/**
 * @ngdoc function
 * @name metricsApp.controller:AddProjectCtl
 * @description
 * # MainCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp').controller('AddProjectCtl', ['$scope', '$modalInstance', 'Api', AddProjectCtl]);
