$(document).ready(function(){
    $('[data-submit="go-to-signin"]').on('click', function(){
        $('[data-use="signin"]').toggleClass('hidden');
        $('[data-use="signin"]').toggleClass('flex');

        $('[data-use="login"]').toggleClass('flex');
        $('[data-use="login"]').toggleClass('hidden');
        //$.post('192.168.33.10:8000/login')
    });

    $('[data-submit="back-to-login"]').on('click', function(){
        $('[data-use="signin"]').toggleClass('hidden');
        $('[data-use="signin"]').toggleClass('flex');

        $('[data-use="login"]').toggleClass('flex');
        $('[data-use="login"]').toggleClass('hidden');
        //$.post('192.168.33.10:8000/singin')
    });
    
    //toggle down options when connected ans when clicking on the crossed wheel icon
    $('body').on('click', '[data-use="sidebar"] h1 svg', function(){
        $('[data-use="sidebar-connected"]').toggleClass('hidden');
    });

    /*
    // Login user
    */
    
    $('[data-submit="login"]').on('click', function(){
        var username = $('[data-login="username"]')[0].value;
        var password = $('[data-login="password"]')[0].value;

        
        debugger;
        $.get('http://192.168.33.10:8000/login/' + username + '/' + password, function(data) {
            debugger;
            if(data.length > 0) {
                //makes dashboard appears

                //set profile in sidebar
                $('[data-use="insidebar"]').html('<img src="' + data[0].avatar + '" class="img-avatar"><h1>' + data[0].username + '<i class="fa fa-cog"></i></h1>');
                
                $('[data-use="notification-login"]').addClass('hidden');
                
                localStorage.setItem('token', data[0].token);
            } else {
                $('[data-use="notification-login"]').html('<p class="error">username and password doesn\'t seems to match... Please try again !</p>');
            }
        });
    });
    
    /*
    //create user profile
    */
    $('[data-submit="signin"]').on('click', function(){
        var username = $('[data-signin="username"]')[0].value;
        var password = $('[data-signin="password"]')[0].value;
        var repeatPassword = $('[data-signin="repeat-password"]')[0].value;
        var email = $('[data-signin="email"]')[0].value;
        //still need to be personalized
        var avatar = "./assets/img/default.png";


        if(password === repeatPassword) {
            //test the input existance
            if(username && email) {
                //test the email format
                for(var i = 0; i < email.length; i++) {
                    if(email.charAt(i) == '@') {
                        for(var i = 0; i < email.length; i++ ) {
                            if(email.charAt(i) == ".") {
                                //everything is ok, go into the ajax request
                                $.post('http://192.168.33.10:8000/signin/' + encodeURI(username) + '/' + encodeURI(email) + '/' + encodeURI(password), function(data) {
                                    if(data.status == 200) {

                                        /*
                                        if(avatar == ""){
                                            avatar = "./assets/img/default.png";
                                        } else {
                                            avatar = avatar.substr(12);
                                        }
                                        */
                                        $('[data-use="notification-signin"]').html('<span class="checked" style="padding-right:12px;font-weight:bold;">√</span>' +  data.username + "'s account has been successfully created !");

                                        //set profile in sidebar
                                        $('[data-use="insidebar"]').html('<img src="' + avatar + '" class="img-avatar"><h1>' + username + '<i class="fa fa-cog"></i></h1>');

                                        //hide the submit
                                        $('[data-submit="signin"]').addClass('hidden');
                                        $('[data-submit="back-to-login"]').addClass('hidden');

                                        //put token in localstorage
                                        localStorage.setItem('token', data.token);
                                        
                                    } else if(data.status == 500){
                                        //if username already exist
                                        $('[data-use="notification-signin"]').html('<p>This username or email already exist, please try an other one</p>');
                                    }
                                })
                            } else {
                                //mail is missing its dot
                                $('[data-use="notification-signin"]').html('<p>Seems like a dot is missing in your e-mail adress</p>');
                            }
                        }
                    } else {
                        //mail is missing its at
                        $('[data-use="notification-signin"]').html('<p>Seems like a [at] is missing in your e-mail adress</p>');
                    }
                }
            } else {
                //an input value is missing
                $('[data-use="notification-signin"]').html('<p>Please, fill all the required input</p>');
            }

            //manage to toggle hidden class of passwordError the right way
            if($('#passwordError').hasClass('hidden')) {
                console.log('log ok');
            } else {
                $('#passwordError').addClass('hidden');
            }

        } else {
            //wrong password in confirmation
            $('#passwordError').removeClass('hidden');
        }
    });
    
    /*
    //update user profile
    */
    
    $('[data-action="updateUser"]').on('click', function(){    
        
        var token = localStorage.getItem('token');
        
        //broing data from db in input
        $.post('http://192.168.33.10:8000/admin/read_account/' + token, function(data) {
            var username = data[0].username;
            var email = data[0].email;
            
            $('[data-update="username"]')[0].value = username;
            $('[data-update="email"]')[0].value = email;
        });
        
        $('[data-use="delete-user"]').addClass('hidden');
        $('[data-use="signin"]').addClass('hidden');
        $('[data-use="update-user"]').removeClass('hidden');
        $('[data-use="login"]').addClass('hidden');
        $('[data-use="read-user"]').addClass('hidden');
        
        $('body').on('click', '[data-submit="update-user"]', function(){
                        
            if(token) {
                var newUsername = $('[data-update="username"]')[0].value;
                var newPassword = $('[data-update="password"]')[0].value;
                var newEmail = $('[data-update="email"]')[0].value;

                $.post('http://192.168.33.10:8000/admin/update/' + encodeURI(token) + '/' + encodeURI(newPassword) + '/' + encodeURI(newUsername) + '/' + encodeURI(newEmail) , function(data) {

                    if(data.status == 200) {
                        //notification to user
                        $('[data-use="notification-update-user"]').html(data.username + ', your account has been successfully updated !');

                        //refresh name in sidebar
                         $('[data-use="insidebar"] h1').html(newUsername + '<i class="fa fa-cog"></i>');
                    } else {
                        $('[data-use="notification-update-user"]').html('<span class="error">Error with your update, check your inputs or try another username</span>');
                    } 
                });
            } else {
                //no token
                $('[data-use="notification-update-user"]').html('<p class="error">Your connection has expired, please reconnect</p>');
            }
        });
        
        $('[data-submit="update-back" ]').on('click', function(){
            $('[data-use="delete-user"]').addClass('hidden');
            $('[data-use="signin"]').addClass('hidden');
            $('[data-use="update-user"]').addClass('hidden');
            $('[data-use="login"]').removeClass('hidden');
            $('[data-use="read-user"]').addClass('hidden');
        });
    });
    
    /*
    // delete user account
    */
    
    $('[data-action="deleteUser"]').on('click', function(){
        $('[data-use="delete-user"]').removeClass('hidden');
        $('[data-use="signin"]').addClass('hidden');
        $('[data-use="update-user"]').addClass('hidden');
        $('[data-use="login"]').addClass('hidden');
        $('[data-use="read-user"]').addClass('hidden');
        
        $('[data-submit="delete-user"]').on('click', function(){
            var username = $('[data-delete="username"]')[0].value;
            if(username) {
                $.post('http://192.168.33.10:8000/admin/remove_user/' + encodeURI(username), function(data) {
                    if(data.status == 200) {
                        $('[data-use="delete-user"]').html('<p>Your account has been successfully removed !</p>');
                    
                        debugger;
                        localStorage.removeItem('token');
                    } else {
                        $('[data-use="delete-user"]').append('<p class="error">An error has occured, please try again</p>');
                    }
                });
            } else {
                $('[data-use="delete-user"]').append('<p class="error">Please, enter your username first</p>');
            }
        });
        
        $('[data-submit="keep-my-account"]').on('click', function(){
            $('[data-use="delete-user"]').addClass('hidden');
            $('[data-use="signin"]').addClass('hidden');
            $('[data-use="update-user"]').addClass('hidden');
            $('[data-use="login"]').removeClass('hidden');
            $('[data-use="read-user"]').addClass('hidden');
        });
    });

    /*
    // Read user account
    */
    $('[data-action="readUser"]').on('click', function(){
        var token = localStorage.getItem('token');
        
        if(token) {
            $.post('http://192.168.33.10:8000/admin/read_account/' + token, function(data) {
                $('[data-use="delete-user"]').addClass('hidden');
                $('[data-use="signin"]').addClass('hidden');
                $('[data-use="update-user"]').addClass('hidden');
                $('[data-use="login"]').addClass('hidden');
                $('[data-use="read-user"]').removeClass('hidden');

                var htmlRender = '<h2>Your profile :</h2>';
                var htmlRender = htmlRender + '<img src="' + data[0].avatar + '" class="img-avatar">';
                var htmlRender = htmlRender + '<p>Your username : ' + data[0].username + '</p>';
                var htmlRender = htmlRender + '<p>Your email : ' + data[0].email + '</p>';
                var htmlRender = htmlRender + '<input type="submit" value="Back" data-submit="back" class="button">';

                $('[data-use="read-user"]').html(htmlRender);
            });

            $('body').on('click', '[data-submit="back"]', function(){
                $('[data-use="delete-user"]').addClass('hidden');
                $('[data-use="signin"]').addClass('hidden');
                $('[data-use="update-user"]').addClass('hidden');
                $('[data-use="login"]').removeClass('hidden');
                $('[data-use="read-user"]').addClass('hidden');
            });
        } else {
            $('[data-use="delete-user"]').addClass('hidden');
            $('[data-use="read-user"]').removeClass('hidden');
            $('[data-use="signin"]').addClass('hidden');
            $('[data-use="update-user"]').addClass('hidden');
            $('[data-use="login"]').addClass('hidden');
            
            //notification of the error
            $('[data-use="read-user"]').html('<p class="error">Your connection has expired, please reconnect</p>')
        }
        
    });

    /*
    // Create new card
    */

    // Add/Remove asterisk for mandatory fields
    $('[data-use="new-card-title"]').on('input', function(){
      if ($('[data-use="new-card-title"]')[0].value != '')
      {
        $('[data-use="new-card-title-asterisk"]').addClass('blanked');
      } else {
        $('[data-use="new-card-title-asterisk"]').removeClass('blanked');
      }
    })

    // Click on create button
    $('[data-use="new-card-submit"]').on('click', function(){

      var userID;
      //Get ID user
      var userToken = localStorage.getItem('token');
      $.ajax({
        method: "POST",
        url: 'http://192.168.33.10:8000/getIDUser/' + userToken,
        async: false}).done(function(data){
            if (data == 'error'){
              $('[data-use="new-card-notification"]').removeClass('success');
              $('[data-use="new-card-notification"]').addClass('error');
              $('[data-use="new-card-notification"]').html('An error occured');
            } else {
              userID = data;
            }
          })

      // Check title field
      var title = $('[data-use="new-card-title"]')[0].value;
      if (title == "") {
        $('[data-use="new-card-notification"]').removeClass('success');
        $('[data-use="new-card-notification"]').addClass('error');
        $('[data-use="new-card-notification"]').html("Card title is necessary");
      } else {

        // Define Priority
        // 0 : Low
        // 1 : Medium
        // 2 : High
        var priority;
        switch ($('[data-use="new-card-priority"]')[0].value) {
          case 'Low':
          priority = 0;
          break;
          case 'Medium':
          priority = 1;
          break;
          case 'High':
          priority = 2;
          break;
        }

        // Check category field
        // Assign global by default
        var category = $('[data-use="new-card-category"]')[0].value;
        if (category == ""){
          category = 'Global';
        }

        // Check deadline field
        // Assign NULL by default
        var deadline = $('[data-use="new-card-deadline"]')[0].value;
        if (deadline == "")
        {
          deadline='NULL';
        }

        // Assign the status Idle
        // 0 : Idle
        var status = 0;

        // Create card
        $.post('http://192.168.33.10:8000/createCard/' + userID + '/' + title + '/' + priority + '/' + category + '/' + deadline + '/' + status,function(data){

          if (data == 0){
            $('[data-use="new-card-notification"]').removeClass('error');
            $('[data-use="new-card-notification"]').addClass('success');
            $('[data-use="new-card-notification"]').html("Card created successfully");
          } else {
            $('[data-use="new-card-notification"]').removeClass('success');
            $('[data-use="new-card-notification"]').addClass('error');
            $('[data-use="new-card-notification"]').html(data);
          }
        })
      }
    })

    /*
    // Show card
    */

    // Change image menu when mouse over it
    $('body').on('mouseenter','[data-action="card-menu"]',function(event){
      $(event.target).attr('src','./assets/img/cardMenuGold.svg');
    })

    $('body').on('mouseleave','[data-action="card-menu"]',function(event){
      $(event.target).attr('src','./assets/img/cardMenu.svg');
    })

    // Show card menu when click on hamburger menu
    $('body').on('click','[data-action="card-menu"]',function(event){
      $(event.target).next().toggleClass('hidden');
    })

    // Get card
    var userToken = localStorage.getItem('token');
    $.post('http://192.168.33.10:8000/getCard/' + userToken,function(data){
      // Sort array relative to rank card
      data.sort(function(a,b){
        return b.rank - a.rank;
      });

      // Cards creation
      var cardRender = '';
      for (var i=0; i < data.length; i++){
        cardRender += '<div>';
          cardRender += '<div>';
            cardRender += '<h3>' + data[i].title + '</h3>';
            cardRender += '<div>';
              cardRender += '<img data-action="card-menu" src="./assets/img/cardMenu.svg" alt="card menu">';
              cardRender += '<nav data-use="card-menu" class="hidden">';
              cardRender += '<ul>';
              cardRender += '<li>Add Task</li>';
              cardRender += '<li>Edit Card</li>';
              cardRender += '<li>Share Card</li>';
              cardRender += '<li>Delete Card</li>';
              cardRender += '</ul>';
              cardRender += '</nav>';
            cardRender += '</div>';
          cardRender += '</div>';
          cardRender += '<div>';
            for (var j=0; j <  data[i].collaborators.length; j++){
              cardRender += '<img data-use="avatar" src="' + data[i].collaborators[j] + '" alt="author avatar">';
            }
          cardRender += '</div>';
          cardRender += '<div>';
          if (data[i].priority == 2) {
            cardRender += '<img src="./assets/img/warning-sign.svg" alt="high priority">';
          }
          if (data[i].status == 0) {
            cardRender += '<img src="./assets/img/smiling.svg" alt="status OK">';
          }
          else if (data[i].status == 1)
          {
            cardRender += '<img src="./assets/img/sad.svg" alt="status NOK">';
          }
          cardRender += '<img src="./assets/img/flag.svg" alt="category">';
          cardRender += '</div>';
          cardRender += '<div>';
          cardRender += '<p>Empty Task</p>';
          cardRender += '</div>';
        cardRender += '</div>';
      }
      $('[data-use="get-card"]').html(cardRender);

    })


});
