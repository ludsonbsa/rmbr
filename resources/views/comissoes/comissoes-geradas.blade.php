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

                @foreach($contato as $contato)
                    <?php
                $qtde = $contato['COUNT(t1.com_id_user)'];

                $soma = $contato['SUM(t1.com_final)'];

                $final = $contato['com_final'];
                $calc = $qtde*$final;
                ?>
                <tr class="odd">

                    <td><img src="<?=HOMEP;?><?php if(isset($contato['avatar'])){ echo $contato['avatar'];} else{ echo 'avatar/avatar.svg'; } ; ?>" width="40" height="40" class="atendente perfilEdit" alt="[Avatar]" /> <span class="comis"><?php echo $contato['user_nome'];?></span></td>
                    <td><?php echo $contato['com_produto'];?></td>
                    <td class="meio"><span><?php echo $contato['com_mes'].'/'.$contato['com_ano'];?></span></td>
                    <td><?php echo $contato['COUNT(t1.com_id_user)'];?></td>
                    <td class="meio"><span class="vendido"><?php echo 'R$ '.$soma;?></span></td>
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