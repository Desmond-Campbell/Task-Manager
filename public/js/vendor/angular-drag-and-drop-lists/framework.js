app
.config(function($routeProvider) {
    $routeProvider
        .when('/stages', {
            templateUrl: '/js/partials/workflow-stages.html',
            controller: 'WorkflowStagesController'
        })
        .otherwise({
            templateUrl: '/js/partials/workflow-list.html',
            controller: 'WorkflowsController'
        });
})
.directive('navigation', function($rootScope, $location) {
    return {
        template: '<li ng-repeat="option in options" ng-class="{active: isActive(option)}">' +
                  '    <a ng-href="{{option.href}}">{{option.label}}</a>' +
                  '</li>',
        link: function (scope, element, attr) {
            scope.options = [];

            scope.isActive = function(option) {
                return option.href.indexOf(scope.location) === 1;
            };

            $rootScope.$on("$locationChangeSuccess", function(event, next, current) {
                scope.location = $location.path();
            });
        }
    };
});
