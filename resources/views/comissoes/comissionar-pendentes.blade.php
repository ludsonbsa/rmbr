<form action="" name="enviarQueries" method="post">
<table id="myTable" border="0" width="100">
    <thead>
    <tr>
        <th class="header">Nome</th>
        <th class="header">CPF</th>
        <th class="header">Telefone</th>
        <th class="header">E-mail</th>
    </tr>
    </thead>
    <tbody>




        @foreach($contatos as $contato)


        <tr class="odd">

            <td class="nome">{!! $contato->nome !!}</td>
            <td>{!! $contato->documento_usuario !!}</td>
            <td>{!! $contato->telefone !!}</td>
            <td>{!! $contato->email !!}</td>

        </tr>
        @endforeach

    </tbody>

</table>

<?php
if($contagem == 0){
    echo "<h3 style=\"font-size:18px; float:left; font-weight: 500; color:#636363; margin-left:18px; margin-top:18px;\">Nenhuma venda pendente</h3>";
}else{
    echo
    '<div class="field-wrap" style="float: right;">
           <a href="#4"><button type="submit" name="enviarQueryVendaAprovadas" class="enviar">Comissionar Vendas</button></a>
        </div>';
}
;?>

</form>
