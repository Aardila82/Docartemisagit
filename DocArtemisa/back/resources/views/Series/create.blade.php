<!DOCTYPE html>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function(){
            
            $('#version').on("change",function(){
                var str="";
                str += $( this ).val();
                if($.trim(str)!=''){
                    $.get('serieTrd.Serfechaini', {id:str},function(info){
                        console.log(info);
                    });
                }
                
                console.log(str);
            }).trigger("change");
        });
    </script>
    <title>Registro de Series</title>
</head>

<body class="bg-dark text-white">
      
<div class="row">

@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <strong>Error para el registr de informacion</strong> Algo fue mal..<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="col-12">
        <div>
            <h2>Crear Serie</h2>
        </div>
        <div>
            <a href="{{route('serieTrd.index')}}" class="btn btn-primary">Volver</a>
        </div>
    </div>

    <form action="{{route('serieTrd.store')}}" method="POST">
        @csrf <!--token de seguridad -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Versi&oacute;n:</strong>
                    <select name="idversion" class="form-select" id="idversion">
                        <option value="">-- Elige la version --</option>
                        @foreach ( $version as $valido )
                            <option value={{$valido->id}}>{{$valido->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Codigo de serie:</strong>
                    <input type="text" name="codigo" class="form-control" placeholder="codigo de serie" >
                </div>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Nombre de serie:</strong>
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripci&oacute;n de serie" >
                </div>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha Inicio:</strong>
                    <input type="date" min='2025-04-19' name="fechainicio" class="form-control" id="">
                </div>

                <div class="form-group">
                    <strong>Fecha Inicio:</strong>
                    <input type="date" name="fechafin" class="form-control" id="">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Estado:</strong>
                    <select name="estado" class="form-select" id="">
                        <option value="Registrado" >Registrado</option>
                        <option value="Activo"     >Activo</option>
                        <option value="Inactivo"   >Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </form>
</div>
       
    
    
    
      
</body>
</html>
