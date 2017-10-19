var app = angular.module('callingTheBanners', ['ngRoute', 'ngAnimate', 'restangular', 'templates-main', 'ui.bootstrap','angularModalService']);

app.run(['$rootScope', 'Auth', function(rs, Auth){
	/* injecting globals */
	rs.baseURL = cfg.baseHref;
	rs.Auth = Auth;
}])

app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    'use strict';
    $locationProvider.html5Mode(true);
    $routeProvider

	    .when("/", {
	    		controller: 'MainController',
	        templateUrl: "js/main/main.html",
	        resolve: {
	            app: function(Auth, $q, $rootScope, $location) {
	            		var deferred = $q.defer();
	            		Auth.isLoggedIn().then(function(res){if(!res.loggedIn){ $location.path('/login'); }else{ deferred.resolve(true);}});
	            		return deferred.promise;
	            }
	        }
	        
	    })
	    .when("/faq", {
	    	templateUrl: "js/faq/faq.html",
	        controller: 'FaqController',
	    })
	    .when("/contact", {
	    	templateUrl: "js/contact/contact.html",
	    	controller: 'ContactController',
	    })
	    .when("/whats-new", {
	    	templateUrl: "js/whatsnew/whatsnew.html",
	    	controller: 'WhatsNewController',
	    })
	    .when("/login",{
	    		templateUrl: "js/login/login.html",
	    		controller: 'LoginController',
	    		resolve: {
		            app: function(Auth, $q, $rootScope, $location) {
		            		var deferred = $q.defer();
		            		Auth.isLoggedIn().then(function(res){if(res.loggedIn){ $location.path('/'); }else{ deferred.resolve(true);}});
		            		return deferred.promise;
		            }
		        }
	    })
	    .when("/signup",{
	    		templateUrl: "js/login/login.html",
	    		controller: 'LoginController',
	    		resolve: {
		            app: function(Auth, $q, $rootScope, $location) {
		            		var deferred = $q.defer();
		            		Auth.isLoggedIn().then(function(res){if(res.loggedIn){ $location.path('/'); }else{ deferred.resolve(true);}});
		            		return deferred.promise;
		            }
		        }
	    })
        .otherwise({redirectTo: "/"});
}])

.run(['Restangular', '$rootScope',
	function (RestProvider, rs) {
		'use strict';
		RestProvider.setBaseUrl(cfg.apiBaseUrl());

		/*
		 * This interceptor checks the response object to see if the server response is telling us the user is not authed.
		 * If auth exists and auth is set to false
		 */
		RestProvider.addResponseInterceptor(function(data, operation, what, url, response, deferred) {
			if(typeof data.auth !== 'undefined' && data.auth == 0){
				console.log('Failed auth!  Redirecting.');
				$location.path('/login');
			}
			
			return data;
			
		});
		
}])
