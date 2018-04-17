
<div class="tabs-content">
    <div class="tabs-menu">
        <ul>
            <li><a class="active-tab-menu" href="#1" data-tab="tab1-imp">Base de Contatos</a></li>
            <li><a href="#2" data-tab="tab2-imp">Recuperação de Vendas</a></li>
        </ul>
    </div> <!-- tabs-menu -->

        <div class="widget">
        <div class="field-wrap-c t94">
            <form name="adminform2" action="{{route('admin.importar.recuperacao')}}" method="post" enctype="multipart/form-data" _lpchecked="1">
                <?php echo csrf_field(); ?>
                <div class="field-wrap t90">
                    <label for="recuperacao" class="icone" id="planilhaHotmart"><img src="/images/import_input.svg" width="70" />
                        <h3 style="font-size:20px; margin-top:20px; color:#a4a4a4">Comece importando um arquivo <strong>.csv</strong> de recuperação</h3>
                        <p style="color:#d2d2d2">Basta clicar aqui para fazer a busca no seu computador</p>

                        <p id="planilhaNomeRec"></p>
                    </label>
                    <input type="file" name="planilha2" id="recuperacao">
                </div>

                <div class="field-wrap t100">
                    <button type="submit" name="enviarPlanilhaRecup" id="planilhaConfig" class="button enviar t30">Importar Planilha</button>
                </div>

            </form>
            </div>
            </div>
        </div>
