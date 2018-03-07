var token = localStorage.getItem('token');
                        var tokenExpiration = data[1][0][0].token_expiration;
                        var yet = data[1][1];
                        
                        var res = tokenExpiration.replace("-", "");
                        var res = res.replace("-", "");
                        var res = res.replace(" ", "");
                        var res = res.replace(":", "");
                        var res = res.replace(":", "");
                        
                        var res2 = yet.replace("/", "");
                        var res2 = res2.replace("/", "");
                        var res2 = res2.replace(" ", "");
                        var res2 = res2.replace(":", "");
                        var res2 = res2.replace(":", "");
                        
                        if (res < res2) {
                            alert("You've been inactive for too long, please reconnect");
                            $('[data-use="delete-user"]').addClass('hidden');
                            $('[data-use="signin"]').addClass('hidden');
                            $('[data-use="update-user"]').addClass('hidden');
                            $('[data-use="login"]').removeClass('hidden');
                            $('[data-use="read-user"]').addClass('hidden');
                        } else {
                            console.log("token still valid");
                        }