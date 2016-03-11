/**
 * Exercise Root Application
 */
angular
    // Declare the new Application
    .module('ExerciseApp', [
        // Libraries
        'ngSanitize',
        'ngRoute',
        'angular-loading-bar',
        'angular-table',
        'ui.bootstrap',
        'ui.translation',
        'ui.tinymce',
        'ngBootbox',

        // Exercise modules
        'Common',
        'Step',
        'Exercise',
        'Question',
        'Paper',
        'Correction'
    ])

    // Configure application
    .config([
        '$routeProvider',
        'cfpLoadingBarProvider',
        function ExerciseAppConfig($routeProvider, cfpLoadingBarProvider) {
            // please wait spinner config
            cfpLoadingBarProvider.latencyThreshold = 200;
            cfpLoadingBarProvider.includeBar       = false;
            cfpLoadingBarProvider.spinnerTemplate  = '<div class="loading">Loading&#8230;</div>';

            // Define routes
            $routeProvider
                // Overview
                .when('/', {
                    templateUrl : AngularApp.webDir + 'bundles/ujmexo/js/angular/Exercise/Partials/overview.html',
                    controller  : 'ExerciseOverviewCtrl',
                    controllerAs: 'exerciseOverviewCtrl',
                    resolve: {
                        // Get the Exercise to Display
                        exercise: [
                            'ExerciseService',
                            function exerciseResolve(ExerciseService) {
                                return ExerciseService.getExercise();
                            }
                        ],
                        editEnabled: [
                            'ExerciseService',
                            function editEnabledResolve(ExerciseService) {
                                return ExerciseService.isEditEnabled();
                            }
                        ]
                    },

                    // Active tab
                    hideMenu: false,
                    tab: 'overview'
                })

                // Edit Exercise parameters
                .when('/edit', {
                    templateUrl : AngularApp.webDir + 'bundles/ujmexo/js/angular/Exercise/Partials/parameters.html',
                    controller  : 'ExerciseParametersCtrl',
                    controllerAs: 'exerciseParametersCtrl',
                    resolve: {
                        // Get the Exercise to Edit
                        exercise: [
                            'ExerciseService',
                            function exerciseResolve(ExerciseService) {
                                return ExerciseService.getExercise();
                            }
                        ]
                    },

                    // Active tab
                    hideMenu: false,
                    tab: 'parameters'
                })

                // Display the list of Questions
                .when('/steps', {
                    templateUrl : AngularApp.webDir + 'bundles/ujmexo/js/angular/Step/Partials/list.html',
                    controller  : 'StepListCtrl',
                    controllerAs: 'stepListCtrl',
                    resolve: {
                        // Get the list of Steps from the Exercise
                        steps: [
                            'ExerciseService',
                            function stepsResolve(ExerciseService) {
                                return ExerciseService.getSteps();
                            }
                        ]
                    },

                    // Active tab
                    tab: 'steps'
                })

                // Display Papers list
                .when('/papers', {
                    templateUrl: AngularApp.webDir + 'bundles/ujmexo/js/angular/Paper/Partials/list.html',
                    controller: 'PaperListCtrl',
                    controllerAs: 'paperListCtrl',
                    resolve: {
                        papersPromise: [
                            'PaperService',
                            function papersResolve(PaperService) {
                                return PaperService.getAll();
                            }
                        ],
                        exercise: [
                            'ExerciseService',
                            function exerciseResolve(ExerciseService) {
                                return ExerciseService.getExercise();
                            }
                        ]
                    },

                    // Active tab
                    hideMenu: false,
                    tab: 'papers'
                })

                // Display a Paper
                .when('/papers/:id', {
                    templateUrl: AngularApp.webDir + 'bundles/ujmexo/js/angular/Paper/Partials/show.html',
                    controller: 'PaperShowCtrl',
                    controllerAs: 'paperShowCtrl',
                    resolve: {
                        paperPromise: [
                            '$route',
                            'PaperService',
                            function paperResolve($route, PaperService) {
                                var promise = null;
                                if ($route.current.params && $route.current.params.id) {
                                    promise = PaperService.get($route.current.params.id);
                                }

                                return promise;
                            }
                        ],
                        exercise: [
                            'ExerciseService',
                            function exerciseResolve(ExerciseService) {
                                return ExerciseService.getExercise();
                            }
                        ]
                    },

                    // Active tab
                    hideMenu: false,
                    tab: 'papers'
                })

                // Respond to Exercise
                .when('/play', {
                    templateUrl : AngularApp.webDir + 'bundles/ujmexo/js/angular/Exercise/Partials/player.html',
                    controller  : 'ExercisePlayerCtrl',
                    controllerAs: 'exercisePlayerCtrl',
                    resolve: {
                        exercise: [
                            'ExerciseService',
                            function exerciseResolve(ExerciseService) {
                                return ExerciseService.getExercise();
                            }
                        ],
                        paper: [
                            'ExerciseService',
                            function paperResolve(ExerciseService) {
                                // Start a new Attempt and retrieve the Paper if maxAttempt is not reach
                                return ExerciseService.start();
                            }
                        ]
                    },

                    // Hide management menu in player
                    hideMenu: true
                })

                // Otherwise redirect User on Overview
                .otherwise({
                    redirectTo: '/'
                });
        }
    ]);