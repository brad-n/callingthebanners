var FaqCtrl = app.controller('FaqController',
['$scope', 'Restangular', '$routeParams', '$route', '$location', '$q', 'Api', '$sce',
function ($scope, Rest, $routeParams, $route, $location, $q, Api, $sce) {
	
	$scope.loading = false;
	
	$scope.faqs = [
		{id:1, q:"What is Calling the Banners?", a:"Calling the Banners is a result tracking site for A Game of Thrones 2nd Edition similar to Isle of Ravens, but focused more on individual and group tracking.  The idea is that players can create and invite others to 'play groups' where they can record the individual results of deck testing backed by the statistics from Isle of Ravnes.  Where IoR feeds off of results from The Jousting Pavilion, CtB crunches data based on individual game entries inputted by the user."},
		{id:2, q:"Why would I want to use CtB?", a:"As members of groups that focus on building decks and testing for large competitive events, we were using spreadsheets.  CtB simplifies data collection and sharing by making results and statistics easier to digest.  It utilizes the same data crunching features of IoR to present statistics on game results and faction strengths/weeknesses.  If you're into that kind of thing you might like CtB."},
		{id:3, q:"Where does this data come from and how often is it updated?", a:"CtB feeds off of the data you enter into it, and updates when you enter that data.  It isn't pulling results from anywhere other than the input of the players in your testing group."},
		{id:4, q:"Can other players see my testing results?", a:"Only members of your play group can see the results you post to that group."},
		{id:5, q:"Can I join or create multiple groups?", a:"Yes.  You can create and join as many groups as your heart desires."},
		{id:6, q:"Can I share my results between multiple groups?", a:"Not currently, the data lives in whatever group it is submitted to.  It's something we can build out if there is enough interest, so if you'd like to see this feature drop us a line."},
	]

	$scope.toTrustedHTML = function (html) {
		return $sce.trustAsHtml(html);
	};
	
}]);
