$('#user_logged').hide();
$('#salir').hide();
$('#qtyUpdateButton').hide();
$(document).ready(function(){
	
	$.ajax({
		url: 'cont/partial_discount_controller_user.php',
		type: 'GET',
		data: {request: 'getBadge'}
	})
	.done(function(data) {
		//console.log(data);
		if(data == 'error'){
			$('#modal_login').modal({
			    backdrop: 'static',
			    keyboard: false
			})
			$('#modal_login').modal('show');
		}
		else{
			$('#user_logged').val(data)
			$('#user_logged').show();
			$('#salir').show();
			$('#qtyUpdateButton').show();
		}

	})
	.fail(function() {
		//console.log("error");
	});
	
	$('#ingresar_button').on('click',function(e){
		e.preventDefault();
		var badge = $('#badge').val();
		if (badge=='') {
			new PNotify({
			    title: 'Error',
			    text: 'Ingrese un usuario valido',
			    type: 'error',
			    nonblock: {
			        nonblock: true
			    },
			    styling: 'bootstrap3'
			});
		}
		else{
			$.ajax({
				url: 'cont/partial_discount_controller_user.php',
				type: 'GET',
				data: {request: 'setBadge',
				badge: badge},
			})
			.done(function(data) {
				var info = JSON.parse(data);
				console.log(info['response']);
				if (info['response']=='success') {
					new PNotify({
					    title: 'Exito',
					    text: 'Usuario valido',
					    type: 'success',
					    nonblock: {
					        nonblock: true
					    },
					    styling: 'bootstrap3'
					});
					$('#user_logged').val(badge)
					$('#user_logged').show();
					$('#salir').show();
					$('#qtyUpdateButton').show();
					$('#modal_login').modal('hide');
					
				}
				else{
					new PNotify({
					    title: 'Error',
					    text: 'Ingrese un usuario valido',
					    type: 'error',
					    nonblock: {
					        nonblock: true
					    },
					    styling: 'bootstrap3'
					});

				}
				
			})
			.fail(function() {
				console.log("error");
				});
		}
		
	});

	$('#salir').on('click',function(e){
		e.preventDefault();
		$.ajax({
			url: 'cont/partial_discount_controller_user.php',
			type: 'GET',
			data: {request: 'delBadge'},
		})
		.done(function(info) {
			Data = JSON.parse(info);
			if (Data['response']=='success') {
				
				window.location.reload();
			}
			
			
		});
	});
	$(".input1").on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        // Do something
    }
});
/*	$('#material_sn').on('keyup',function(e){
		if (e.key === 'Enter' || e.keyCode === 13) {
			var material_sn = $('#material_sn').val().replace('S', '');
			$.ajax({
				url: 'cont/partial_discount_controller.php',
				type: 'GET',
				data: {queue: 'getMaterialPN',
						material_sn: material_sn},
			})
			.done(function(info) {
				
				try {
					var Data = JSON.parse(info);
					var qty = Math.round(Data[0].Qty);
					var PN = Data[0].PN;
					var discount = $('#material_discount').val();
					console.log(discount);
					console.log(qty);
					if(discount>qty){
						new PNotify({
							    title: 'Error',
							    text: 'No puede descontar mas de la cantidad de la serie',
							    type: 'error',
							    nonblock: {
			        				nonblock: true
			    				},
							    styling: 'bootstrap3'
							});

					}
					else{
						$('#qty_actual').val(qty.toString());
						
						Swal.fire({
						  title: "Atencion",
						  text: "Descontara "+Math.round(discount)+" pz del numero "+PN,
						  icon: "warning",
						  showCancelButton: true,
						  confirmButtonColor: "#3085d6",
						  cancelButtonColor: "#d33",
						  confirmButtonText: "Continuar"
						}).then((result) => {
						  if (result.isConfirmed) {
						    var qty_totally = qty - discount;
						    var badge = $('#user_logged').val();
						    $.ajax({
						    	url: 'cont/partial_discount_controller.php',
						    	type: 'GET',
						    	data: {	queue:'setDiscount',
						    			cantidad_descontada: qty_totally,
						    			badge : badge,
						    			material_sn:material_sn,
						    			material_pn:PN,
						    			discount: discount
						    		},
						    })
						    .done(function(info) {
						    	var Data = JSON.parse(info);
						    	if (Data['response']=='success') {
						    		var text = 'Se han descontado '+discount.toString()+'pz de la serie '+material_sn.toString();
						
									new PNotify({
										    title: 'Exito',
										    text: text,
										    type: 'success',
										    nonblock: {
			                                      nonblock: true
			                                  },
										    styling: 'bootstrap3'
										});
									console.log(Data['response']);
									$('#material_sn').val('');
									$('#material_pn').val('');
						    	}
						    	else if (Data['response']=='closed') {
						    		new PNotify({
									    title: 'Error',
									    text: 'No puede descontar de cajas cerradas o vacias',
									    type: 'error',
									    nonblock: {
			                                      nonblock: true
			                                  },
									    styling: 'bootstrap3'
									});
						    	}
						    	else{
						    		new PNotify({
									    title: 'Error',
									    text: 'Intente de nuevo',
									    type: 'error',
									    nonblock: {
			                                      nonblock: true
			                                  },
									    styling: 'bootstrap3'
									});
						    	}
						    	
						    	
							})
						    .fail(function() {
						    	new PNotify({
									    title: 'Error',
									    text: 'Intente de nuevo',
									    type: 'error',
									    styling: 'bootstrap3'
									});
						    });
						    
						   	
						    
						  }
						});
						
						
					}
					
					$('#material_pn').val(Data[0].PN);
				} catch(e) {
					// statements
					new PNotify({
						    title: 'Error',
						    text: 'Error al escanear la serie',
						    type: 'error',
						    nonblock: {
			                                      nonblock: true
			                                  },
						    styling: 'bootstrap3'
						});
				}
				
				


				

			});
		}
		
	});
*/

	$('#material_sn').on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			var idKanban = $('#material_discount').val();
			var material_sn = $('#material_sn').val();
			material_sn = material_sn.replace("3S","");
			material_sn = material_sn.replace("A","");
			material_sn = material_sn.replace("S","");
			$.ajax({
				url: 'cont/partial_discount_controller.php',
				data: {cantidad_descontada: idKanban,
                          material_sn: material_sn,
                          badge: $("#user_logged").val(),
                          queue: "setDiscount"
			},
			})
			.done(function(info) {
				var Data = JSON.parse(info);
				if (Data['response']=="NoKanban") {
					new PNotify({
	                    title: 'Error',
	                    text: 'Kanban no existe',
	                    type: 'error',
	                    nonblock: {
	                        nonblock: true
	                    },
	                    styling: 'bootstrap3'
	                });
	                $('#material_discount').val("");
	                $('#material_sn').val("");
	                $('#material_discount').focus();
				}
				else if (Data['response']=="NoSerie") {
					new PNotify({
	                    title: 'Error',
	                    text: 'Serie Invalida',
	                    type: 'error',
	                    nonblock: {
	                        nonblock: true
	                    },
	                    styling: 'bootstrap3'
	                });
	                $('#material_discount').val("");
	                $('#material_sn').val("");
	                $('#material_discount').focus();
				}
				else if (Data['response']=="NoReserva") {
					new PNotify({
	                    title: 'Error',
	                    text: 'Serie no en reserva',
	                    type: 'error',
	                    nonblock: {
	                        nonblock: true
	                    },
	                    styling: 'bootstrap3'
	                });
	                $('#material_discount').val("");
	                $('#material_sn').val("");
	                $('#material_discount').focus();
				}
				else if (Data['response']=='success') {
					new PNotify({
	                    title: 'Exito',
	                    text: 'Serie enlazada',
	                    type: 'success',
	                    nonblock: {
	                        nonblock: true
	                    },
	                    styling: 'bootstrap3'
	                });
				}
				
			})
			.fail(function() {
				new PNotify({
	                    title: 'Error',
	                    text: 'Ha ocurrido un error interno',
	                    type: 'error',
	                    nonblock: {
	                        nonblock: true
	                    },
	                    styling: 'bootstrap3'
	                });
					$('#material_discount').val("");
	                $('#material_sn').val("");
	                $('#material_discount').focus();
			})
			.always(function() {
				$('#material_discount').val("");
	            $('#material_sn').val("");
	            $('#material_discount').focus();
			});
			
			
		}
	});
	$('#material_discount').on('keyup', function (e) {
	    if (e.key === 'Enter' || e.keyCode === 13) {
	        var idKanban = $('#material_discount').val();
	        idKanban = idKanban.replace(/\D/g, ''); // Elimina caracteres no numéricos
	        idKanban = parseInt(idKanban, 10); // Convierte a número y elimina los ceros a la izquierda
	        
	        $.ajax({
	            url: 'cont/partial_discount_controller.php',
	            type: 'GET',
	            data: {
	                queue: 'getKanban',
	                idKanban: idKanban
	            },
	        })
	        .done(function (info) {
	            var Data = JSON.parse(info);
	            if (Data['response'] === 'success') {
	                // Remueve el atributo "disabled" y establece el foco en material_sn
	                $('#material_discount').val(idKanban)
	                $('#material_sn').prop('disabled', false).focus();
	            } else {
	                new PNotify({
	                    title: 'Error',
	                    text: 'Kanban no existe',
	                    type: 'error',
	                    nonblock: {
	                        nonblock: true
	                    },
	                    styling: 'bootstrap3'
	                });
	                $('#material_discount').val("")
	                $('#material_sn').prop('disabled', true);
	            }
	        })
	        .fail(function () {
	            new PNotify({
	                title: 'Error',
	                text: 'Error interno',
	                type: 'error',
	                nonblock: {
	                    nonblock: true
	                },
	                styling: 'bootstrap3'
	            });
	            $('#material_discount').val("")
	            $('#material_sn').prop('disabled', true);
	        });
	    }
	});



	$('#qtyUpdateButton').on('click',function(){
		$('#modalUpdate').modal('show');
		
	});
	$("#modalUpdate").on('show.bs.modal', function(event) {
        setTimeout(function() {
            $('#material_snQty').focus();
        }, 500);
    });

	$("#material_snQty").on('keyup', function (e) {
	    if (e.key === 'Enter' || e.keyCode === 13) {
	        $('#emptySubmit').trigger('click');
	    }
	})
    


	$("#emptySubmit").on('click', function(e) {
		e.preventDefault();
		var material_sn = $("#material_snQty").val();
		material_sn = material_sn.replace("3S","");
		material_sn = material_sn.replace("A","");
		material_sn = material_sn.replace("S","");
		var badge = $("#user_logged").val();
		$.ajax({
			url: 'cont/partial_discount_controller.php',
			data: {
				queue: 'empty',
				serialNumber: material_sn,
				badge: badge
		},
		})
		.done(function(info) {
			var Data = JSON.parse(info);
			if (Data['response']=='success') {
				new PNotify({
					title: 'Exito',
					text: 'Material vacio',
					type: 'success',
					nonblock: {
				                                      nonblock: true
				                                  },
					styling: 'bootstrap3'
				});
				$("#material_snQty").val("").focus();
			}
			else{
				console.log(Data['response'])
				new PNotify({
					title: 'Error',
					text: 'Ha ocurrido un error',
					type: 'error',
					nonblock: {
				                                      nonblock: true
				                                  },
					styling: 'bootstrap3'
				});
				$("#material_snQty").val("").focus();
			}

			
		})
		.fail(function() {
			new PNotify({
					title: 'Error',
					text: 'Ha ocurrido un error',
					type: 'error',
					nonblock: {
				                                      nonblock: true
				                                  },
					styling: 'bootstrap3'
				});
			$("#material_snQty").val("").focus();
		})
		.always(function() {
			$("#material_snQty").val("").focus();
		});
		
	});

	$("#updateQtySubmit").on('click',function(e){
		e.preventDefault();

		var materialSnQty = $('#material_snQty').val().replace('S', "");
		var new_qty = $('#new_qty').val();

		if (materialSnQty == "" || new_qty == "") {
			new PNotify({
				title: 'Error',
				text: 'Rellene los campos obligatorios',
				type: 'error',
				nonblock: {
			                                      nonblock: true
			                                  },
				styling: 'bootstrap3'
			});
		}
		else{
			var partNumber = $('#partNumber').val();
			var badge = $('#user_logged').val();
			var dato = {
				
			}
			console.log(dato)
			$.ajax({
				url: 'cont/partial_discount_controller.php',
				type: 'GET',
				data: {queue: 'setActualQty',
						sn : materialSnQty,
						new_qty : new_qty,
						partNumber : partNumber,
						badge : badge},
			})
			.done(function(info) {
				//console.log(info)
				var Datos = JSON.parse(info);

				if (Datos['response']=='success') {
					new PNotify({
					    title: 'Exito',
					    text: 'Ha actualizado la cantidad de la serie '+materialSnQty,
					    type: 'success',
					    styling: 'bootstrap3'
					});
					$('#material_snQty').val('');
					$('#new_qty').val('');
					$('#actual_qty').val('');
					$('#partNumber').val('');
				}
				else{
					new PNotify({
					    title: 'Error',
					    text: 'Ha ocurrido un error, intente de nuevo',
					    type: 'error',
					    styling: 'bootstrap3'
					});
				}

			});
			
			
		}

	});


	$("#material_snQty").on('change',function(){
		var snNumber = $("#material_snQty").val();
		snNumber = snNumber.replace("3S","");
		snNumber = snNumber.replace("A","");
		snNumber = snNumber.replace("S","");
		$.ajax({
			url: 'cont/partial_discount_controller.php',
			type: 'GET',
			data: {	queue: 'getActualQty',
					sn:snNumber},
		})
		.done(function(info) {
			var Data = JSON.parse(info);
			$("#actual_qty").val(Data[0]['Qty']);
			$("#partNumber").val(Data[0]['PN']);

			
		});
		
		
		
	});


});