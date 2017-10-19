var MainCtrl = app.controller('LoginController',
['$scope', 'Restangular', '$routeParams', '$route', '$location', '$q', 'Api', 'PlayerSearch',
function ($scope, Rest, $routeParams, $route, $location, $q, Api, PlayerSearch) {
	
	$scope.new_user = {};
	$scope.user = {};
	$scope.error = '';
	
	if($location.path() == '/login'){
		$scope.show_login = true;
		$scope.show_create = false;
	}else{
		$scope.show_login = false;
		$scope.show_create = true;
	}
	
	$scope.createAccount = function(){
		Api.createAccount($scope.new_user).then(function(res){
			if(res.data.user.user_id){
				$location.path('/');
			}
		});
	}
	
	$scope.accountLogin = function(){
		$scope.error = '';
		Api.accountLogin($scope.user).then(function(res){
			
			if(res.data.user && res.data.user.user_id){
				$location.path('/');
			}else{
				$scope.error = res.data.message;
			}
			
		});
	}
	
	$scope.toggleView = function(type){
		if(type == 'create'){
			$scope.show_login = false;
			$scope.show_create = true;
		}else{
			$scope.show_login = true;
			$scope.show_create = false;
		}
	}
	
	
}]);
