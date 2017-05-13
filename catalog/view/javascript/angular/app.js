var app = angular.module('Biflyerbank_app', [])
.run(function($rootScope) {

      	 firebase.initializeApp({
                apiKey: "AIzaSyAy953zcIy51OrZSoRlphEC3ukbzqIK0PM",
			    authDomain: "flyerbank-31a21.firebaseapp.com",
			    databaseURL: "https://flyerbank-31a21.firebaseio.com",
				    storageBucket: "flyerbank-31a21.appspot.com",
			    
            });

    });
