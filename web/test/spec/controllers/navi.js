'use strict';

describe('Controller: NaviCtl', function () {

  // load the controller's module
  beforeEach(module('metricsApp'));

  var NaviCtl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope, Api, _$httpBackend_) {
    scope = $rootScope.$new();
    _$httpBackend_.expectGET('api/projects').respond([{name: 'project1'}]);
    _$httpBackend_.expectGET('api/projects').respond([{name: 'project1'}]);
    NaviCtl = $controller('NaviCtl', {
      $scope: scope,
      Api: Api
    });
    _$httpBackend_.flush();
  }));

  it('should attach the list of projects', function () {
    expect(scope.projects.length).toBe(1);
  });
});
