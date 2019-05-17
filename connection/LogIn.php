<html>
    <head>
        <meta charset=“UTF-8”>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
        <link rel="stylesheet" href = "../assets/css/login.css">
        <title>Login</title>
    </head>
    <body>
        <div class="login">
            <div id ="Login" class="login-card" >

            <div class="login_header">
                <div class="login_header-user">
                    <i class="fas fa-user"></i>
                </div>
                <h1 class="login-lbl" id="lblLogin">Inicio sesión</h1>
            </div>

                 <form method="POST" action="VerificaLogin.php">
                     <div class="login__form">
                         <div class="form-group" mb-2>
                             <label class="text-label" for="user">Usuario*</label>
                             <input type="text" class="form-control form-control-lg" id="user" placeholder="User" name=“txtusr”>
                         </div>
                         <div class="form-group">
                             <label class="text-label" for="password">Contraseña*</label>
                             <input type="password" class="form-control form-control-lg" id="password" placeholder="Password"  name=“txtpwd”>
                         </div>
                     </div>
                    <button class="btn btn-primary btn-lg" type="submit"> Iniciar sesión </button>
                </form>
            </div>
        </div>


    </body>
</html>
