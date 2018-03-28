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
            </tr>
            </thead>
            <tbody>
            <form action="" method="post">

                @foreach($contatos as $contato)
                <?php
                $qtde = $contato->count_id_user;

                $soma = $contato->soma_final;

                $final = $contato->com_final;
                $calc = $qtde*$final;
                ?>
                <tr class="odd">

                    <td><img src="{!! $contato->avatar !!}" width="40" height="40" class="atendente perfilEdit" alt="[Avatar]" /> <span class="comis">{!!  $contato->user_nome !!}</span></td>
                    <td>{!! $contato->com_produto !!}</td>
                    <td class="meio"><span>{!! $contato->com_mes !!} / {!! $contato->com_ano !!}</span></td>
                    <td>{!! $contato->count_id_user !!}</td>
                    <td class="meio"><span class="vendido">R$ {!! $soma !!}</span></td>
                    <!--<td>

                      <select name="pago">
                           <option value="1">Pago</option>
                           <option value="0">Não Pago</option>
                       </select>
                    </td>-->

                </tr>

            @endforeach
            </tbody>

        </table>

        <!-- <div class="field-wrap" style="float: right;">
            <button type="submit" name="enviarQuery" class="button enviar t60">Confirmar Pagamentos</button>
         </div>-->
        </form>


    </div>
</div>