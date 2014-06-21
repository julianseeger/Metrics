'use strict';

describe('Service: ApiService', function () {

  // load the controller's module
  beforeEach(module('metricsApp'));

  var scope,
    $httpBackend;

  // Initialize the controller and a mock scope
  beforeEach(inject(function (_$httpBackend_, $rootScope) {
    $httpBackend = _$httpBackend_;
    $httpBackend.expectGET('api/projects').
      respond([{name: 'project1'}, {name: 'project2'}]);

    scope = $rootScope.$new();
  }));

  it('should inject an ApiService', inject(function (Api) {
    /** @type ApiService Api */
    expect(Api).not.toEqual(null);
    expect(Api).not.toEqual(undefined);

    expect(Api.projects.length).toBe(0);

    $httpBackend.flush();
    expect(Api.projects.length).toBe(2);
    expect(Api.projects[0].name).toBe('project1');
    expect(Api.projects[1].name).toBe('project2');
  }));

  /** @type ApiService Api */
  it('should add projects', inject(function (Api) {
    $httpBackend.flush();

    $httpBackend.expectPOST('api/projects', {name: 'projectname'}.stringify).respond(201, '');
    var project = new Project();
    project.name = 'projectname';
    Api.addProject(project);

    $httpBackend.flush();
    expect(Api.projects.length).toBe(3);
  }));
});
