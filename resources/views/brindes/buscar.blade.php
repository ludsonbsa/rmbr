@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

    <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Buscar Brinde</h1>

    <section class="widget" style=" height:160px;">

        <div class="faixa"></div>

        <br>

        <form action="" name="encontrarBrinde" id="brindeFind" method="post">
            <div class="field-wrap t96">
                <label>Digite o E-mail:</label>
                <br>
                <input type="search" required id="buscaBr" class="t96" style="padding:12px;" name="buscarBrinde" placeholder="Digite o e-mail ou cep do contato...">
            </div>
        </form>

    </section>

    <div id="loader"></div>

    <section id="resultado" style="display:none;">

        <h1 style="font-size:25px; font-weight: bold;" id="resultadoBusca"></h1>
        <br><br>
        <div class="field-wrap floatLeft dentro" style="width:40%; padding-right:30px; border-right: 2px solid #dbdbdb;">

            <img src="/images/perfil.png" class="perfil floatLeft" />
            <div class="field-wrap floatRight t55">
                <br>

                <p style="color:#ff8169; font-size:24px;" id="nome"></p>
                <p><small id="email"></small></p>
                <p>CEP: <small id="cep"></small></p>

                <p id="comprou"></p>
                <p id="dataVenda"></p>
            </div>
        </div>
        <div class="field-wrap t45">
            <br><br>
            <p id="etiqueta_gerada" style="font-weight: bold; line-height: 30px; text-align: center; font-size:26px; color:#878787;">A etiqueta ainda não foi gerada</p>
            <br>

            <a href="#" class="enviar"><button class="enviar t96">Você pode editar este endereço</button></a>
        </div>
    </section>

    <p id="notify" style="display:none"></p>
</section>
@endsection