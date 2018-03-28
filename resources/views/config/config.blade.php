@extends(layout())

@section('content')
    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
    <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Configurações do Sistema</h1>
    <section class="widget" style="min-height:400px;">
        <div class="faixa"></div>
        <br>
        <div class="content">

            <div style="display:block; margin-bottom:20px;">
                <h1 style="font-size:20px; margin-bottom:20px;">Listagem de Produtos</h1>
                <small style="display:block;margin-bottom:10px;">Produto/Comissão</small>
                <select name="produtos">
                    @foreach($produtos as $prod)
                    <option value="{{$prod->prod_valor_comissao}}">{!! $prod->prod_nome_do_produto !!} / R${{$prod->prod_valor_comissao}}</option>
                    @endforeach
                </select>
            </div>

            <hr />
            <br />
            <form name="formulario" action="" method="post" enctype="multipart/form-data">

                <div class="field-wrap t60">
                    <label>Produto <span class="produto">(Insira o nome igual está no Hotmart)</span></label>
                    <input type="hidden" name="id" value=""/>
                    <input type="text" name="nome_do_produto" class="t100" value="" required="required" />
                </div>

                <div class="field-wrap t30">
                    <label>Valor da Comissão de venda <span class="produto">(em R$)</span>:</label>
                    <input type="text" name="valor_comissao" class="t100" value="" required="required" />
                </div>

                <div class="field-wrap t94">
                    <button type="submit" name="sendForm" class="enviar">Atualizar</button>
                </div>

            </form>
        </div>
    </section>
    @endsection