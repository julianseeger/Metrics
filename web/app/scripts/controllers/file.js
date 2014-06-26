'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:FileCtl
 * @description
 * # FileCtl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('FileCtl', ['$scope', '$rootScope', 'Api', 'ProjectScope', function ($scope, $rootScope, Api, ProjectScope) {

    $scope.reloadFiles = function () {
      Api.getVersions(ProjectScope.project).$promise.then(function(versions){
        versions.sort(function(versionA, versionB) {
          return versionA.label > versionB.label ? 1 : -1;
        });
        versions.pop();
        var lastVersion = versions.pop();
        $scope.lastVersion = Api.getFileMetricsByVersion(ProjectScope.project, lastVersion);
      });
      $scope.version = Api.getFileMetrics(ProjectScope.project);
      $scope.version.$promise.then(function (version) {
        $scope.dir = $scope.version.root;
        $scope.parents = [];
      });
    };

    if (ProjectScope.project) {
      $scope.reloadFiles();
    }

    $scope.selectDir = function(file) {
      if (!file.isDir) {
        return;
      }
      $scope.parents.push($scope.dir);
      $scope.dir = file;
      if (file.isDir && file.files.length == 1) {
        var nextDir = file.files.pop();
        file.files.push(nextDir);
        $scope.selectDir(nextDir);
      }
    };

    $scope.selectParentDir = function() {
      $scope.dir = $scope.parents.pop();
      if (!$scope.dir) {
        $scope.dir = $scope.version.root;
      }
    };

    $scope.getMetricForLastVersion = function(file, metric) {
      if ($scope.lastVersion.metrics === undefined) {
        return 0;
      }
      return $scope.lastVersion.metrics[file.path][metric];
    };

    $scope.getMetric = function(file, metric) {
      return $scope.version.metrics[file.path][metric];
    };

    $scope.getMetricDiff = function(file, metric) {
      return $scope.getMetric(file, metric) - $scope.getMetricForLastVersion(file, metric);
    };

    $rootScope.$on('projectChange', $scope.reloadFiles);
  }]);
