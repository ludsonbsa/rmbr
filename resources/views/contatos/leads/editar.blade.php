@extends(layout())

@section('content')
    <?php

    $estadosBrasileiros = array(

        'AC'=>'Acre',

        'AL'=>'Alagoas',

        'AP'=>'Amapá',

        'AM'=>'Amazonas',

        'BA'=>'Bahia',

        'CE'=>'Ceará',

        'DF'=>'Distrito Federal',

        'ES'=>'Espírito Santo',

        'GO'=>'Goiás',

        'MA'=>'Maranhão',

        'MT'=>'Mato Grosso',

        'MS'=>'Mato Grosso do Sul',

        'MG'=>'Minas Gerais',

        'PA'=>'Pará',

        'PB'=>'Paraíba',

        'PR'=>'Paraná',

        'PE'=>'Pernambuco',

        'PI'=>'Piauí',

        'RJ'=>'Rio de Janeiro',

        'RN'=>'Rio Grande do Norte',

        'RS'=>'Rio Grande do Sul',

        'RO'=>'Rondônia',

        'RR'=>'Roraima',

        'SC'=>'Santa Catarina',

        'SP'=>'São Paulo',

        'SE'=>'Sergipe',

        'TO'=>'Tocantins'

    );
    ?>

@foreach($contato as $cont)


<section class="content">

    <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Atendimento de Contato</h1>
    <br /><br />
        <section class="widget" style="height:480px; background:#f7f7f7;">

            <div class="dados">
                <form action="{{route('admin.leads.editar-update',$cont->id)}}" method="post">
                <div class="t30 floatLeft">
                    <img src="/images/leads/perfil.png" class="perfil" />
                </div>

                <div class="t70 floatRight">
                    <p><img src="/images/e-mail.svg" width="23" /> <span>
                            {!! csrf_field() !!}
                            <input type="text" name="email" value="{!! $cont->email !!}">
                    </span></p>

                    <p><img src="/images/leads/phone.svg" width="23" />
                        <span class="telefone">
                            <input type="text" name="ddd" maxlength="2" value="{!! $cont->ddd !!}" style="width:50px;"> <input type="text" name="telefone" value="{!! $cont->telefone !!}" style="width:120px;"></span></p>
                    <br />

                <input type="hidden" name="at_inicio_atendimento" value="<?php echo date('Y-m-d H:i');?>" />
                    <br />

                    <p>Data de cadastro:
                        {!! $cont->data_de_venda !!}</p>

                    <br />
                <p>Inserido por: {!! $cont->user_nome !!}</p>
                <br />
                <p>Meio de inserção: &nbsp;
                    <span class="telefone" style="margin-top:-10px;">
                            <input type="text" name="insercao_hotmart" value="{!! $cont->insercao_hotmart !!}"></span>
                 </p>
                 <br /> <br />
                 <p>Prioridade de Atendimento: <span class="telefone" style="margin-top:-10px;"><input type="text" name="prioridade" value="{!! $cont->prioridade!!}"></span></p>
                 <br /><br />
                 <p>Produto: <span class="telefone" style="margin-top:-10px;"><input type="text" name="nome_do_produto" value="{!! $cont->nome_do_produto !!}"></span></p>
                    <br /><br />
                  <p>Observação:  <span class="telefone" style="margin-top:-10px;"><input type="text" name="observacao" value="{!! $cont->observacao !!}"></span></p>
                    <br /><br />
                    <p>Em atendimento: &nbsp; <span class="" style="margin-top:-15px;">
                            <select name="em_atendimento" id="">
                                @if($cont->em_atendimento == NULL)
                                        <option value="0">Sem atendimento</option>
                                    @else
                                        @switch($cont->em_atendimento)
                                            @case(1)
                                                {{ $atendimentoValor = 1 }}
                                                {{ $atendimento = "Em atendimento" }}
                                            @break;

                                            @case(0)
                                                {{ $atendimentoValor = 0 }}
                                                {{ $atendimento = "Sem atendimento" }}
                                            @break;

                                            @endswitch;
                                @endif;
                                <option disabled>-----------------</option>
                                <option value="1">Em atendimento</option>
                                <option value="0">Sem atendimento</option>
                            </select>
                        </span></p>

                </div>

                    <div style="clear:both;"></div><br /><br /><br /><br /><br />

            <div class="field-wrap t60 floatRight" style="margin-top:-40px; padding-bottom:20px;">
                <button type="submit" style="margin-left:20px;" name="sendForm" class="enviar">Finalizar
                    Atendimento</button>
                <a href="{{route('admin.leads')}}"><button class="enviar" style="background:#333">Voltar</button></a>
            </div>

            </form>
            </div>

        </section>

        </div>
</section>
@endforeach
@endsection