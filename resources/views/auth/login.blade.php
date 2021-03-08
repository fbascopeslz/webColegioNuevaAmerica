<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de informacion para la gestion de Inventario, Ventas y Compras">
    <meta name="author" content="Grupo 10">
    <meta name="keyword" content="Sistema para la distribuidora APARICIO">

    <title>SAPARICIO</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.min.css" rel="stylesheet"> 
    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet"> 

</head>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group mb-0">
                <div class="card p-4">
                    <form class="form-horizontal was-validated" method="POST" action="{{ route('login') }}">
                        @csrf {{-- Proteger de solicitudes de falsificacion atraves de sitios Cross Site--}}
                        <div class="card-body">
                            <h1>Acceder</h1>
                            <p class="text-muted">Control de acceso al sistema</p>
                            <div class="form-group mb-3 {{$errors->has('Usuario' ? 'is-invalid' : '')}}"> {{--Si el Usuario es invalido se agregara la clase is-invalid al div--}}
                                <span class="input-group-addon"><i class="icon-user"></i></span>
                                <input type="text" value="{{old('Usuario')}}" name="Usuario" id="Usuario" class="form-control" placeholder="Usuario">
                                {!!$errors->first('Usuario', '<span class="invalid-feedback">:message</span>')!!} {{--Motrar los errores(si ocurre) en el span--}}
                            </div>
                            <div class="form-group mb-4 {{$errors->has('Contrasenia' ? 'is-invalid' : '')}}">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input type="password" name="Contrasenia" id="Contrasenia" class="form-control" placeholder="Contrasenia">
                                {!!$errors->first('Contrasenia', '<span class="invalid-feedback">:message</span>')!!}
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-4">Acceder</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sistema para la distribuidora "APARICIO"</h2>
                            <p>Sistema de informacion para la gestion de Inventario, Ventas y Compras.</p>
                            <a href="https://www.saparicio.xyz/" target="_blank" class="btn btn-primary active mt-3">Web</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    
    <!-- Bootstrap and necessary plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/pace.min.js"></script> 
    <!-- Plugins and scripts required by all views -->
    <script src="js/Chart.min.js"></script> 
    <!-- GenesisUI main scripts -->
    <script src="js/template.js"></script> 

</body>
</html>