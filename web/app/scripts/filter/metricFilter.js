angular.module('metricsApp')
  .filter('metricvalue', ['numberFilter', function (numberFilter) {
    /** @type Metric metric **/
    return function (input, metric) {
      if (metric.isPercentaged) {
        return numberFilter(input * 100, 1) + ' %';
      }

      return numberFilter(input, 0);
    };
  }])
  .filter('metriclabel', function () {
    return function (diff, metric) {
      if (diff == 0) {
        return 'label-default';
      }

      var more = diff > 0;
      return (more && metric.moreIsBetter || !more && !metric.moreIsBetter) ? 'label-success' : 'label-danger';
    };
  });