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

  this.reloadProjects = function() {
    this.projects = this.projectsApi.query()
  };
  this.reloadProjects();
}