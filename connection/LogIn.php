<script>
<?php
    session_start();
    unset($_SESSION['nombre']);
?>
</script>
<html>
    <head>
        <title>Login</title>
        <meta charset=“UTF-8”>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
        <link rel="stylesheet" href = "../assets/css/login.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- <style type="text/css">
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
                    
        </style> -->
    </head>
    <body>

       <div class="login" id = "Login">
           <div class="icon">
                <i class="fas fa-user fa-3x"></i>
           </div>
            <form class="form" method="POST" action="VerificaLogin.php">
                <input class="form__input" type=“text” placeholder="Usuario*" name=“txtusr” />
                <input class="form__input" type="password" placeholder="Contraseña*" name=“txtpwd” />
                <input class="button-save" value="Ingresar" type="submit" />
            </form>
       </div>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> -->
    </body>
</html>
