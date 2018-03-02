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
                                debugger;
                                $.post('http://192.168.33.10:8000/signin/' + encodeURI(username) + '/' + encodeURI(email) + '/' + encodeURI(password), function(data) {
                                    if(data.status == 200) {
                                        
                                        /*
                                        if(avatar == ""){
                                            avatar = "./assets/img/default.png";
                                        } else {
                                            avatar = avatar.substr(12);
                                        }
                                        */
                                        
                                        
                                        debugger;
                                        $('[data-use="notification-signin"]').html('<span class="checked" style="padding-right:12px;font-weight:bold;">√</span>' +  data.username + "'s account has been successfully created !");

                                        //set profile in sidebar
                                        $('[data-use="insidebar"]').html('<img src="' + avatar + '" class="img-avatar"><h1>' + username + '</h1>');
                                        
                                        //hide the submit
                                        $('[data-submit="signin"]').addClass('hidden');
                                        $('[data-submit="back-to-login"]').addClass('hidden');
                                        
                                        //replace by next button
                                        $('[data-use="signin"] div').append('<input type="submit" data-action="lets-go" value="Let\'s go ! ►" class="button">')
 
                                        //put token in localstorage
                                        localStorage.setItem('token', data.token);
                                    }else if(data.status == 500){
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

    //Create new card
    var id_user = 1;
    $.post('http://192.168.33.10:8000/createCard/' + id_user,function(data){
      console.log(data);
    })
});
