$(document).ready(function() {
    $('.ui-helper-hidden-accessible').hide();
    $("#loader").hide();
    $( ".tool" ).tooltip({
        tooltipClass: "tooltip",
    });

    $("#loader").fadeOut();

    $('.tabs-menu ul li a').click(function(){

        var a = $(this);
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });


        return false;
    });

    /*$('.tabs-menu ul li:nth-child(3) a').click(function(){
        alert('vai');

    });*/

    //Tab de comissões -> Levar para a aba específica de aprovar manualmente
    $('#aprovarmanual').click(function(){
        var a = $('.tabs-menu ul li:nth-child(3) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').hide();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });

    //Tab de comissões -> Levar para a aba específica de comissões
    $('#comissionar').click(function(){
        var a = $('.tabs-menu ul li:nth-child(4) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });

    $('#brindeaprovar').click(function(){
        var a = $('.tabs-menu ul li:nth-child(3) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });

    $('#brindesap').click(function(){
        var a = $('.tabs-menu ul li:nth-child(4) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });


    $('#refresher').click(function() {

        $.ajax({
            beforeSend: function() {
                $('#loader').fadeIn();
                location.reload(true);
            }
        }).done(function() {
            $('#loader').fadeOut();
        });

        return false;
    });

    $("#upload").change(function() {
        $('#forup').html($('input[type="file"]').val());
    });


    $('form[name="adminform"]').submit(function() {

        $(this).ajaxForm({
            uploadProgress: function(event, position, total, percentComplete) {
                $('progress').attr('value',percentComplete);
                $('#porcentagem').html(percentComplete+'%');
            },
            success: function(data) {
                $('progress').attr('value','100');
                $('#porcentagem').html('100%');
                $('pre').html(data);
            }
        });

    });

    $("#hotmart").change(function() {
        $('#planilhaNome').html($('input[type="file"]').val());
    });

    $("#recuperacao").change(function() {
        $('#planilhaNomeRec').html($('input[type="file"]').val());
    });


    // Table sorter
    $("#myTable").tablesorter();
    $("#table").tablesorter();
    $("tr:not(.table-head):odd").addClass("odd");

    // Hide alert
    $(".close").click(function(){
        $(this).parent().parent().fadeOut(500);
        $(".content").delay(300).animate({"marginTop" : 0});
    });

});

$(document).ready(function() {
    var buscarBrinde = $('#buscaBr').val();
    $('form[name="encontrarBrinde"]').submit(function () {
        var buscarBrinde = $('#buscaBr').val();
        $.ajax({
            type: 'POST',
            url: 'https://mbr.digital/brinde-ajax',
            data: $(this).serialize(),
            dataType: 'json',
            encode:true,
            beforeSend: function(){
                $('#loader').fadeIn();
                $('#resultado').fadeOut();
            }
        }).done(function(data) {
            if(data){
                $('#loader').fadeOut();
                $('#nome').delay(500).text(data.nome);
                $('#email').delay(500).text(data.email);
                $('#cep').delay(500).text(data.cep);

                if(data.etiqueta_gerada == 1){
                    $('#etiqueta_gerada').text("Etiqueta já gerada, não é possível editar o endereço");
                    $('.enviar').hide();
                }else{
                    $('#etiqueta_gerada').text("A etiqueta ainda não foi gerada");
                    $('.enviar').attr('href','editar?id='+data.id);
                }

                if(data.aprovado == 1){
                    $('#comprou').html("<p style='text-align: left;'>É aluna ou já comprou</p>");
                    $('#dataVenda').html("<p style='text-align: left;'>Data de transação: "+data.data_de_venda+"</p>");
                }else{
                    $('#comprou').html("<p style='text-align: left;'>Não é aluna ou não comprou</p>");
                }

                $('#email').text(data.email);

                if(data.enviar_kit == 1){

                }

                $('#notify').fadeOut();
                $('#resultado').delay(600).fadeIn();
            }else{
                $('#loader').fadeOut();
                $('#notify').fadeIn(300).html("<p style='font-size:20px;'>Este contato não se encontra na base de Brindes</p><p style='font-size:18px;'><a href='/admin/brindes/add?email="+buscarBrinde+"'>Clique aqui</a> para adicionar um brinde a este contato</p>");
            }
        }).fail(function(){
            console.log("Deu erro");
        });
        event.preventDefault();
    });


    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");
                $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });

    $(".deletarIni").click(function(){

        var conf = confirm("Deseja excluir o registro?");
        var val = $(this).attr('data-value');
        if(conf == true){
            $(location).attr('href', val);
        }
    });

    $('.notificar').click(function(){
        $(this).fadeOut();
    });

    $(window).unload(function() {
        $.ajax( {
            url: "https://mbr.digital/admin/logout/"
        });
    });

});


