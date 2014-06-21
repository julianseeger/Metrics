function Project(name) {
  this.name = name;
}

angular.module('metricsApp').factory('Api', ['$resource', function ($resource) {
  return new ApiService($resource)
}]);

function ApiService($resource) {
  this.url = 'api/';
  /** @type Project[] */
  this.projects = [];
  this.projectsApi = $resource(this.url + 'projects', {});

  /** @type Project project */
  this.addProject = function(project) {
    var remoteProject = new this.projectsApi({name: project.name});
    remoteProject.$save();
    this.projects.push(remoteProject);
    return remoteProject;
  };

  this.getProjects = function() {
    return this.projectsApi.query();
  };

  this.reloadProjects = function() {
    this.projects = this.getProjects();
  };
  this.reloadProjects();
}