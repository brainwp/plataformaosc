<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

get_header();

get_template_part('title', 'page');

$instituicoes = get_signatarios('institu');
$outros = get_signatarios(false, 'institu');

//$tipos = tipos_signatarios();

global $post;
?>
<script>
jQuery.fn.pager = function(clas, options) {
	
	var settings = {		
		navId: 'nav',
		navClass: 'nav',
		navAttach: 'append',
		highlightClass: 'highlight',
		prevText: '&laquo;',
		nextText: '&raquo;',
		linkText: null,
		linkWrap: null,
		height: null
	}
	if(options) jQuery.extend(settings, options);
	
		
	return this.each( function () {
		
		var me = jQuery(this);
		var size;
	  	var i = 0;		
		var navid = '#'+settings.navId;
		
		function init () {
			size = jQuery(clas, me).not(navid).size();
			if(settings.height == null) {			
				settings.height = getHighest();
			}
			if(size > 1) {
				makeNav();
				show();
				highlight();
			}			
			sizePanel();
			if(settings.linkWrap != null) {
				linkWrap();
			}
		}
		function makeNav () {		
			var str = '<div id="'+settings.navId+'" class="'+settings.navClass+'">';
			str += '<a href="#" rel="prev">'+settings.prevText+'</a>';
			for(var i = 0; i < size; i++) {
				var j = i+1;
				str += '<a href="#" rel="'+j+'">';
				str += (settings.linkText == null) ? j : settings.linkText[j-1];				
				str += '</a>';
			}
			str += '<a href="#" rel="next">'+settings.nextText+'</a>';
			str += '</div>';
			switch (settings.navAttach) {		
				case 'before':
					jQuery(me).before(str);
					break;
				case 'after':		
					jQuery(me).after(str);
					break;
				case 'prepend':
					jQuery(me).prepend(str);
					break;
				default:
					jQuery(me).append(str);
					break;
			}
		}
		function show () {
			jQuery(me).find(clas).not(navid).hide();
			var show = jQuery(me).find(clas).not(navid).get(i);
			jQuery(show).show();
		}		
		function highlight () {
			jQuery(me).find(navid).find('a').removeClass(settings.highlightClass);
			var show = jQuery(me).find(navid).find('a').get(i+1);			
			jQuery(show).addClass(settings.highlightClass);
		}

		function sizePanel () {
			if(jQuery.browser.msie) {
				jQuery(me).find(clas).not(navid).css( {
					height: settings.height
				});	
			} else {
				jQuery(me).find(clas).not(navid).css( {
					minHeight: settings.height
				});
			}
		}
		function getHighest () {
			var highest = 0;
			jQuery(me).find(clas).not(navid).each(function () {
				
				if(this.offsetHeight > highest) {
					highest = this.offsetHeight;
				}
			});
			highest = highest + "px";
			return highest;
		}
		function getNavHeight () {
			var nav = jQuery(navid).get(0);
			return nav.offsetHeight;
		}
		function linkWrap () {
			jQuery(me).find(navid).find("a").wrap(settings.linkWrap);
		}
		init();
		jQuery(this).find(navid).find("a").click(function () {

			if(jQuery(this).attr('rel') == 'next') {
				if(i + 1 < size) {
					i = i+1;
				}
			} else if(jQuery(this).attr('rel') == 'prev') { 
				if(i > 0) {	
					i = i-1;
				}
			} else {		
				var j = jQuery(this).attr('rel');	
				i = j-1;		
			}
			show();
			highlight();
			return false;
		});
	});	
}
</script>

	<h2 class="title-signatarios"><?php echo $post->post_title ?></h2>

	<p>&nbsp;</p>
	
	<div class="sidea">
		<h4>Redes, Fóruns e Articulações <?php /*?><?php echo implode(',', $tipos['outros']) ?><?php */?></h4>
		
		<?php if($outros): $total = 0; $j=0; ?>
		<div id="listOutros">
			<?php foreach( $outros as $o => $i ): ?>
				<?php if ( ($o%15)==0 ) { echo "<div id='unid2_{$total}' class='page_content2'>"; $j = 1; $total++; } ?>
				<p><?php echo $i->post_title; ?></p>
				<?php if ( $j==15 || $o == count($outros)-1 ) { echo "</div>"; } ?>
				<?php if ( $j>0 && $j<=15 ) { $j++; } else { $j=0; } ?>
			<?php endforeach; ?>
		</div>
			<?php if ( count($outros) > 15 ): ?> 
				<!-- div id="paginacao-outros">
					<a href="#" id="voltar2">Voltar</a>
					<a href="#" id="avancar2">Avan&ccedil;ar</a>
				</div -->
				
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("#listOutros").pager("div");
					});
					
					/*
					var ini = 0,
						max = <?php //echo $total ?>;
					
					jQuery(document).ready(function($){
						function show2( indice ) {
							$('.page_content2').css('display','none');
							$('#unid2_'+indice).css('display','block');

							ini = indice;
						}
						
						jQuery('#voltar2').click('click', function(e){
							e.preventDefault();
							if ( ini > 0 ) show2(ini-1)
						});
						
						jQuery('#avancar2').live('click', function(e){
							e.preventDefault();
							if ( ini < max - 1 ) show2(ini+1);
						});
						
						show2( ini );
					});
					*/
				</script>
			<?php endif; ?>
		<?php else: ?>
		<p>Não encontrados</p>
		<?php endif; ?>
	</div>

	<div class="sideb">
		<h4>Organizações <?php /*?><?php echo $tipos['instituicoes'] ?><?php */?></h4>
		
		<?php if($instituicoes): $total = 0; $j=0; ?>
		<div id="listInst">
			<?php foreach( $instituicoes as $o => $i ): ?>
				<?php if ( ($o%15)==0 ) { echo "<div id='unid_{$total}' style='display:none;' class='page_content'>"; $j = 1; $total++; } ?>
				<p><?php echo $i->post_title; ?></p>
				<?php if ( $j==15 || $o == count($instituicoes)-1 ) { echo "</div>"; } ?>
				<?php if ( $j>0 && $j<=15 ) { $j++; } else { $j=0; } ?>
			<?php endforeach; ?>
		</div>
			
			<?php if ( count($instituicoes) > 15 ): ?> 
				<!-- div id="paginacao">
					<a href="#" id="voltar">Voltar</a>
					<a href="#" id="avancar">Avan&ccedil;ar</a>
				</div-->
				
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("#listInst").pager("div");
					});
					
					/*
					var ini = 0,
						max = <?php //echo $total ?>;
					
					jQuery(document).ready(function($){
						function show( indice ) {
							$('.page_content').css('display','none');
							$('#unid_'+indice).css('display','block');

							ini = indice;
						}
						
						jQuery('#voltar').click('click', function(e){
							e.preventDefault();
							if ( ini > 0 ) show(ini-1)
						});
						
						jQuery('#avancar').live('click', function(e){
							e.preventDefault();
							if ( ini < max - 1 ) show(ini+1);
						});
						
						show( ini );
					});
					*/
				</script>
			<?php endif; ?>
		<?php else: ?>
		<p>Não encontrados</p>
		<?php endif; ?>
	</div>
<?php
get_footer();
?>
