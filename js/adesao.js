window.addEvent('domready', function(){
	new FormCheck('frmAdesao');
	
	document.id("cctm_telefone").addEvent('keypress',function(){mascara($(this), 'telefone')}).setProperty('maxlength', '14');
	
	$('termo').addEvent('click', function(e){
		e.preventDefault();
		window.open($(this).get('href'), 'termoCondicoes',"width=600,height=450,resizable,scrollbars=yes,status=1");
	});
});


