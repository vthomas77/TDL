//requete de login        
        $.get('192.168.33.10:8000/login/{username}/{password}', {username : username, password : password} ,function(data) {
            console.log(data);
            debugger;
        }).done(
            console.log(username + " " + password + " data : " + data)
        );