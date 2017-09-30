/**
 * Scripts de la plateforme
 * @author Adrien Durmier
 */

// API pour gérer le chargement des imports et exports
var ApiAjax = {
	// Envoie les données du formulaire sur l'action d'import ou d'export (traitement long), on affiche le résultat au fur et à mesure
	start : function(form){
		var confirm_msg = $(form).attr('data-confirm');
		if (confirm_msg){
			var confirmation = confirm(confirm_msg);
			if (!confirmation)
			{
				return false;
			}
		}
		// Cache le bouton "Lancer" et affiche le bouton "Annuler"
		$('#lancer').hide();
		$('#annuler').show();
		// Créer un élément de type iframe + un div et rediriger la requête vers cet élément
		$('#resultat').html('');
		$('#resultat').append('<iframe name="iframe_ajax" id="iframe_ajax" style="display:none;" />');
		$('#resultat').append('<div id="div_ajax">Chargement du fichier en cours...</div>');
		$(form).attr('target','iframe_ajax');
    return true;
	},
	// Annule l'import en cours
	stop : function(){
		// Stoppe la requête
		if(navigator.appName == "Microsoft Internet Explorer"){
			window.document.execCommand('Stop');
		}else{
			window.stop();
		}
		// Cache le bouton "Annuler" et affiche le bouton "Lancer"
		$('#lancer').show();
		$('#annuler').hide();
		// Vider le div#resultat
		$('#resultat').html('');
	},
	// Affiche le résultat final
	show : function(data){
		$('#div_ajax').html(data);
	},
	// Trier un tableau
	tri : function(th){
		var ancien_tri = $('#filtre_tri').val();
		var ancien_sens = $('#filtre_sens').val();
		var nouveau_tri = $(th).attr('data-tri');
		var nouveau_sens = (ancien_sens=='desc' || ancien_tri!=nouveau_tri) ? 'asc' : 'desc';
		$('#filtre_tri').val(nouveau_tri);
		$('#filtre_sens').val(nouveau_sens);
		document.forms[0].onsubmit();
	}
}