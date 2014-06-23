'use strict';

/**
 * @ngdoc overview
 * @name metricsApp
 * @description
 * # metricsApp
 *
 * Main module of the application.
 */
angular
  .module('metricsApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.bootstrap',
    'angularFileUpload'
  ])
  .config(['$routeProvider', function ($routeProvider) {

    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/upload', {
        templateUrl: 'views/upload.html',
        controller: 'MaterialUploadCtl'
      })
      .otherwise({
        redirectTo: '/'
      });
  }]);
