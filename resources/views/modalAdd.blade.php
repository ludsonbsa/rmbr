


<div class="modal modaladd" id="confirm">
    <div class='alert alert-danger erroralert' style="display:none; z-index:999;">
        <div id="msg msgalert"><p class="msgt"></p></div>
    </div>
    <div class="modal-dialog">
        <div class="modal-content" style="background:#f6f6f6;">

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script>
                $(function(){
                    $('#nome').on('input', function() {
                        if (/[0-9]/g.test(this.value)) {
                           $('.erroralert').fadeIn();
                           $('p.msgt').html("Atenção <?php echo Auth::user()->user_nome;?>, o campo NOME não pode conter números.");
                            $(this).val('');
                            setTimeout(function(){
                                $(".erroralert").fadeOut();
                            }, 3000);
                        }
                    });
                });
            </script>

            <div class="modal-header" style="border:none;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            </div>
            <form action="{{route('admin.lead.cadastrar')}}" style="float:none !important;" method="post">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="data_de_venda" value="{{date('d/m/Y H:i:s')}}" />
            <input type="hidden" name="id_responsavel" value="{{Auth::id()}}">
            <div class="modal-body" style="padding:15px 30px">

                <h4 class="headadd">Adicionar Contato</h4>
                <input type="text" name="nome" id="nome" class="mdl" placeholder="Nome:" required>
                <input type="email" name="email" class="mdl" placeholder="E-mail" required>

                <input type="text" name="ddd" style="width:33%; margin-right:10px;" maxlength="4" class="mdl" placeholder="DDI+DDD" required>
                <input type="text" id="telefone" style="width:65%;" name="telefone" maxlength="9" class="mdl" required="required" placeholder="Telefone:">

                <select name="insercao_hotmart" class="mds" style="margin-right:10px;" required>
                    <option value="Chat">Chat</option>
                    <option value="Whatsapp">Whatsapp</option>
                    <option value="E-mail">E-mail</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Instagram">Instagram</option>
                </select>

                <select name="prioridade" class="mds" required>
                    <option value="Dúvidas sobre como pagar">Dúvidas sobre como pagar</option>
                    <option value="Dúvidas profundas sobre o curso">Dúvidas profundas sobre o curso</option>
                </select>

                <textarea name="observacao" class="mda" placeholder="Digite aqui os detalhes..."></textarea>


                <div style="clear:both;"></div>
                </div>

                <div class="modal-footer" style="border:none; padding: 15px 30px;">
                <button class="mdb" type="submit">Adicionar Contato</button>

                </div>
            </form>
        </div>
    </div>
</div>