<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SITER_PROYECTO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;1,500&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            height: 100vh;
            width: 100%;
            background: #000;
        }
        .background {
            background: url("vendor/adminlte/dist/img/backgroun3.jpg") no-repeat;
            background-position: center;
            background-size: cover;
            height: 100vh;
            width: 100%;
            filter: blur(3px);
        }
        .container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 75%;
            height: 550px;
            margin-top: 20px;
            background: url("vendor/adminlte/dist/img/backgroun3.jpg") no-repeat;
            background-position: center;
            background-size: cover;
            border-radius: 20px;
            overflow: hidden;
        }
        .item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 115%;
            color: #fff;
            background: transparent;
            padding: 100px;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }
        .text-item h2 {
            font-size: 40px;
            line-height: 1;
            color: white;
        }
        .login-section {
            position: absolute;
            top: 0;
            right: 0;
            width: calc(100% - 58%);
            height: 100%;
            color: #fff;
        }
        .form-box {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }
        .form-box h2 {
            text-align: center;
            font-size: 25px;
        }
        .input-box {
            width: 340px;
            height: 50px;
            border-bottom: 2px solid #fff;
            margin: 20px 0;
            position: relative;
        }
        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            padding-right: 28px;
        }
        .input-box label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: .5s ease;
        }
        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
        }
        .input-box .icon {
            position: absolute;
            top: 13px;
            right: 0;
            font-size: 19px;
        }
        .input-box input:focus,
        .input-box input:valid {
            border-bottom-color: #00CBFF;
        }
        .x-input-error {
            color: red;
            font-size: 18px; /* Tamaño del texto del error */
            margin-bottom: 5px; /* Espacio debajo del mensaje de error */
            position: absolute;
            top: -40px; /* Ajusta la posición del mensaje de error arriba del campo */
            left: 0;
        }
        .remember-password {
            font-size: 14px;
            font-weight: 500;
            margin: -15px 0 15px;
            display: flex;
            justify-content: space-between;
        }
        .remember-password label input {
            accent-color: #000000;
            margin-right: 3px;
        }
        .btn {
            background: #00CBFF;
            width: 84%;
            height: 45px;
            outline: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            box-shadow: rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <div class="item">
            <img src="vendor/adminlte/dist/img/LOGO.png" width="400px" height="400px" style="border-radius: 50%; padding-left: 70px;">
            <div class="text-item">
                <h2>"Sistema para la Emisión de Recibos"</h2>
            </div>
        </div>
        <div class="login-section">
            <div class="form-box login">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-box">
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <label>Usuario</label>
                        <i class="icon"></i>
                        <x-input-error :messages="$errors->get('email')" class="x-input-error" />
                    </div>

                    <div class="input-box">
                        <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                        <label>Contraseña</label>
                        <i class="icon"></i>
                        <x-input-error :messages="$errors->get('password')" class="x-input-error" />
                    </div>

                    <div class="remember-password">
                        <label><input type="checkbox" name="remember"> Recuérdame</label>
                    </div>

                    <input class="btn" type="submit" value="Iniciar Sesión">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
