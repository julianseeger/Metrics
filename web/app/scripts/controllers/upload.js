'use strict';

/**
 * @ngdoc function
 * @name metricsApp.controller:UploadCtl
 * @description
 * # MainCtrl
 * Controller of the metricsApp
 */
angular.module('metricsApp')
  .controller('MaterialUploadCtl', ['$scope', '$rootScope', '$fileUploader', 'ProjectScope', function ($scope, $rootScope, $fileUploader, ProjectScope) {
    $scope.ProjectScope = ProjectScope;
    $scope.materialTypes = ['clover', 'phpcs'];

    $scope.form = {version: 2, materialType: 'clover'};

    $scope.$watch('form.version', function (newVersion, oldVersion) {
      $scope.uploader.url = 'api/material/' + ProjectScope.project.name + '/' + $scope.form.version + '/' + $scope.form.materialType;
    });
    $scope.$watch('form.materialType', function (newVersion, oldVersion) {
      $scope.uploader.url = 'api/material/' + ProjectScope.project.name + '/' + $scope.form.version + '/' + $scope.form.materialType;
    });

    // create a uploader with options
    var uploader = $scope.uploader = $fileUploader.create({
      scope: $scope,                          // to automatically update the html. Default: $rootScope
      url: 'api/material/' + ProjectScope.project.name + '/' + $scope.form.version + '/' + $scope.form.materialType,
      formData: [
        {key: 'value'}
      ],
      filters: [
        function (item) {                    // first user filter
          console.info($scope.form.materialType);
          return true;
        }
      ]
    });

    uploader.bind('success', function (event, xhr, item, response) {
      $rootScope.$emit('versionsChange');
    });
    uploader.bind('error', function (event, xhr, item, response) {
      alert("failed");
    });

    // FAQ #1
    var item = {
      file: {
        name: 'Previously uploaded file',
        size: 1e6
      },
      progress: 100,
      isUploaded: true,
      isSuccess: true
    };
    item.remove = function () {
      uploader.removeFromQueue(this);
    };
    uploader.queue.push(item);
    uploader.progress = 100;

//
//    $scope.onFileSelect = function($files, version) {
//      //$files: an array of files selected, each file has name, size, and type.
//      for (var i = 0; i < $files.length; i++) {
//        var file = $files[i];
//        var project = ProjectScope.project.name;
//        console.log($scope.getCurrentType());
//        $scope.upload = $upload.upload({
//          url: 'api/material/' + project + '/' + version + '/' + $scope.getCurrentType(), //upload.php script, node.js route, or servlet url
//          method: 'POST',
//          // headers: {'header-key': 'header-value'},
//          // withCredentials: true,
//          data: {},
//          file: file // or list of files: $files for html5 only
//          /* set the file formData name ('Content-Desposition'). Default is 'file' */
//          //fileFormDataName: myFile, //or a list of names for multiple files (html5).
//          /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
//          //formDataAppender: function(formData, key, val){}
//        }).progress(function(evt) {
//          console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
//        }).success(function(data, status, headers, config) {
//          // file is uploaded successfully
//          console.log(data);
//          $rootScope.$emit('versionsChange');
//        });
//        //.error(...)
//        //.then(success, error, progress);
//        //.xhr(function(xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
//      }
//      /* alternative way of uploading, send the file binary with the file's content-type.
//       Could be used to upload files to CouchDB, imgur, etc... html5 FileReader is needed.
//       It could also be used to monitor the progress of a normal http post/put request with large data*/
//      // $scope.upload = $upload.http({...})  see 88#issuecomment-31366487 for sample code.
//    };
  }]);
