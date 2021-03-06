function Project(name) {
  this.name = name;
}

function Metric(name) {
  this.name = name;
  this.isPercentaged = false;
  this.isInternal = false;
  this.isAbsolute = true;
  this.moreIsBetter = false;
}

angular.module('metricsApp').factory('Api', ['$resource', function ($resource) {
  return new ApiService($resource)
}]);

function ApiService($resource) {
  this.url = 'api/';
  /** @type Project[] */
  this.projects = [];
  this.projectsApi = $resource(this.url + 'projects', {});
  this.versionsApi = $resource(this.url + 'versions/:project', {project: '@project'});
  this.fileMetricsApi = $resource(this.url + 'metrics/file/:project/:version', {project: '@project', version: '@version'});
  this.timeSeriesApi = $resource(this.url + 'timeseries/:project/:metric', {project: '@project', metric: '@metric'});
  this.loginApi = $resource(this.url + 'login', {}, {
    login: {method: 'POST'}
  });
  this.logoutApi = $resource(this.url + 'logout', {}, {
    logout: {method: 'POST'}
  });

  this.login = function (name, password) {
    return this.loginApi.login({name: name, password: password});
  };
  this.logout = function () {
    return this.logoutApi.logout();
  };

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

  this.getVersions = function(project) {
    return this.versionsApi.query({project: project.name});
  };

  this.getFileMetrics = function(project) {
    return this.fileMetricsApi.get({project: project.name});
  };

  this.getTimeSeries = function(project, metric) {
    return this.timeSeriesApi.get({project: project.name, metric: metric.name});
  };

  this.getFileMetricsByVersion = function(project, version) {
    return this.fileMetricsApi.get({project: project.name, version: version.label})
  };

  this.reloadProjects = function() {
    this.projects = this.getProjects();
  };
  this.reloadProjects();
}