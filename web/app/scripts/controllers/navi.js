'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:NaviCtl
 * @description
 * # MainCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('NaviCtl', ['$scope', '$location', '$modal', 'Api', function ($scope, $location, $modal, Api) {
    /** @type ApiService Api */
    $scope.projects = [];

    $scope.isActive = function(route) {
      return route === $location.path();
    };

    $scope.addProject = function (size) {

      var modalInstance = $modal.open({
        templateUrl: 'views/addProject.html',
        controller: AddProjectCtl,
        size: size
      });

      modalInstance.result.then(function () {
        $scope.reloadProjects();
      });
    };

    $scope.reloadProjects = function() {
      $scope.projects = Api.getProjects();
    };
    $scope.reloadProjects();
  }]);