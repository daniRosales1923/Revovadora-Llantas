<?php
    session_start();
    unset($_SESSION['nombre']);
?>
<html>
    <head>
        <title>Login</title>
        <meta charset=“UTF-8”>
        <meta name=“viewport” content=“width=device-width”>
        <style type="text/css">
            html {
                background: url("../assets/img/Fondo1.jpg");
                background-repeat: no-repeat;
                background-size: 100%;
            }
            #Login{
               position:absolute;
               width: 40%;
               height: 50%;
               left: 40%;
               margin-left: -100px;
               top: 20%;
               background: url("../assets/img/Fondo2.jpg");
               opacity: .8;
               text-align: center;
               border-radius:10px 10px 10px 10px;
            }
            input{

                width: 60%;
                height: 15%;
                border-radius:10px 10px 10px 10px;
                text-align: center;   
            }
            #lblLogin{
                font: oblique bold 120% cursive;
                font-size: 100%;
            }
            
            @media only screen and (max-device-width : 320px) and (max-device-width : 480px) {
               html {
                background: url("../assets/img/Fondo2.jpg");
                background-repeat: no-repeat;
                background-size: 200%;
            }
                 #Login{
                   position:absolute;
                   width: 80%;
                   height: 60%;
                   left: 5  0%;
                   margin-left: -100px;
                   top: 10%;
                   text-align: center;
                   border-radius:10px 10px 10px 10px;
                }
                 input{
                width: 100%;
                height: 20%;
                border-radius:10px 10px 10px 10px;
                text-align: center;   
            }
            }
                    
        </style>
    </head>
    <body>

       <div id = "Login">
            <form method="POST" action="VerificaLogin.php">
                <label id="lblLogin">LOGIN</label>
                <br><br><br>
                <label>Usuario</label><br>
                <input type=“text” placeholder=ejemplo123 name=“txtusr” />
                <br><label>Contraseña</label><br>
                <input type="password" placeholder=**** name=“txtpwd” />
                <br><br> 
                <input value="Ingresar" type="submit" />
            </form>
       </div>

    </body>
</html>
