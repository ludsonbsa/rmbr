@extends(layout())

@section('content')

    @foreach($contato as $cont) @endforeach
    <form action="{{route('admin.leads.editar-update-ligar-depois',$cont->id)}}" method="post">
        <section class="content">

            <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Atendimento de Contato</h1>

            <section class="widget" style="height:350px; background:#f7f7f7;">
                {!! Session::get('msg')  !!}
                @if(session()->has('msg'))
                    <div class='alert alert-success'>
                        {{ session('msg') }}
                    </div>
                @elseif(session()->has('msg-error'))
                    <div class='alert alert-danger'>
                        {{ session('msg-error') }}
                    </div>
                @endif

                <div class="faixa-cinza">

                    <div class="t30 floatLeft"></div>

                    <div class="t70 floatRight"> <h1>{!! $cont->nome !!}</h1></div>

                </div>


                <div class="dados">

                    <div class="t30 floatLeft">

                        <img src="/images/leads/perfil.png" class="perfil" />

                    </div>

                    <div class="t70 floatRight">

                        <p><img src="/images/e-mail.svg" width="23" /> <span>
                        {{$cont->email}}
                    </span></p>

                        <p><img src="/images/phone.svg" width="23" /><span class="telefone">({{$cont->ddd}}) {{$cont->telefone}}</span></p>

                        <br>

                        <p>Data de cadastro: <strong>{{$cont->data_de_venda}}</strong></p>

                        <p>Inserido por: <strong>{!! $cont->user_nome !!}</strong></p>

                        <p>Meio de inserção: <strong>{!!$cont->insercao_hotmart!!}</strong></p>

                        <p>Prioridade de Atendimento: <strong>{!! $cont->prioridade !!}</strong></p>

                        <p>Produto: <strong>{!! $cont->nome_do_produto !!}</strong></p>

                        <p>Obs.: <strong style="color:red">{!! $cont->observacao !!}</strong></p>

                    </div>

                </div>

            </section>

        </section>


        <section class="content" style="margin-top:-120px;">

            <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Preencha informações de Atendimento</h1>

            <section class="widget" style="height:330px;">


                <div class="field-wrap t94">

                    <label>Observações de follow-up: </label>

                    <br>

                    <textarea name="obs_followup" class="t100">{!! $cont->obs_followup !!}</textarea>

                </div>
                {!! csrf_field()!!}

                <input type="hidden" name="insercao_hotmart" value="{{$cont->insercao_hotmart}}">

                <input type="hidden" name="observacao" value="{{$cont->observacao}}">

                <div class="field-wrap t50">

                    <label>Pós-Atendimento:</label>

                    <br>

                    <select name="pos_atendimento" class="pos_atendimento" required>

                        @if($cont->pos_atendimento != null)
                            {!!'<option>'.$cont->pos_atendimento.'</option>'!!}
                        @else
                            {!! '<option></option>'!!}
                        @endif

                        <option disabled=disabled>----------------------------------</option>

                        <option value="Vendido">Vendido </option>

                        <option value="Não Vendido">Não Vendido</option>

                        <option value="Boleto Gerado">Boleto Gerado</option>

                        <option value="Ligar Depois">Ligar Depois</option>

                        <option value="Boleto Não Atendido">Boleto Não Atendido</option>

                        <option value="Não Atendeu">Não Atendeu a Ligação</option>

                        <option value="Ja comprado">Já comprado</option>

                    </select>

                </div>



                <div class="field-wrap t20 ligarD" style="display:none;">

                    <label>Dia para ligar depois:</label>

                    <br>
                    <input type="date" class="ligarDepois" name="ligarDepois"
                           @if($cont->pos_atendimento == 'Ligar Depois')
                           {{ $dia =  date('Y-m-d', strtotime($cont->data_ligar_depois)) }}

                           value="{!! $dia !!}">
                    @else
                        value="">
                    @endif


                </div>

                <div class="field-wrap t20 ligarD" style="display:none;">

                    <label>Hora para ligar depois:</label>

                    <br>

                    <select name="ligarDepois-hora">

                        @if($cont->pos_atendimento == 'Ligar Depois') {{ $hora = date('H:i', strtotime($cont->data_ligar_depois)) }}

                        <option value="{!! $hora !!}">{!! $hora !!}</option>

                        @else
                            <option value=""></option>
                        @endif


                        <option disabled>------------------------------------</option>

                        <option value="08:00">08:00</option>

                        <option value="08:30">08:30</option>

                        <option value="09:00">09:00</option>

                        <option value="09:30">09:30</option>

                        <option value="10:00">10:00</option>

                        <option value="10:30">10:30</option>

                        <option value="11:00">11:00</option>

                        <option value="11:30">11:30</option>

                        <option value="12:00">12:00</option>

                        <option value="12:30">12:30</option>

                        <option value="13:00">13:00</option>

                        <option value="13:30">13:30</option>

                        <option value="14:00">14:00</option>

                        <option value="14:30">14:30</option>

                        <option value="15:00">15:00</option>

                        <option value="15:30">15:30</option>

                        <option value="16:00">16:00</option>

                        <option value="16:30">16:30</option>

                        <option value="17:00">17:00</option>

                        <option value="17:30">17:30</option>

                        <option value="18:00">18:00</option>

                        <option value="18:30">18:30</option>

                        <option value="19:00">19:00</option>

                        <option value="19:30">19:30</option>

                        <option value="20:00">20:00</option>

                        <option value="20:30">20:30</option>

                        <option value="21:00">21:00</option>

                        <option value="21:30">21:30</option>

                        <option value="22:00">22:00</option>

                        <option value="22:30">22:30</option>

                        <option value="23:00">23:00</option>

                        <option value="23:30">23:30</option>

                        <option value="00:30">00:00</option>

                    </select>

                </div>

                <script>
                    $(document).ready(function() {
                        $('.ligarD'); //tem q passar o horario e o dia do liga depois pro controller!
                    });
                </script>
                <input type="hidden" name="data_ligar_depois" value="">

                <div class="field-wrap t50 kits">

                    <label for="enviar_kit">Este contato terá direito a brinde?</label>

                    <br>

                    <select name="enviar_kit" class="kit" title="KIT">

                        @if($cont->enviar_kit == 1)
                            <option value="1">Sim, terá direito.</option>
                        @else
                            <option value="0">Não terá direito.</option>
                        @endif

                        <option>Selecione uma opção</option>

                        <option disabled=disabled>-----------</option>

                        <option value="1">Sim, terá direito.</option>

                        <option value="0">Não terá direito.</option>

                    </select>

                </div>

            </section>
        </section>

        <input type="hidden" name="at_inicio_atendimento" value="<?php echo date('Y-m-d H:i');?>" />

        <section class="content direitoBrinde" style="display:none; margin-top:-120px;">

            <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Preencha informações de Entrega de Kit</h1>

            <section class="widget" style="height:430px;">

                <div class="field-wrap t40">

                    <label>Nome Completo:</label>

                    <input type="text" name="nome"  class="t100" value="{!! $cont->nome !!}">

                </div>

                <div class="field-wrap t20">

                    <label>CPF:</label>

                    <input type="text" id="documento_usuario" name="documento_usuario" class="t90" value="{{$cont->documento_usuario}}" placeholder="">

                </div>

                <div class="field-wrap t30">

                    <label>E-mail:</label>

                    <input type="email" name="email" value="{!! $cont->email !!}" class="t100" placeholder="">

                </div>



                <div class="field-wrap t10
">

                    <label>DDD:</label>

                    <input type="text" id="ddd" maxlength="2" name="ddd" class="t90" value="{!! $cont->ddd !!}">

                </div>



                <div class="field-wrap t20">

                    <label>Telefone:</label>

                    <input type="text" id="telefone" name="telefone" class="t90" value="{!! $cont->telefone !!}" placeholder="">

                </div>



                <div class="field-wrap t15">

                    <label>CEP:</label>

                    <input type="text" id="cep" name="cep" class="t90" value="{!! $cont->cep !!}">

                </div>



                <div class="field-wrap t30">

                    <label>Estado:</label>


                    <input type="text" name="estado" id="uf" maxlength="2" class="t100" value="{!! $cont->estado !!}" placeholder="Digite apenas o UF">

                </div>



                <div class="field-wrap t30">

                    <label>Cidade:</label>

                    <input type="text" name="cidade" id="cidade" value="{!! $cont->cidade !!}">

                </div>



                <div class="field-wrap t30">

                    <label>Bairro:</label>

                    <input type="text" name="bairro" id="bairro" class="t100" value="{!! $cont->bairro !!}">

                </div>



                <div class="field-wrap t50">

                    <label>Endereço:</label>

                    <input type="text" name="endereco"  id="endereco" class="t100" value="{!! $cont->endereco !!}">

                </div>

                <div class="field-wrap t10">

                    <label>Número:</label>

                    <input type="text" name="numero" id="numero" class="t100" value="{!! $cont->numero !!}">

                </div>

                <div class="field-wrap t94">

                    <label>Complemento:</label>

                    <input type="text" name="complemento"  class="t100" value="{!! $cont->complemento !!}">

                </div>
            </section>

        </section>



        <div class="field-wrap t60 floatRight" style="margin-top:-40px; padding-bottom:20px;">

            <button type="submit" name="sendForm" class="enviar">Finalizar Atendimento</button>


            <a href="{{route('admin.lead.cancelar', $cont->id)}}">
                <span name="cancelar" class="cancelar floatRight">Cancelar Atendimento</span>
            </a>

        </div>
    </form>
@endsection