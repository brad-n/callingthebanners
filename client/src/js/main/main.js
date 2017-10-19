var MainCtrl = app.controller('MainController',
['$scope', 'Restangular', '$routeParams', '$route', '$location', '$q', 'Api',
function ($scope, Rest, $routeParams, $route, $location, $q, Api) {
	
	$scope.search_str = '';
	$scope.players = [];
	$scope.top_players = [];
	$scope.loading = false;
	
	$scope.page = 1;
	
	
}]);
