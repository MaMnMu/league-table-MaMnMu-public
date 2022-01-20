@extends('master')
@section('content')
            <form id="form1" name="formulario" action="index.php" method="POST">
                    <div>    
                        <label for="equipos">Introduzca el nombre de los equipos:</label><br> 
                        <input id="equipos" type="text" name="equipos" required />
                    </div>
                    <div>
                        <input class="submit" type="submit" value="Mostrar jornadas" name="mostrarjorn">
                    </div>
                </div>
            </form>
@endsection

