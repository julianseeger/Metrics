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
  .config(['$routeProvider', '$httpProvider', function ($routeProvider, $httpProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/file', {
        templateUrl: 'views/file.html',
        controller: 'FileCtl'
      })
      .when('/upload', {
        templateUrl: 'views/upload.html',
        controller: 'MaterialUploadCtl'
      })
      .otherwise({
        redirectTo: '/'
      });

    var interceptor = ["$rootScope", "$q", function ($rootScope, $q) {
      // Die Promise enthält eine Response; wir müssen wieder eine Promise zurückliefern
      return function (promise) {
        return promise.then(
          function (response) {
            return response;
          }, // alles ok, dabei belassen wir es
          function (response) {
            if (response.status == 401) {
              $rootScope.$emit('authentication required');
            }
            return $q.reject(response);
          }
        );
      };
    }];
    $httpProvider.responseInterceptors.push(interceptor);

  }]);
