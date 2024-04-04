$.getJSON('cont/getIP.php', function(data){

  let localIP = data.ip;

  if (localIP == '10.215.152.20' || localIP == '10.215.152.21' || localIP == '10.215.158.92' || localIP == '10.215.152.91'|| localIP=='10.215.152.78' || localIP=='10.215.152.18' || localIP =='10.215.152.85' || localIP =='10.215.152.94' || localIP == '10.215.152.11'){


    /*$('.hideSupermercado').show();
    $('.hideRutas').show();
    $('.hideAuditoria').show();
    $('.hideEscaner').show(); 
    $('.hideConversiones').show();
    $('.hideChecadas').show();
    $('.hideSupermercado_opt').show();
    $('.hideBarriles_opt').show();
    $('.hideMaster').show();*/

      
  }
  else if(localIP=='10.215.156.115' || localIP=='10.215.156.91'){
     /*PCs Estaciones*/
    url = window.location.href;
    if (url!='http://10.215.156.203/materiales/rutas/checadas.php' && url!='http://10.215.156.203/materiales/rutas/criticos.php') {
        window.location.href ='http://10.215.156.203/materiales/rutas/checadas.php';
    }
    else{

    }
    /*$('.hideSupermercado').hide();
    $('.hideRutas').hide();
    $('.hideAuditoria').hide();
    $('.hideEscaner').hide();
    $('.hideConversiones').hide();
    $('.hideChecadas').show();
    $('.hideSupermercado_opt').hide();
    $('.hideBarriles_opt').hide();
    $('.hideMaster').hide();*/
  }
  else if(localIP=='10.215.158.72' || localIP == '10.215.156.22' || localIP=='10.215.156.21' || localIP == '10.215.156.64' ){
    /*PCs Barriles
    
    //IZQ a DER - 0 1 2 3
    //PC 0 10.215.158.72
    //PC 1 10.215.156.22
    //PC 2 10.215.156.21
    //PC 3 10.215.156.64
    url = window.location.href;
    if (url!='http://10.215.156.203/materiales/rutas/auditoria.php' && url!='http://10.215.156.203/materiales/rutas/checadas.php' && url!='http://10.215.156.203/materiales/rutas/barriles.php') {
        window.location.href ='http://10.215.156.203/materiales/rutas/auditoria.php';
    }
    else{

    }
    $('.hideSupermercado').hide();
    $('.hideRutas').hide();
    $('.hideAuditoria').show();
    $('.hideEscaner').hide();
    $('.hideConversiones').hide();
    $('.hideChecadas').show();
    $('.hideSupermercado_opt').hide();
    $('.hideBarriles_opt').show();
    $('.hideMaster').hide();*/
  }
  else if(localIP == '10.215.152.84' || localIP == '10.215.152.80'){
    /*//COMPUTADORAS RUTA INTERNA Y EXTERNA GABRIEL - MARIA
    url = window.location.href;
    if (url!='http://10.215.156.203/materiales/rutas/index.php' && url!='http://10.215.156.203/materiales/rutas/rutas.php' && url!='http://10.215.156.203/materiales/rutas/checadas.php' && url!='http://10.215.156.203/materiales/rutas/tiempomuerto.php') {
        window.location.href ='http://10.215.156.203/materiales/rutas/index.php';
    }
    else{

    }
    $('.hideSupermercado').hide();
    $('.hideRutas').hide();
    $('.hideAuditoria').hide();
    $('.hideEscaner').hide();
    $('.hideConversiones').hide();
    $('.hideChecadas').show();
    $('.hideSupermercado_opt').hide();
    $('.hideBarriles_opt').hide();
    $('.hideMaster').hide();*/
  }
  else if(localIP == '10.215.156.155' || localIP =='10.215.156.95'){
    /*//COMPUS DE CALIDAD
    //ALDAIR 10.215.156.155

    //ROCIO 10.215.156.95
    $('.hideConversiones').show();
    $('.hideSupermercado').hide();
    $('.hideRutas').hide();
    $('.hideAuditoria').hide();
    $('.hideEscaner').hide();
    $('.hideChecadas').hide();
    $('.hideSupermercado_opt').hide();
    $('.hideBarriles_opt').hide();
    $('.hideMaster').hide();*/
  }
  else{
    /*
    url = window.location.href;
    if (url!='http://10.215.156.203/materiales/rutas/auditoria.php' && url!='http://10.215.156.203/materiales/rutas/index.php' && url!='http://10.215.156.203/materiales/rutas/busqueda.php' && url!='http://10.215.156.203/materiales/rutas/partial.php' && url!='http://10.215.156.203/materiales/rutas/tiempomuerto.php') {
        window.location.href ='http://10.215.156.203/materiales/rutas/index.php'; 
    }
    else{

    }
    $('.hideSupermercado').show();
    $('.hideRutas').show();
    $('.hideAuditoria').show();
    $('.hideEscaner').show();
    $('.hideConversiones').hide();
    $('.hideChecadas').hide();
    $('.hideSupermercado_opt').show();
    $('.hideBarriles_opt').hide();
    $('.hideMaster').hide();
    if(isUserOnMobile()){
        $(".pc").hide();
        
    }
    else {
        $(".pc").show();
    }*/
  }
});
/*
HIDE LIST
hideSupermercado
hideSupermercado_opt
hideRutas
hideAuditoria
hideEscaner
hideConversiones
hideChecadas


IP Barriles 
10.215.158.77
10.215.156.19
10.215.156.29
10.215.156.85

IP Estaciones
10.215.156.115
10.215.156.38
10.215.156.134




*/