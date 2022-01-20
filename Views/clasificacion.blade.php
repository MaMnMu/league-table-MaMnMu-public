@extends('master')
@section('content')
<div>
    <table>
        <caption>Clasificación</caption>
        <thead>
            <tr>
                <th>Equipos</th>
                <th>Puntos</th>
                <th>Goles a favor</th>
                <th>Goles en contra</th>
                <th>Gol average</th>
            </tr>
        </thead>
        @foreach ($clasif as $equipo => $resultFinal)
        <tbody>
            <tr>
                <th>{{$equipo}}</th>
                @foreach ($resultFinal as $param => $valor)
                <td>{{$valor}}</td>
                @endforeach
            </tr>
        </tbody>
        @endforeach
            
    </table>
</div>
@endsection

