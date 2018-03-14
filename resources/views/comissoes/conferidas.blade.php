<div class="widget" style="min-height: 230px;">
    <div class="content">

        <div class="field-wrap-c" style="float:left; width:44.5%">
            <h1 style="font-size:65px; text-align: center; font-weight: bold; color:#ee1107;">
                {!! $nao_aprovadas !!}</h1>
            <br>
            <p align="center" style="font-weight: normal">Registros de venda não batem</p>
            <p style="text-align: center; font-size:12px;">Basta clicar no botão abaixo para conferir manualmente</p>
            <a href="#" data-tab="com-tab3" id="aprovarmanual"><button class="button enviar t100">Aprovar Manualmente</button></a>
        </div>

        <div class="field-wrap-c" style="float:right; width:44.5%">
            <h1 style="font-size:65px; text-align: center; font-weight: bold; color:#99e802;">{!! $aprovadas !!}</h1>
            <br>
            <p align="center" style="font-weight: normal">Registros de vendas aprovadas</p>
            <p style="text-align: center; font-size:12px;">Basta clicar no botão abaixo para aprovar manualmente</p>
            <a href="#" data-tab="com-tab5" id="comissionar"><button class="button enviar t100">Comissionar Vendas Pendentes</button></a>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        $('#aprovarmanual').click(function(){
            var a = $('.tabs-menu ul li:nth-child(3) a');
            var active_tab_class = 'active-tab-menu';
            var the_tab = '.' + a.attr('data-tab');

            $('.tabs-menu ul li a').removeClass(active_tab_class);
            a.addClass(active_tab_class);

            if(the_tab == '.com-tab1'){
                location.href='/admin/comissoes';
            }else if(the_tab == '.com-tab2'){
                var tab1 = '/admin/comissoes/conferidas';
            }
            else if(the_tab == '.com-tab3'){
                var tab1 = '/admin/comissoes/aprovar-manualmente';
            }
            else if(the_tab == '.com-tab4'){
                var tab1 = '/admin/comissoes/comissionar-pendentes';
            }
            else if(the_tab == '.com-tab5'){
                var tab1 = '/admin/comissoes/gerada';
            }

            $(".widget").html("<div id='loader'></div>").load(tab1,function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success")

                    if(statusTxt == "error")
                        alert("Error: " + xhr.status + ": " + xhr.statusText);
            });

            return false;
        });


        $('#comissionar').click(function(){

            var a = $('.tabs-menu ul li:nth-child(4) a');
            var active_tab_class = 'active-tab-menu';
            var the_tab = '.' + a.attr('data-tab');

            $('.tabs-menu ul li a').removeClass(active_tab_class);
            a.addClass(active_tab_class);

            if(the_tab == '.com-tab1'){
                location.href='/admin/comissoes';
            }else if(the_tab == '.com-tab2'){
                var tab1 = '/admin/comissoes/conferidas';
            }
            else if(the_tab == '.com-tab3'){
                var tab1 = '/admin/comissoes/aprovar-manualmente';
            }
            else if(the_tab == '.com-tab4'){
                var tab1 = '/admin/comissoes/comissionar-pendentes';
            }
            else if(the_tab == '.com-tab5'){
                var tab1 = '/admin/comissoes/gerada';
            }

            $(".widget").html("<div id='loader'></div>").load(tab1,function(responseTxt, statusTxt, xhr){
                if(statusTxt == "success")

                    if(statusTxt == "error")
                        alert("Error: " + xhr.status + ": " + xhr.statusText);
            });

            return false;
        });
    });

</script>
