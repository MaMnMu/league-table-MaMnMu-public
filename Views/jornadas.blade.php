@extends('master')
@section('content')
            <form id="form2" name="formulario2" action="index.php" method="POST">
                    <div>    
                        @foreach ($arrequipos as $local)
                        <table>
                            <caption>Jornadas del {{$local}}</caption>
                            <thead>
                                <tr>
                                   <th>Equipo local</th>
                                   <th>Goles a favor</th>
                                   <th>Goles en contra</th>
                                   <th>Equipo visitante</th>
                                </tr>
                            </thead>
                            @foreach ($arrequipos as $visitante)
                                @if ($local != $visitante)
                                <tbody>
                                    <tr>
                                        <td>{{$local}}</td>
                                        <td><input type="number" value="{{rand(1,5)}}" name="arrequipos[{{$local}}][{{$visitante}}][golfavor]" /></td>
                                        <td><input type="number" value="{{rand(1,5)}}" name="arrequipos[{{$local}}][{{$visitante}}][golcontra]" /></td>
                                        <td>{{$visitante}}</td>
                                    </tr>
                                </tbody>
                                @endif
                            @endforeach
                        </table>
                        @endforeach
                        <div id="btncentro">
                            <input type="submit" value="Mostrar clasificación" name="mostrarclas">
                        </div>
                </div>
            </form>
@endsection

