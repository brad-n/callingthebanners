app.factory('Groups', ['Restangular', '$rootScope', '$q', '$location', '$http', 'Api', 'Auth',
	function (Rest, $rootScope, $q, $location, $http, Api, Auth) {
		'use strict';
		window.GS = this;
		var initData = {};
		var groups = {};
		var currentGroup = false;
		
		
		var sendEvt = function (id, obj) {
			$rootScope.$broadcast(id, obj);
		};


		return {

			loadGroups: function(){
			
			},
			addGroup : function(){
				
			},


		};
	}
]);
