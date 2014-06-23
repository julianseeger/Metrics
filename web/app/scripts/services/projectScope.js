angular.module('metricsApp').factory('ProjectScope', function () {
  return new ProjectScope()
});

function ProjectScope() {
  this.project = null;
}