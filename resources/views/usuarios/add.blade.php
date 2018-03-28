
<section class="widget" style="min-height:700px;">

    <div class="faixa"></div>
    <br>
    <div class="content">

        <form name="formulario" action="{{route('admin.cadastrar.usuarios')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            {!! csrf_field() !!}
            <input type="hidden" name="role_name" value="">

            <div class="field-wrap t30">
                <img src="/images/avatar.svg" width="308" height="308" class="perfilEdit avatar" />

                <label for="upload" id="forup" class="forup">Selecionar um arquivo &#187;</label>
                <input type="file" name="avatar" id="upload" class="upload" style="display:none;">

                <img src="/images/alerticon.png" style="margin:8px 5px; float:left"/>
                <p style="color:#ccc" class="t100">A imagem escolhida deve estar no formato JPG, PNG ou GIF, com no máximo 1 MB de tamanho.</p>
            </div>

            <div class="field-wrap t60">

                <div class="field-wrap t100">
                    <p>Nome Completo:</p>
                    <input type="text" name="user_nome" class="t100" value="" placeholder="" required>

                </div>


                <div class="field-wrap t100">
                    <p>E-mail:</p>
                    <input type="email"  class="t100" name="email" value="" placeholder="">
                </div>


                <div class="field-wrap t100">

                    <p>Senha:</p>
                    <input type="password" class="t100" name="password" value="" placeholder="" required>
                </div>


                <div class="field-wrap t100">

                    <p>Nível</p>

                    <br>

                    <select name="role" class="t100" required>
                        <option disabled>================</option>
                        <option value="1">Administrador</option>
                        <option value="2">Responsável</option>
                        <option value="3">Atendente</option>
                        <option value="4">Suporte</option>
                        <option value="5">Aux. Admin</option>
                        <option value="6">Atendente Temporário</option>
                    </select>
                </div>

                <div class="field-wrap t100">

                    <p>Status</p>
                    <br>
                    <select name="status" class="t100" required>
                        <option  value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <br>
                <div class="field-wrap t100">
                    <button type="submit" name="sendForm" class="enviar">Adicionar Usuário</button>
                </div>

            </div><!-- final da sessao field wrap -->


        </form>
    </div>
</section>


<script>
    $(function(){
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.avatar').attr('src', e.target.result);
                    $('.avatar').fadeIn('slow');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#upload").click(function(){
            $('.avatar').fadeOut('fast');
        });

        $("#upload").change(function() {
            readURL(this);
            var arq = this.files[0];
            $(this).val(arq.name);
        });
    });
</script>

