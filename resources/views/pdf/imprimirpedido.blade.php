<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido</title>
    <link rel="stylesheet" type="text/css" href="css/pdf.css" >
</head>
<header>
    <div id="logo">
        <img src="img/favicon.png" alt="incanatoIT" id="imagen">
    </div>
    <div id="datos">
        <p id="encabezado">
            <b>ImaxIT</b><br>Diego Osorio, Colombia - Medellin <br>Telefono:(+57)3196478438<br>Email:dieguinosorio@gmail.com
        </p>
    </div>
    <div id="fact">
        <p>Pedido<br>
        {{$pedido->NroDocumento}}</p>
    </div>
</header>
<div>
    <table id="tablehead">
            <tr>
                <td>Sr(a). {{$pedido->IdTercero}}</td>
                <td>Documento: {{$pedido->NroDocumento}}</td>
                <td>Dirección: {{$pedido->IdDireccion}}</td>
            </tr>
            <tr>
                <td>Sr(a). {{$pedido->IdTercero}}</td>
                <td>Documento: {{$pedido->NroDocumento}}</td>
                <td>Dirección: {{$pedido->IdDireccion}}</td>
            </tr>
    </table>
</div>
<hr>
<body>

    <table id="tableinfo">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Artículo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Iva</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @if($cont > 0)
            @foreach($detalles as $detalle)
                <tr>
                    <td>{{$detalle['Id_Item']}}</td>
                    <td>{{$detalle['Descripcion']}}</td>
                    <td>{{$detalle['Precio']}}</td>
                    <td>{{$detalle['Cantidad']}}</td>
                    <td>{{$detalle['PorIva']}}</td>
                    <td>{{$detalle['Precio']}}</td>
                </tr>
                
            @endforeach
                <tr style="background-color: #CEECF5;">
                    <td colspan="5" align="right"><strong>Total Iva:</strong></td>
                    <td>$ </td>
                </tr>
                <tr style="background-color: #CEECF5;">
                    <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                    <td>$ </td>
                </tr>
                <tr style="background-color: #CEECF5;">
                    <td colspan="5" align="right"><strong>Total:</strong></td>
                    <td>$ </td>
                </tr>
            </tbody>
        @else if($cont<=0)
            <tbody>
                <tr>
                    <td colspan="5">No hay articulos</td>
                </tr>
            </tbody>     
        @endif                            
    </table>
        
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}}</p>
    </div>    
</body>
</html>
