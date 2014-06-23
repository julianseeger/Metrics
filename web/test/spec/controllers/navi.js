'use strict';

describe('Controller: NaviCtl', function () {

  // load the controller's module
  beforeEach(module('metricsApp'));

  var NaviCtl,
    scope,
    $httpBackend;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope, Api, _$httpBackend_, ProjectScope) {
    scope = $rootScope.$new();
    $httpBackend = _$httpBackend_;
    _$httpBackend_.expectGET('api/projects').respond([{name: 'project1'}]);
    _$httpBackend_.expectGET('api/projects').respond([{name: 'project1'}]);
    NaviCtl = $controller('NaviCtl', {
      $scope: scope,
      Api: Api,
      ProjectScope: ProjectScope
    });
    _$httpBackend_.flush();
  }));

  it('should attach the list of projects', function () {
    expect(scope.projects.length).toBe(1);
  });

  it('should be able to change the global project', function() {
    expect(scope.ProjectScope.project).toBe(null);
    scope.selectProject({name: 'test'});
    expect(scope.ProjectScope.project).not.toBe(null);
    expect(scope.ProjectScope.project.name).toBe('test');
  });

  it('should load the versions when a project is selected', function() {
    expect(scope.versions).toBe(null);
    $httpBackend.expectGET('api/versions/project1').respond(200, '[{"label":"0.1"}]');
    scope.selectProject({name: 'project1'});
    $httpBackend.flush();
    expect(scope.versions.length).toBe(1);
    expect(scope.versions[0].label).toBe('0.1');
  });
});
