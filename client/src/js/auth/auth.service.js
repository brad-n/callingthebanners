app.factory('Auth', ['$rootScope', '$q', '$location', '$window', '$http', 'Api',
	function ($rootScope, $q, $location, $window, $http, Api) {
		'use strict';
		window.Api = this;
		var that = this;
		var initData = {};
		var sendEvt = function (id, obj) {
			$rootScope.$broadcast(id, obj);
		};
		
		var user = {};
		var loggedIn = false;
		var accountDetails = [];
		var userGroups = [];


		return {
			
			isLoggedIn: function () {
				
				var deferred = $q.defer();
				
				if(user.loggedIn){
					
					deferred.resolve(user);
					
				}else{
					
					Api.getAccountDetails().then(function(res){
						if(res.data.user_id){
							user.loggedIn = true;
							user.user_id = res.data.user_id;
							user.user_name = res.data.user_name;
						}else{
							user.loggedIn = false;
						}
						deferred.resolve(user);
						
					});
					
				}
				
				return deferred.promise;
			},
			
			logOut : function(){
				Api.accountLogout().then(function(res){
					//force refresh to the url
					$window.location.href = '';
				});
			},
			
			hasAuth : function(){
				return user.loggedIn;
			},
			
			getUser: function(){
				return user;
			}		
		
		};
	}
]);
