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
        var avatar = $('[data-signin="avatar"]')[0].value;
        
        if(password === repeatPassword) {
            
            //manage to toggle hidden class of passwordError the right way
            if($('#passwordError').hasClass('hidden')) {
                console.log('log ok');
            } else {
                $('#passwordError').addClass('hidden');
            }
            
            //ajax request 
            debugger;
            $.post('http://192.168.33.10:8000/signin/' + encodeURI(username) + '/' + encodeURI(email) + '/' + encodeURI(password), function(data) {
                debugger;
                $('[data-use="notification-signin"]').html('<span class="checked" style="padding-right:12px;font-weight:bold;">√</span>' +  data.username + "'s account has been successfully created !");
                
                //set profile in sidebar
                $('[data-use="insidebar"]').html('<img src="' + avatar + '" class="img-avatar"><h1>' + username + '</h1>');
                
                //put token in localstorage
                localStorage.setItem('token', data.token);
            })
        } else {
            $('#passwordError').removeClass('hidden');
        }
    });

    //Create new card
    var id_user = 1;
    $.post('http://192.168.33.10:8000/createCard/' + id_user,function(data){
      console.log(data);
    })
});
