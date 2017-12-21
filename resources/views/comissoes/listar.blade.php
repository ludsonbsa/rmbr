@extends(layout())

@section('content')
<section class="content" style="background:url('images/bglead.jpg') repeat-x #f0f0f0;">
<div class="widget" style="min-height: 230px;">
    <div class="content">
        <table id="myTable" border="0" width="100">
            <thead>
            <tr>
                <th class="header">Nome</th>

                <th class="header">Produto</th>

                <th class="header">Mes/Ano</th>

                <th class="header">Quantidade de Vendas</th>

                <th class="header">Soma de Vendas</th>

                <!--<th class="header">Pagamento</th>-->
            </tr>

            </thead>

            <tbody>

            <form action="" method="post">
                <tr class="odd">

                    <td><img src="">AVATAR<span></span></td>

                    <td></td>

                    <td class="meio"><span>DATAS</span></td>

                    <td>COUNTIDUSER</td>

                    <td class="meio"><span class="vendido">SOMA</span></td>

                    <!--<td>
                      <select name="pago">

                           <option value="1">Pago</option>

                           <option value="0">Não Pago</option>

                       </select>

                    </td>-->
                </tr>
            </tbody>
        </table>
        <!-- <div class="field-wrap" style="float: right;">

            <button type="submit" name="enviarQuery" class="button enviar t60">Confirmar Pagamentos</button>

         </div>-->

        </form>
    </div>
</div>
</section>
@endsection