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

    //when submit the login
    $('[data-submit="login"]').on('click', function(){
        var username = $('[data-login="username"]')[0].value;
        var password = $('[data-login="password"]')[0].value;

        $.get('http://192.168.33.10:8000/login/', function(data) {
            debugger;
        });

        //personalize the interface
        $('[data-use="sidebar"] h1').html("Hello " + username + " !").toUpperCase;
    });

    //when submit signin
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
                                        $('[data-use="insidebar"]').html('<img src="' + avatar + '" class="img-avatar"><h1>' + username + '</h1>');

                                        //hide the submit
                                        $('[data-submit="signin"]').addClass('hidden');
                                        $('[data-submit="back-to-login"]').addClass('hidden');

                                        //replace by next button
                                        $('[data-use="signin"] div').append('<input type="submit" data-action="lets-go" value="Let\'s go ! ►" class="button big">')

                                        //makes admin tools appear
                                        $('[data-use="sidebar-connected"]').removeClass('hidden');

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

    //update user profile
    $('[data-action="updateUser"]').on('click', function(){
        $('[data-use="signin"]').addClass('hidden');
        $('[data-use="update-user"]').removeClass('hidden');

        $('body').on('click', '[data-submit="update-user"]', function(){

            var username = $('[data-auth="username"]')[0].value;
            var password = $('[data-auth="password"]')[0].value;

            var newUsername = $('[data-update="username"]')[0].value;
            var newPassword = $('[data-update="password"]')[0].value;
            var newEmail = $('[data-update="email"]')[0].value;

            $.post('http://192.168.33.10:8000/admin/update/' + encodeURI(username) + '/' + encodeURI(password) + '/' + encodeURI(newPassword) + '/' + encodeURI(newUsername) + '/' + encodeURI(newEmail) , function(data) {
                debugger;

                //notification to user
                $('[data-use="notification-update-user"]').html(data.username + ', your account has been successfully updated !');
            });
        });
    });

    //Categories
    $('[data-action="categories-editor"]').on('click', function(){
        $('[data-use="categories-editor"]').toggleClass('hidden');
        $('body').on('click', '[data-action="create-category"]', function(){
            $('[data-use="creating-category"]').toggleClass('hidden');
            $('[data-action="done-category"]').on('click', function(){
              var categoryname = $('[data-signin="created-category"]')[0].value;
              var categorycolor = $('[data-signin="color-category"]')[0].value;
              $.post('http://192.168.33.10:8000/createCategory/' + categoryname + '/' + categorycolor) , function(data) {
                debugger;
                //notification to user
                $('[data-use="notification-create-category"]').html('Your new category has been successfully created !');
              }
            });
        });
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


});
