'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:NaviCtl
 * @description
 * # MainCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('NaviCtl', ['$scope', '$rootScope', '$location', '$modal', 'Api', 'ProjectScope', function ($scope, $rootScope, $location, $modal, Api, ProjectScope) {
    /** @type ApiService Api */
    $scope.projects = [];
    $scope.ProjectScope = ProjectScope;
    $scope.versions = null;

    $scope.isActive = function(route) {
      return route === $location.path();
    };

    $scope.addProject = function (size) {

      var modalInstance = $modal.open({
        templateUrl: 'views/addProject.html',
        controller: ['$scope', '$modalInstance', 'Api', AddProjectCtl],
        size: size
      });

      modalInstance.result.then(function () {
        $rootScope.$emit('projectsChange');
      });
    };

    $scope.selectProject = function (project) {
      ProjectScope.project = project;
      $rootScope.$emit('projectChange');
      $scope.reloadVersions();
    };

    $scope.reloadVersions = function() {
      $scope.versions = Api.getVersions(ProjectScope.project);
    };

    $scope.reloadProjects = function() {
      $scope.projects = Api.getProjects();
    };
    $scope.reloadProjects();
    $rootScope.$on('versionsChange', $scope.reloadVersions);
    $rootScope.$on('projectsChange', $scope.reloadProjects);
  }]);