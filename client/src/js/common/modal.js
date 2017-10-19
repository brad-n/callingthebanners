var MainCtrl = app.controller('ModalController',
['$scope', 'Restangular', '$routeParams', '$route', '$location', '$q', 'Api' ,'close',
function ($scope, Rest, $routeParams, $route, $location, $q, Api, close) {
	
	$scope.search_str = '';
	$scope.players = [];
	$scope.top_players = [];
	$scope.loading = false;
	
	$scope.page = 1;
	
	
	  $scope.closeModal = function() {
		  	console.log('hiding!');
		  	alert('ok!');
		    //  Manually hide the modal using bootstrap.
		    $element.modal('hide');

		    //  Now close as normal, but give 500ms for bootstrap to animate
		    close(null, 500);
		  };
	
	
}]);
