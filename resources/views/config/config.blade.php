@extends(layout())

@section('content')
    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
    <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Configurações do Sistema</h1>
    <section class="widget" style="min-height:580px;">
        <div class="faixa"></div>
        <br>
        <div class="content">
            <h1 style="font-size:20px; margin-bottom:20px;">API's</h1>
            <small style="display:block;margin-bottom:10px;">Chaves de Acesso</small>
            @foreach($produtos as $prod)
            <form name="formulario" action="" method="post" enctype="multipart/form-data">
                <div class="field-wrap t60">
                    <label>Chave de API <span class="produto">(Insira API Hotmart)</span></label>

                    <input type="text" name="api_chave" class="t100" value="{{$prod->api_chave}}" required="required" />
                </div>



           <div style="clear:both;"></div>

                <hr />
                <br />

            <div style="display:block; margin-bottom:20px;">
                <h1 style="font-size:20px; margin-bottom:20px;">Listagem de Produtos</h1>
                <small style="display:block;margin-bottom:10px;">Produto/Comissão</small>
                &nbsp;&nbsp;&nbsp;<select name="produtos">

                    <option value="{{$prod->prod_valor_comissao}}">{!! $prod->prod_nome_do_produto !!} / R${{$prod->prod_valor_comissao}}</option>
                    @endforeach
                </select>
            </div>

            <hr />
            <br />

                <div class="field-wrap t60">
                    <label>Produto <span class="produto">(Insira o nome igual está no Hotmart)</span></label>
                    <input type="hidden" name="id" value=""/>
                    <input type="text" name="nome_do_produto" class="t100" value="{!! $prod->prod_nome_do_produto !!}" required="required" />
                </div>

                <div class="field-wrap t30">
                    <label>Valor da Comissão de venda <span class="produto">(em R$)</span>:</label>
                    <input type="text" name="prod_valor_comissao" class="t100" value="{{$prod->prod_valor_comissao}}" required="required" />
                </div>

                <div class="field-wrap t94">
                    <button type="submit" name="sendForm" class="enviar">Atualizar</button>
                </div>

            </form>


        </div>
    </section>
    @endsection