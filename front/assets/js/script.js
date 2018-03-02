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
        debugger;


        $.get('http://192.168.33.10:8000/login/', function(data) {
            debugger;
        });

        //personalize the interface
        $('[data-use="sidebar"] h1').html("Hello " + username + " !").toUpperCase;
    });

    //when submit sign in to create account
    $('[data-submit="signin"]').on('click', function(){
        var username = $('[data-signin="username"]')[0].value;
        var password = $('[data-signin="password"]')[0].value;
        var repeatPassword = $('[data-signin="repeat-password"]')[0].value;
        var email = $('[data-signin="email"]')[0].value;
        if(password === repeatPassword) {
            if($('#passwordError').hasClass('hidden')) {
                console.log('log ok');
            } else {
                $('#passwordError').addClass('hidden');
            }
            //do ur biz
            debugger;
            $.post('http://192.168.33.10:8000/signin/', function(data) {
                debugger;
            })
        } else {
            $('#passwordError').removeClass('hidden');
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


});
