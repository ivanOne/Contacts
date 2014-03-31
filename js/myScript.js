$(document).ready(function() {
	var link="actions/controller.php";
	
	$('#add').click(function() {
		var a=$('#group').val().length;
		if(a>0){
			var group=$('#group').val();
			$.ajax({
				type:"get",
				url:link+"?cmd=addGroup&data="+group,
				datatype:"html",
				success:function(response){
					$('#groups').append(response);
					$('#group').val("");
				},
				error:function (xhr, ajaxOptions, thrownError){
	                //выводим ошибку
	                alert(thrownError);
	            }
        	});
        }else{alert('Введите название!');}  

		
	});

	$('body').on("click",".del",function(){
		var buttonId=this.id;
		$.ajax({
			type:"get",
			url:link+"?cmd=delGroup&id="+buttonId,
			datatype:"html",
			success:function(){
			$("#c"+buttonId).fadeOut(200);	
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }

		});
				
	});

	$('body').on("click",".more",function(){
		var numberId=this.id;
		$.ajax({
			type:"get",
			url:link+"?cmd=more&id="+numberId,
			datatype:"html",
			success:function(response){
				$('#tel'+numberId).append(response);
				$('#fade'+numberId).fadeOut(1000);
			},

			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }
		});
	});

	$('#addnum').click(function(){
		$("[telnum]").mask("9(999)999-99-99");
		$.ajax({
			type:'get',
			url:link+'?cmd=addContact',
			datatype:"html",
			success:function(response){
				$("#check").append(response);
				$("#form").css('display', 'block');
				
			},

			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }

		});
	});
	var i=1;
	$('#moreinp').click(function(){	
			var input=$('<input>',{
			name:'numplus['+i+']',
			type:'text',
			class:'plus',
		});
		$('#moreinput').append(input);
		i++;
		$('#delete').css('visibility','visible');
		$('.plus').mask("9(999)999-99-99");	
	});
	$('#delete').click(function(){
		if(i>1){
			$('.plus:last').remove();
		}
	});

	$('#record').click(function(){
		var data=$('input').serialize();
		var a=$('.letter').val().length;
		var b=$('#number').val().length;
		if ((a>=2)&&(b=11)) {
			$.ajax({
				type:'get',
				url:link+'?cmd=recordContact&'+data,
				datatype:'text',
				success:function(response){
					$('.contact').append(response);
					$('#form').fadeOut(500);
					$('#check').empty();
					$('#form input').val("");

					},
					error:function (xhr, ajaxOptions, thrownError){
                	//выводим ошибку
                	alert(thrownError);
            		}

				});	
		}else{alert("ФИО должно быть больше 1 буквы");}
			});
	$('body').on('click','.delete', function(){
		var buttonId=this.id;
		$.ajax({
			type:"get",
			url:link+"?cmd=deleteContact&id="+buttonId,
			datatype:"html",

			success:function(){
				$('#it'+buttonId).fadeOut(400);
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }
        });		
	});
	$('#cancel').click(function(){
		$('#form').fadeOut(500);
		$('#check').empty();
	});

	$('.number').mask("9(999)999-99-99");

	$('body').on('click','#addList',function(){
		var data=$('input.query').serialize();
		$.ajax({
			type:"get",
			url:link+"?cmd=editGroupList&"+data,
			datatype:'html',

			success:function(response){	
				$('.list').append(response);
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }
		});	
	});
	$('body').on('click','.addGroupList', function(){
		var idGroup=this.id;
		var idCont=$('.inf').attr('value');
		$.ajax({
			url: link+'?cmd=addGroupList&id='+idGroup+'&idcon='+idCont,
			type: 'GET',
			dataType: 'html',

			success:function(response){
				$('.list').empty();
				$('.groups').append(response);
				
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }
		});

	});
	$('body').on('click','.edGroup', function(){
		var idGroup=this.id;
		var idCont=$('.inf').attr('value');
		$.ajax({
			type: 'get',
			url:link+'?cmd=delGroupList&id='+idGroup+'&idcon='+idCont,

			success:function(){
				$('.itemGroup#'+idGroup).empty();
				$('.list').empty();				
				
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }
		});
	});
	var b=0;
	$('body').on('click','#plus', function(){
		b++;
		$('.numberWrap').append("<div class='plusnum'><input class='mask' name='num["+b+"]'></div>");	
		$('.mask').mask("9(999)999-99-99");
		$('#deleteBut').css('visibility','visible');
		$('#save').css('visibility','visible');
		
	});

	$('body').on('click','#deleteBut', function(){
			$('.plusnum:last').remove();
			b--;
				if (b==0) {
					$('#deleteBut').css('visibility','hidden');
					$('#save').css('visibility','hidden');
		}	;
		});

	$('body').on('click','#save', function(){
		var idCont=$('.inf').attr('value');
		var data=$('input.mask').serialize();
		$.ajax({
			type:'get',
			url:link+'?cmd=addNumList&'+data+'&idcont='+idCont,
			dataType:'html',
			success:function(response){
				$('.numberWrap').append(response);
				$('.plusnum').empty();
				$('#deleteBut').css('visibility','hidden');
				$('#save').css('visibility','hidden');
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }

		});
	});
	$('body').on('click','.delList', function(){
		var id=this.id;
		var str='#d'+id+'';
		$.ajax({
			type:'get',
			url:link+'?cmd=delNumList&id='+id,
			dataType:'html',
			success:function(response){
				$(str).fadeOut(200);
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }

		});

	});
	$('body').on('click','.updatenum', function(){
		var id=this.id;
		var tel=$(str).val();
		$.ajax({
			type:'get',
			url:link+'?cmd=updateNum&id='+id+'&tel='+tel,
			dataType:'html',
			success:function(response){
				alert('Готово!');
				
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }

		});
	});
	$('body').on('click','#updatename', function(){
		var idCont=$('.inf').attr('value');
		var data=$('input.letter').serialize();
		$.ajax({
			type:'get',
			url:link+'?cmd=updateName&id='+idCont+'&'+data,
			dataType:'html',
			success:function(response){
				alert('Готово!');
				
			},
			error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);	
            }

		});
	});
});

