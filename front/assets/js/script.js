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


    //Create new card
    $('[data-use="new-card-submit"]').on('click', function(){
      var id_user = 1;
      var title = $('[data-use="new-card"]')[0].value;
      var priority = $('[data-use="new-card"]')[1].value;
      var category = $('[data-use="new-card"]')[2].value;
      var deadline = $('[data-use="new-card"]')[3].value;
      $.post('http://192.168.33.10:8000/createCard/' + id_user + '/' + title + '/' + priority + '/' + category + '/' + deadline,function(data){
        if (data == true){
          $('[data-use="notification-new-card"]').html("Card created successfully");
        } else {
          $('[data-use="new-card-notification"]').html(data);
        }
      })
    })


});
