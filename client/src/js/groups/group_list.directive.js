app.directive('groupList',
    ['Api', 'Groups', 'ModalService', function (Api,Groups, ModalService) {
        'use strict';

        return {
            restrict: 'EA',
            replace: true,
            transclude: false,
            templateUrl: 'js/groups/group_list.html',
            scope: {
                player: '=',
                mode: '&'
            }, 
            link : function(scope, elem, attrs){
            	
            		scope.groups = [];
            		
            		/**
            		 * Loads a list of the users available groups
            		 */
            		scope.getUserGroups = function(){
            		
            			console.log('loading groups');
            			Api.loadGroups().then(function(res){
            				
            				scope.groups = res.data.groups;
            				
            			});
            			
            		}
            		
            		
            		scope.setGroup = function(){
            			
            		}
            		
            		
            		/*
            		 * Add Group Modal
            		 */
                	scope.show = function() {
                		
                		var params = {
                				
                		}
                        ModalService.showModal({
                            templateUrl: 'js/groups/modals/group_create.modal.html',
                            controller: "ModalController",
                            inputs : {
                            	"params" : params
                            }
                            
                        }).then(function(modal) {
                            modal.element.modal();
                            modal.close.then(function(result) {
                                scope.message = "You said " + result;
                            });
                        });
                    };
            	
            }
            	
        }
    }]);


