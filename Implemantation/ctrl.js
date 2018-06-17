angular.module('myList',[]).controller('appCtrl',['$scope','$http', '$sce', 
    function($scope,$http, $sce){
        $http.get('/getuserdata.php').success(function(login_user){
             // you will get user data only when session is valid.
             $scope.login_user = login_user;
             console.log($scope.login_user);
             $scope.login = function(){
                if (!login_user) {
                    $scope.status = "You have to log in first.";//doesnt work
                    console.log('You have to log in');

                }
            };

        });
    }
]);
