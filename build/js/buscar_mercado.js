var _0x4cf772=_0x4353;(function(_0xe2bb42,_0x2191ca){var _0x45eeba=_0x4353,_0x18714f=_0xe2bb42();while(!![]){try{var _0x475d89=parseInt(_0x45eeba(0x137))/0x1+-parseInt(_0x45eeba(0x13d))/0x2*(-parseInt(_0x45eeba(0x157))/0x3)+parseInt(_0x45eeba(0x122))/0x4+-parseInt(_0x45eeba(0x13c))/0x5+-parseInt(_0x45eeba(0x172))/0x6*(-parseInt(_0x45eeba(0x134))/0x7)+parseInt(_0x45eeba(0x113))/0x8*(-parseInt(_0x45eeba(0x15a))/0x9)+-parseInt(_0x45eeba(0x17b))/0xa;if(_0x475d89===_0x2191ca)break;else _0x18714f['push'](_0x18714f['shift']());}catch(_0x2656ad){_0x18714f['push'](_0x18714f['shift']());}}}(_0x3754,0x79ee1),$(document)[_0x4cf772(0x117)](function(){var _0x36f3eb=_0x4cf772;currentDate=moment()['format'](_0x36f3eb(0x160)),currentTime=moment()['format']('HH:mm');if(currentTime>_0x36f3eb(0x15f)&&currentTime<_0x36f3eb(0x112)){var _0x4dbeb8=_0x36f3eb(0x175),_0x5c27de=_0x36f3eb(0x163),_0x309e09='A';fecha_inicio=currentDate,fecha_fin=currentDate;var _0x353515={'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin,'turno_inicio':_0x4dbeb8,'turno_fin':_0x5c27de,'tipo_turno':_0x309e09};$[_0x36f3eb(0x156)]({'url':_0x36f3eb(0x138),'type':_0x36f3eb(0x120),'data':_0x353515})[_0x36f3eb(0x13e)](function(_0x3322bd){var _0xa6d630=_0x36f3eb;test=JSON[_0xa6d630(0x169)](_0x3322bd);if(test[_0xa6d630(0x126)][0x0][_0xa6d630(0x12e)]==0x0){}else{var _0x4f5727=$(_0xa6d630(0x142))[_0xa6d630(0x123)]({'dom':'frtlip','destroy':!![],'responsive':{'details':{'type':'column'}},'order':[[0x4,_0xa6d630(0x167)]],'language':{'url':_0xa6d630(0x115)},'buttons':[{'extend':'copy','text':'Copiar\x20al\x20portapapeles','className':'btn\x20btn-primary\x20boton-margen\x20boton-responsivo','attr':{'id':'jkjk'}},{'extend':_0xa6d630(0x16d),'text':_0xa6d630(0x140),'className':_0xa6d630(0x14e)},{'extend':'print','text':_0xa6d630(0x15b),'className':'btn\x20btn-primary\x20text-light\x20boton-margen\x20boton-responsivo'},{'extend':_0xa6d630(0x161),'text':'Generar\x20PDF','className':_0xa6d630(0x14e)}],'className':_0xa6d630(0x164),'columns':[{'data':'recibos'},{'data':'rackeo'},{'data':'contingencia'},{'data':_0xa6d630(0x153)},{'data':'fecha'}]});_0x4f5727[_0xa6d630(0x11d)]()['remove'](),Data=JSON[_0xa6d630(0x169)](_0x3322bd),_0x4f5727[_0xa6d630(0x11d)][_0xa6d630(0x119)](Data[_0xa6d630(0x126)]),totalRackeos=Data[0x0],totalContingencia=Data[0x1],totalMovimientos=Data[0x2],$('#grafico_b')['hide'](),$(_0xa6d630(0x12d))['removeClass'](),$('#grafico_a')[_0xa6d630(0x176)](_0xa6d630(0x136)),$('#grafico_a')['addClass'](_0xa6d630(0x177)),google['charts'][_0xa6d630(0x155)](_0xa6d630(0x15c),{'packages':[_0xa6d630(0x141)]}),google[_0xa6d630(0x133)]['setOnLoadCallback'](_0x49c5ca);function _0x49c5ca(){var _0x3c6218=_0xa6d630,_0xda2340={'title':_0x3c6218(0x12b)+_0x309e09,'height':0x1f4,'legend':{'position':_0x3c6218(0x116)},'annotations':{'textStyle':{'fontSize':0x14}}},_0x4efb42=new google['visualization'][(_0x3c6218(0x16b))]([[_0x3c6218(0x17a),_0x3c6218(0x11f),{'role':_0x3c6218(0x11a)},{'role':_0x3c6218(0x11b)}],[_0x3c6218(0x168),parseInt(totalRackeos),'#66ccff',totalRackeos['toString']()],['Contingencias',parseInt(totalContingencia),_0x3c6218(0x14a),totalContingencia['toString']()],[_0x3c6218(0x158),parseInt(totalMovimientos),_0x3c6218(0x11c),totalMovimientos['toString']()]]),_0x1c6f95=new google[(_0x3c6218(0x130))][(_0x3c6218(0x179))](document[_0x3c6218(0x111)](_0x3c6218(0x15e)));_0x1c6f95['draw'](_0x4efb42,_0xda2340);}}});}else{if(currentTime>_0x36f3eb(0x163)&&currentTime<_0x36f3eb(0x14d)){var _0x4dbeb8='15:36',_0x5c27de='23:59',_0x309e09='B',_0x4c9aee=new Date();_0x4c9aee[_0x36f3eb(0x127)](_0x4c9aee[_0x36f3eb(0x11e)]()+0x1);var _0x2a61df=_0x4c9aee['getFullYear'](),_0x5a4a6f=_0x4c9aee[_0x36f3eb(0x118)]()+0x1,_0x2096fe=_0x4c9aee[_0x36f3eb(0x11e)]();_0x5a4a6f=_0x5a4a6f<0xa?'0'+_0x5a4a6f:_0x5a4a6f,_0x2096fe=_0x2096fe<0xa?'0'+_0x2096fe:_0x2096fe;var _0xbb2ac4=_0x2a61df+'-'+_0x5a4a6f+'-'+_0x2096fe;formattedDate2=_0xbb2ac4,fecha_inicio=currentDate,fecha_fin=formattedDate2;var _0x353515={'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin,'turno_inicio':_0x4dbeb8,'turno_fin':_0x5c27de,'tipo_turno':_0x309e09};$['ajax']({'url':_0x36f3eb(0x138),'type':_0x36f3eb(0x120),'data':_0x353515})[_0x36f3eb(0x13e)](function(_0x154194){var _0x3ad3b5=_0x36f3eb;test=JSON[_0x3ad3b5(0x169)](_0x154194),console[_0x3ad3b5(0x12f)](JSON[_0x3ad3b5(0x169)](_0x154194));if(test['info'][0x0][_0x3ad3b5(0x12e)]==0x0){}else{$('#turno\x20option:eq(1)')[_0x3ad3b5(0x154)]('selected',!![]);var _0x8dd4b5=$('#date-mercado')[_0x3ad3b5(0x123)]({'dom':_0x3ad3b5(0x162),'destroy':!![],'legend':{'position':_0x3ad3b5(0x116)},'responsive':!![],'order':[[0x4,_0x3ad3b5(0x167)]],'language':{'url':_0x3ad3b5(0x115)},'buttons':[{'extend':_0x3ad3b5(0x147),'text':_0x3ad3b5(0x16c),'className':'btn\x20btn-primary\x20boton-margen','attr':{'id':_0x3ad3b5(0x13a)}},{'extend':'excel','text':_0x3ad3b5(0x140),'className':_0x3ad3b5(0x12c)},{'extend':_0x3ad3b5(0x114),'text':_0x3ad3b5(0x15b),'className':_0x3ad3b5(0x12c)},{'extend':'pdf','text':_0x3ad3b5(0x15d),'className':_0x3ad3b5(0x12c)}],'className':'center-block','columns':[{'data':'recibos'},{'data':_0x3ad3b5(0x12e)},{'data':'contingencia'},{'data':_0x3ad3b5(0x153)},{'data':_0x3ad3b5(0x165)}]});_0x8dd4b5['rows']()['remove'](),Data=JSON[_0x3ad3b5(0x169)](_0x154194),_0x8dd4b5[_0x3ad3b5(0x11d)][_0x3ad3b5(0x119)](Data[_0x3ad3b5(0x126)]),totalRackeos=Data[0x0],totalContingencia=Data[0x1],totalMovimientos=Data[0x2],$(_0x3ad3b5(0x148))['hide'](),$(_0x3ad3b5(0x12d))[_0x3ad3b5(0x121)](),$(_0x3ad3b5(0x12d))[_0x3ad3b5(0x176)]('col-sm-12'),$(_0x3ad3b5(0x12d))[_0x3ad3b5(0x176)](_0x3ad3b5(0x177)),google['charts']['load']('current',{'packages':['corechart']}),google['charts']['setOnLoadCallback'](_0xed4a75);function _0xed4a75(){var _0x4802b1=_0x3ad3b5,_0x341c1e={'title':_0x4802b1(0x12b)+_0x309e09,'height':0x1f4,'legend':{'position':'none'},'annotations':{'textStyle':{'fontSize':0x14}}},_0x448904=new google['visualization'][(_0x4802b1(0x16b))]([[_0x4802b1(0x17a),'Total',{'role':_0x4802b1(0x11a)},{'role':'annotation'}],[_0x4802b1(0x168),parseInt(totalRackeos),_0x4802b1(0x144),totalRackeos['toString']()],[_0x4802b1(0x171),parseInt(totalContingencia),'#33FF9B',totalContingencia[_0x4802b1(0x152)]()],['Movimientos',parseInt(totalMovimientos),_0x4802b1(0x11c),totalMovimientos[_0x4802b1(0x152)]()]]),_0x5396bf=new google[(_0x4802b1(0x130))][(_0x4802b1(0x179))](document[_0x4802b1(0x111)]('grafico_a'));_0x5396bf['draw'](_0x448904,_0x341c1e);}}});}}$(_0x36f3eb(0x139))['on'](_0x36f3eb(0x128),function(_0x5efbd0){var _0x56c8ab=_0x36f3eb;_0x5efbd0[_0x56c8ab(0x146)]();var _0xd132cf='',_0x25312b='',_0x5c31ac=$(_0x56c8ab(0x178))[_0x56c8ab(0x150)]();if(_0x5c31ac=='A')_0xd132cf=_0x56c8ab(0x175),_0x25312b=_0x56c8ab(0x163),fecha_inicio=$('#reportrange_right')['data'](_0x56c8ab(0x16f))['startDate'][_0x56c8ab(0x13b)](_0x56c8ab(0x160)),fecha_fin=$(_0x56c8ab(0x14f))[_0x56c8ab(0x131)](_0x56c8ab(0x16f))['endDate']['format'](_0x56c8ab(0x160));else{if(_0x5c31ac=='B'){_0xd132cf=_0x56c8ab(0x163),_0x25312b=_0x56c8ab(0x129);let _0x20af20=$(_0x56c8ab(0x14f))[_0x56c8ab(0x131)](_0x56c8ab(0x16f))[_0x56c8ab(0x125)]['format']('YYYY-MM-DD'),_0xa3843e=Date['parse'](_0x20af20),_0x5ec4e7=_0x4635f9(_0xa3843e[_0x56c8ab(0x118)]()+0x1);_0x5ec4e7>'12'&&(_0x5ec4e7='01');let _0x2d874f=_0x4635f9(_0xa3843e[_0x56c8ab(0x11e)]()+0x1);if(_0x5ec4e7=='04'||_0x5ec4e7=='06'||_0x5ec4e7=='09'||_0x5ec4e7=='11')_0x2d874f>'30'&&(_0x2d874f='01',_0x5ec4e7=_0x4635f9(_0xa3843e[_0x56c8ab(0x118)]()+0x2));else _0x5ec4e7=='02'?(_0x2d874f>'28'&&(_0x2d874f='01',_0x5ec4e7=_0x4635f9(_0xa3843e[_0x56c8ab(0x118)]()+0x2)),year=_0xa3843e['getFullYear'](),year%0x4==0x0&&(_0x2d874f='01',_0x5ec4e7=_0x4635f9(_0xa3843e[_0x56c8ab(0x118)]()+0x2))):_0x2d874f>'31'&&(_0x2d874f='01',_0x5ec4e7=_0x4635f9(_0xa3843e[_0x56c8ab(0x118)]()+0x2));let _0x456085=_0xa3843e['getFullYear']()+'-'+_0x5ec4e7+'-'+_0x2d874f;fecha_inicio=$(_0x56c8ab(0x14f))[_0x56c8ab(0x131)](_0x56c8ab(0x16f))[_0x56c8ab(0x14c)][_0x56c8ab(0x13b)](_0x56c8ab(0x160)),fecha_fin=_0x456085;}else _0xd132cf='06:00',_0x25312b='15:36',fecha_inicio=$(_0x56c8ab(0x14f))['data'](_0x56c8ab(0x16f))['startDate']['format'](_0x56c8ab(0x160)),fecha_fin=$(_0x56c8ab(0x14f))[_0x56c8ab(0x131)](_0x56c8ab(0x16f))[_0x56c8ab(0x125)][_0x56c8ab(0x13b)](_0x56c8ab(0x160));}var _0x1e6f09={'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin,'turno_inicio':_0xd132cf,'turno_fin':_0x25312b,'tipo_turno':_0x5c31ac};$[_0x56c8ab(0x156)]({'url':_0x56c8ab(0x138),'type':_0x56c8ab(0x120),'data':_0x1e6f09})[_0x56c8ab(0x13e)](function(_0x52f056){var _0x86d602=_0x56c8ab;test=JSON[_0x86d602(0x169)](_0x52f056);if(test[_0x86d602(0x126)][0x0][_0x86d602(0x12e)]==0x0&&test[_0x86d602(0x126)][0x0][_0x86d602(0x166)]==0x0)Swal[_0x86d602(0x173)]({'position':'center','icon':_0x86d602(0x16a),'title':_0x86d602(0x159),'showConfirmButton':![],'timer':0x5dc});else{new PNotify({'title':'Exito','text':_0x86d602(0x174)+_0x5c31ac,'type':'success','styling':_0x86d602(0x143)});var _0x13f1f4=$('#date-mercado')['DataTable']({'dom':'frtlip','destroy':!![],'responsive':!![],'order':[[0x4,'desc']],'language':{'url':_0x86d602(0x115)},'buttons':[{'extend':_0x86d602(0x147),'text':_0x86d602(0x16c),'className':_0x86d602(0x170),'attr':{'id':_0x86d602(0x13a)}},{'extend':'excel','text':_0x86d602(0x140),'className':_0x86d602(0x12c)},{'extend':_0x86d602(0x114),'text':_0x86d602(0x15b),'className':_0x86d602(0x12c)},{'extend':_0x86d602(0x161),'text':_0x86d602(0x15d),'className':_0x86d602(0x12c)}],'className':'center-block','columns':[{'data':_0x86d602(0x151)},{'data':_0x86d602(0x12e)},{'data':_0x86d602(0x166)},{'data':_0x86d602(0x153)},{'data':_0x86d602(0x165)}]});_0x13f1f4[_0x86d602(0x11d)]()['remove'](),Data=JSON[_0x86d602(0x169)](_0x52f056),_0x13f1f4[_0x86d602(0x11d)]['add'](Data[_0x86d602(0x126)]),totalRackeos=Data[0x0],totalContingencia=Data[0x1],totalMovimientos=Data[0x2];if(_0x5c31ac!=_0x86d602(0x16e)){$(_0x86d602(0x148))[_0x86d602(0x145)](),$(_0x86d602(0x12d))[_0x86d602(0x121)](),$('#grafico_a')[_0x86d602(0x176)](_0x86d602(0x136)),$(_0x86d602(0x12d))['addClass'](_0x86d602(0x177)),google[_0x86d602(0x133)][_0x86d602(0x155)](_0x86d602(0x15c),{'packages':['corechart']}),google[_0x86d602(0x133)][_0x86d602(0x132)](_0x12b9e1);function _0x12b9e1(){var _0xbbbd6b=_0x86d602,_0x322a85={'title':_0xbbbd6b(0x12b)+_0x5c31ac,'height':0x1f4,'legend':{'position':_0xbbbd6b(0x116)},'annotations':{'textStyle':{'fontSize':0x14}}},_0x112cbc=new google[(_0xbbbd6b(0x130))][(_0xbbbd6b(0x16b))]([['Accion','Total',{'role':_0xbbbd6b(0x11a)},{'role':_0xbbbd6b(0x11b)}],[_0xbbbd6b(0x168),parseInt(totalRackeos),_0xbbbd6b(0x144),totalRackeos[_0xbbbd6b(0x152)]()],[_0xbbbd6b(0x171),parseInt(totalContingencia),_0xbbbd6b(0x14a),totalContingencia[_0xbbbd6b(0x152)]()],['Movimientos',parseInt(totalMovimientos),_0xbbbd6b(0x11c),totalMovimientos[_0xbbbd6b(0x152)]()]]),_0x48ce8a=new google['visualization'][(_0xbbbd6b(0x179))](document['getElementById'](_0xbbbd6b(0x15e)));_0x48ce8a[_0xbbbd6b(0x12a)](_0x112cbc,_0x322a85);}}else{$(_0x86d602(0x12d))[_0x86d602(0x121)](),$(_0x86d602(0x12d))[_0x86d602(0x176)](_0x86d602(0x135)),$(_0x86d602(0x12d))['addClass']('col-md-6'),totalRackeosB=Data[0x3],totalContingenciaB=Data[0x4],totalMovimientosB=Data[0x5],google['charts'][_0x86d602(0x155)](_0x86d602(0x15c),{'packages':[_0x86d602(0x141)]}),google[_0x86d602(0x133)][_0x86d602(0x132)](_0x560563);function _0x560563(){var _0x337227=_0x86d602,_0x7f3f1c={'title':_0x337227(0x14b),'height':0x1f4,'legend':{'position':_0x337227(0x116)},'annotations':{'textStyle':{'fontSize':0x14}}},_0x45f65b=new google[(_0x337227(0x130))][(_0x337227(0x16b))]([[_0x337227(0x17a),'Total',{'role':_0x337227(0x11a)},{'role':_0x337227(0x11b)}],[_0x337227(0x168),parseInt(totalRackeos),_0x337227(0x144),totalRackeos[_0x337227(0x152)]()],[_0x337227(0x171),parseInt(totalContingencia),_0x337227(0x14a),totalContingencia['toString']()],[_0x337227(0x158),parseInt(totalMovimientos),'#AFFF33',totalMovimientos[_0x337227(0x152)]()]]),_0x22a26f=new google[(_0x337227(0x130))][(_0x337227(0x179))](document[_0x337227(0x111)](_0x337227(0x15e)));_0x22a26f['draw'](_0x45f65b,_0x7f3f1c);}google['charts']['load'](_0x86d602(0x15c),{'packages':[_0x86d602(0x141)]}),google[_0x86d602(0x133)][_0x86d602(0x132)](_0x2366b8);function _0x2366b8(){var _0x5082a2=_0x86d602,_0x14343a={'title':_0x5082a2(0x13f),'height':0x1f4,'legend':{'position':_0x5082a2(0x116)},'annotations':{'textStyle':{'fontSize':0x14}}},_0x369923=new google['visualization']['arrayToDataTable']([[_0x5082a2(0x17a),_0x5082a2(0x11f),{'role':_0x5082a2(0x11a)},{'role':'annotation'}],['Rackeos',parseInt(totalRackeosB),_0x5082a2(0x144),totalRackeosB['toString']()],[_0x5082a2(0x171),parseInt(totalContingenciaB),'#33FF9B',totalContingenciaB[_0x5082a2(0x152)]()],[_0x5082a2(0x158),parseInt(totalMovimientosB),_0x5082a2(0x11c),totalMovimientosB[_0x5082a2(0x152)]()]]),_0x585415=new google[(_0x5082a2(0x130))]['ColumnChart'](document[_0x5082a2(0x111)](_0x5082a2(0x149)));_0x585415[_0x5082a2(0x12a)](_0x369923,_0x14343a);}$(_0x86d602(0x148))[_0x86d602(0x124)]();}}});});function _0x4635f9(_0x444ec5){return _0x444ec5<0xa?'0'+_0x444ec5:_0x444ec5;}}));function _0x4353(_0x4c7a3b,_0x3bba5c){var _0x37545e=_0x3754();return _0x4353=function(_0x4353b4,_0x1d488a){_0x4353b4=_0x4353b4-0x111;var _0x7d79e4=_0x37545e[_0x4353b4];return _0x7d79e4;},_0x4353(_0x4c7a3b,_0x3bba5c);}function _0x3754(){var _0x559c98=['startDate','23:59','btn\x20btn-primary\x20text-light\x20boton-margen\x20boton-responsivo','#reportrange_right','val','recibos','toString','total','prop','load','ajax','1717269ZTWKtA','Movimientos','No\x20se\x20encontró\x20información\x20de\x20este\x20día','5157wmKrAw','Imprimir\x20documento','current','Generar\x20PDF','grafico_a','05:59','YYYY-MM-DD','pdf','frtlip','15:36','center-block','fecha','contingencia','desc','Rackeos','parse','error','arrayToDataTable','Copiar\x20al\x20portapapeles','excel','Comparativo','daterangepicker','btn\x20btn-primary\x20boton-margen','Contingencias','161754uIccGv','fire','Informacion\x20actualizada\x20turno\x20','06:00','addClass','col-md-12','#turno','ColumnChart','Accion','4367480ZQvpMN','getElementById','15:37','11288dJIzKb','print','http://10.215.156.203/materiales/rutas/build/traduccion.json','none','ready','getMonth','add','style','annotation','#AFFF33','rows','getDate','Total','GET','removeClass','3852780ZqbFDF','DataTable','show','endDate','info','setDate','click','00:10','draw','SPMKT\x20Turno\x20','btn\x20btn-primary\x20text-light\x20boton-margen','#grafico_a','rackeo','log','visualization','data','setOnLoadCallback','charts','154ZIVlhR','col-sm-6','col-sm-12','103404TcNuGU','cont/ver_mercado.php','#buscar_mercado','jkjk','format','2437220BNZhzL','2UjjfmM','done','SPMKT\x20Turno\x20B','Generar\x20excel','corechart','#date-mercado','bootstrap3','#66ccff','hide','preventDefault','copy','#grafico_b','grafico_b','#33FF9B','SPMKT\x20Turno\x20A'];_0x3754=function(){return _0x559c98;};return _0x3754();}