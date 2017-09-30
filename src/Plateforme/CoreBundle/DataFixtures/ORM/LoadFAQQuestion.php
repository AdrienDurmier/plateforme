<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\FAQQuestion;

class LoadFAQQuestion extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Page FAQ
    $page_faq = $manager->getRepository('PlateformeCoreBundle:PageFAQ')->findOneByRepere('faq');
    // Categories
    $categorie_technique = $manager->getRepository('PlateformeCoreBundle:FAQCategorie')->findOneByCle('technique');
    $categorie_vitres_tactiles = $manager->getRepository('PlateformeCoreBundle:FAQCategorie')->findOneByCle('vitres_tactiles');
    $categorie_livraison_et_suivi = $manager->getRepository('PlateformeCoreBundle:FAQCategorie')->findOneByCle('livraison_et_suivi');
    $categorie_remboursements_et_avoirs = $manager->getRepository('PlateformeCoreBundle:FAQCategorie')->findOneByCle('remboursements_et_avoirs');
    
    // Question 1
    $faq_question = new FAQQuestion();
    $faq_question->setPageFAQ($page_faq);
    $faq_question->setFAQCategorie($categorie_technique);
    $faq_question->setQuestion("Demande de renseignements techniques");
    $faq_question->setReponse("<p>Pour toute demande de renseignements technique, utiliser le formulaire de contact, donnez nous un maximum d'&eacute;lements (symptomes, tests effectu&eacute;s, photos&hellip;) et nous vous aiderons dans la limite de ce qui peut etre fait sans voir la machine.</p>");
    $faq_question->setWeight(0);
    $faq_question->setPublished(true);
    $manager->persist($faq_question);
    
    // Question 2
    $faq_question2 = new FAQQuestion();
    $faq_question2->setPageFAQ($page_faq);
    $faq_question2->setFAQCategorie($categorie_vitres_tactiles);
    $faq_question2->setQuestion("Comment choisir la bonne vitre ?");
    $faq_question2->setReponse("<p>C&#39;est assez &eacute;tonnant, mais peu importe la marque ou la r&eacute;f&eacute;rence de votre tablette !<br />Ces marques sont g&eacute;n&eacute;riques et la m&ecirc;me r&eacute;f&eacute;rence de tablette&nbsp; peut contenir une vitre tr&egrave;s diff&eacute;rente d&#39;une autre.</p><p>Voici comment ne pas se tromper :</p><ol>	<li>regardez notre video pour ouvrir correctement votre tablette.</li>	<li>d&eacute;montez le capot arri&egrave;re pour acceder &agrave; l&#39;int&eacute;rieur de la tablette.</li>	<li>rep&eacute;rez le cable souple (nappe) qui relie la vitre &agrave; la carte &eacute;lectronique et notez toutes les r&eacute;f&eacute;rence qui y sont inscrites ( sauf celle qui repr&eacute;sente une date) Ne confondez pas les &quot;O&quot; avec&nbsp; les &quot;0&quot;.</li>	<li>entrez ces informations dans la zone de recherche du site, en haut &agrave; gauche, sous notre logo.</li>	<li>si la recherche ne donne rien, contactez nous avec le formulaire, envoyez nous la r&eacute;f&eacute;rence que vous avez not&eacute;, et la taille de la tablette.</li></ol><p>Si la recherche est fructueuse, allez dans la fiche du produit et comparez les dimensions de votre vitre avec celles propos&eacute;es sur le site. ATTENTION : ne mesurez que la vitre, en retranchant le cadre plastique qui n&#39;est pas inclus dans le produit</p>");
    $faq_question2->setWeight(0);
    $faq_question2->setPublished(true);
    $manager->persist($faq_question2);
    
    // Question 3
    $faq_question3 = new FAQQuestion();
    $faq_question3->setPageFAQ($page_faq);
    $faq_question3->setFAQCategorie($categorie_vitres_tactiles);
    $faq_question3->setQuestion("Je ne me sens pas assez bricoleur...");
    $faq_question3->setReponse("<p>Vous avez regard&eacute; notre video sur le d&eacute;montage d&#39;une tablette, mais cela vous semble difficile &agrave; r&eacute;aliser ?<br />Aucun probl&egrave;me ! Envoyez nous votre tablette, nous ferons le travail pour vous. Un forfait de 20 euro TTC de main d&#39;oeuvre, incluant une r&eacute;vision et tests divers s&#39;ajoutera au prix de la vitre &agrave; remplacer.<br />N&#39;oubliez pas de joindre le chargeur et de nous donner le mot de passe ou le sch&eacute;ma de verrouillage ainsi que vos coordonn&eacute;es e-mail et t&eacute;l&eacute;phoniques.</p>");
    $faq_question3->setWeight(0);
    $faq_question3->setPublished(true);
    $manager->persist($faq_question3);
    
    // Question 4
    $faq_question4 = new FAQQuestion();
    $faq_question4->setPageFAQ($page_faq);
    $faq_question4->setFAQCategorie($categorie_vitres_tactiles);
    $faq_question4->setQuestion("Comment tester ma vitre à réception du colis ?");
    $faq_question4->setReponse("<p>Avant m&ecirc;me, le d&eacute;ballage, v&eacute;rifiez que vous avez re&ccedil;u le bon produit : Les vitres sont thermo-film&eacute;es pour permettre un examen visuel pr&eacute;alable. V&eacute;rifiez &eacute;galement que la vitre n'est ni bris&eacute;e, ni fendue.<br />Si tout va bien, ouvrez le film de protection&nbsp; et d&eacute;ballez la vitre.<br />N'enlevez pas les plastiques de protection recto et verso, ni les pellicules recouvrant l'adh&eacute;sif double face si il est pr&eacute;sent.<br />Pr&eacute;sentez la vitre sur celle qui est bris&eacute;e pour confirmer que la taille, la position de la nappe et les r&eacute;f&eacute;rences sont les m&ecirc;mes.<br />Branchez la vitre sans la coller et faites les tests sur toute la surface de la tablette, en mode portrait et en mode paysage.<br />Quand vous &ecirc;tes absolument sur du bon fonctionnement, retirez les films et protections et collez la vitre sur la tablette.</p>");
    $faq_question4->setWeight(0);
    $faq_question4->setPublished(true);
    $manager->persist($faq_question4);
    
    // Question 5
    $faq_question5 = new FAQQuestion();
    $faq_question5->setPageFAQ($page_faq);
    $faq_question5->setFAQCategorie($categorie_vitres_tactiles);
    $faq_question5->setQuestion("Ma vitre a été livrée sans autocollants, comment faire ?");
    $faq_question5->setReponse("<p>Certaines vitres sont livr&eacute;es sans les autocollants double face qui permettent de la fixer. Sur certaines tables (ARCHOS ou BOULANGER par exemple) les vitres sont coll&eacute;es &agrave; la glue, ce qui ne facilite pas le d&eacute;pannage !<br />Dans le descriptif de chaque vitre sur notre site, il est pr&eacute;cis&eacute; si elle est livr&eacute;e avec ou sans autocollants.<br />Nous vous conseillons fortement de ne pas coller la vitre, car vous auriez du mal &agrave; la d&eacute;coller sans casse ult&eacute;rieurement. Dans certains cas, la Glue ou colle au Cyanure d&eacute;colore le plastique de fa&ccedil;on irr&eacute;m&eacute;diable.<br />Les autocollants en largeur de 3 ou 5 mm sont vendues sur le site. Vous pouvez &eacute;galement en trouver facilement en papeterie.</p>");
    $faq_question5->setWeight(0);
    $faq_question5->setPublished(true);
    $manager->persist($faq_question5);
    
    // Question 6
    $faq_question6 = new FAQQuestion();
    $faq_question6->setPageFAQ($page_faq);
    $faq_question6->setFAQCategorie($categorie_vitres_tactiles);
    $faq_question6->setQuestion("La vitre achetée fonctionne mal. Que faire ?");
    $faq_question6->setReponse("<p>Vous avez branch&eacute; la vitre est vous constatez que le fonctionnement n'est pas satisfaisant :</p><ul><li>le tactile n'est pas fonctionnel</li><li>le tactile est invers&eacute;</li><li>le tactile est d&eacute;cal&eacute;</li><li>une zone n'est pas tactile</li></ul><p>Le plus souvent, cela veut dire que malgr&eacute; votre recherche, vous n'avez pas choisi le bon mod&egrave;le.<br />Contactez nous pour la proc&eacute;dure de retour (voir FAQ Retours) mais assurez vous bien que votre vitre d'origine est exactement la m&ecirc;me que celle command&eacute;e. Si c'est le cas, notre vitre est sans doute d&eacute;fectueuse, elle vous sera &eacute;chang&eacute;e sans frais.</p>");
    $faq_question6->setWeight(0);
    $faq_question6->setPublished(true);
    $manager->persist($faq_question6);
    
    // Question 7
    $faq_question7 = new FAQQuestion();
    $faq_question7->setPageFAQ($page_faq);
    $faq_question7->setFAQCategorie($categorie_vitres_tactiles);
    $faq_question7->setQuestion("J'ai acheté la mauvaise vitre. Que faire ?");
    $faq_question7->setReponse("<p>Malgr&eacute; tous nos conseils, vous avez achet&eacute; la mauvaise vitre ? Ce n'est pas grave, Vous pouvez nous la retourner et obtenir un remboursement. Voir le chapitre retour pour avoir toutes les infos</p>");
    $faq_question7->setWeight(0);
    $faq_question7->setPublished(true);
    $manager->persist($faq_question7);
    
    // Question 8
    $faq_question8 = new FAQQuestion();
    $faq_question8->setPageFAQ($page_faq);
    $faq_question8->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question8->setQuestion("Que signifie une commande en \"attente fournisseur\" ?");
    $faq_question8->setReponse("<p>Le statut \"attente fournisseur\" d\'une commande indique simplement que vous avez command&eacute; un produit qui se trouve chez un de nos fournisseurs et qui ne vous sera exp&eacute;di&eacute; que lorsque nous le r&eacute;ceptionnerons dans nos locaux. <br /><br />Cas n&deg;1 : En stock chez le fabricant :<br /><br />Lors de votre commande, vous avez ajout&eacute; dans votre panier un produit \"En stock chez le fabricant\" et avez &eacute;t&eacute; invit&eacute; par une fen&ecirc;tre pop-up &agrave; accepter ou non un d&eacute;lai de livraison sup&eacute;rieur &agrave; notre d&eacute;lai habituel.<br />Ce d&eacute;lai est indicatif car nous sommes tributaires du fournisseur.&nbsp; Nous indiquons un d&eacute;lai moyen, bas&eacute; sur les derni&egrave;res livraisons.<br /><br />Cas n&deg;2 : Sur commande uniquement :<br /><br />dans ce cas, vous avez command&eacute; un produit que nous ne suivons pas de fa&ccedil;on r&eacute;guli&egrave;re. Une commande sp&eacute;cifique sera pass&eacute;e pour votre besoin. Cette commande ne sera pas annulable ou remboursable, sauf si le fournisseur est dans l'incapacit&eacute; de livrer le produit.</p>");
    $faq_question8->setWeight(0);
    $faq_question8->setPublished(true);
    $manager->persist($faq_question8);
    
    // Question 9
    $faq_question9 = new FAQQuestion();
    $faq_question9->setPageFAQ($page_faq);
    $faq_question9->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question9->setQuestion("Puis-je changer l'adresse de livraison ?");
    $faq_question9->setReponse("<p>Th&eacute;oriquement : non !<br />Vous disposez dans votre espace client d'un carnet de 99 adresses de livraison possibles pour vous faire livrer &agrave; diff&eacute;rents endroits.<br />Si vous faites une erreur, vous pouvez nous contacter pendant le d&eacute;lai de pr&eacute;paration de votre commande. Pour cela utilisez notre formulaire de contact.<br />cependant, le process de gestion des commandes est automatis&eacute; pour exp&eacute;dier le plus vite possible.<br />Une fois l'&eacute;tiquette d'envoi imprim&eacute;e, toute modification est impossible.</p>");
    $faq_question9->setWeight(0);
    $faq_question9->setPublished(true);
    $manager->persist($faq_question9);
    
    // Question 10
    $faq_question10 = new FAQQuestion();
    $faq_question10->setPageFAQ($page_faq);
    $faq_question10->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question10->setQuestion("Mon colis est perdu. A qui m'adresser ?");
    $faq_question10->setReponse("<p>Vous pouvez contacter le transporteur pour affiner la recherche.<br />Cependant, seul l'exp&eacute;diteur est habilit&eacute; &agrave; faire une r&eacute;clamation aupr&egrave;s du transporteur.<br />Prenez rapidement contact avec nous, en sp&eacute;cifiant votre num&eacute;ro de commande. Il se peut que le num&eacute;ro de colis soit erron&eacute; ou que le flashage du transporteur n'ai pas eu lieu.<br />Nous avons des logiciels sp&eacute;cifiques pour retrouver la trace d'un colis &eacute;gar&eacute;.<br />Si le colis n'est pas retrouv&eacute; au bout de 6 jours ouvrables, nous remplacerons automatiquement ce dernier par une 2&deg; exp&eacute;dition, dans la limite du stock disponible.</p>");
    $faq_question10->setWeight(0);
    $faq_question10->setPublished(true);
    $manager->persist($faq_question10);
    
    // Question 11
    $faq_question11 = new FAQQuestion();
    $faq_question11->setPageFAQ($page_faq);
    $faq_question11->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question11->setQuestion("Mon colis arrive abimé. Que faire ?");
    $faq_question11->setReponse("<p>Nos colis sont tous envoy&eacute;s dans des emballages neufs, en recommand&eacute; avec remise contre signature.<br />Si votre colis est abim&eacute;, vous pouvez accepter ou refuser la livraison, en fonction de l'&eacute;tat physique de l'emballage.<br />Si vous le refusez, vous devez imp&eacute;rativement nous contacter pour nous signaler l'incident.<br />Si vous acceptez le colis et que vous constatez des d&eacute;g&acirc;ts :<br />Prenez contact avec nous rapidement et envoyez nous 3 photos montrant :</p><ul><li>le colis abim&eacute; avec son &eacute;tiquette lisible</li><li>l'int&eacute;rieur du colis avec calage et protection</li><li>le produit abim&eacute;</li></ul>");
    $faq_question11->setWeight(0);
    $faq_question11->setPublished(true);
    $manager->persist($faq_question11);
    
    // Question 12
    $faq_question12 = new FAQQuestion();
    $faq_question12->setPageFAQ($page_faq);
    $faq_question12->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question12->setQuestion("Quels sont les délais de livraison ?");
    $faq_question12->setReponse("<p>Les d&eacute;lais de livraison sont variables en fonction du transporteur que vous avez choisi et du mode de livraison : Domicile ou Point Relais. Les d&eacute;lais sont indicatifs et ind&eacute;pendants de notre volont&eacute;. Notre responsabilit&eacute; ne peut &ecirc;tre engag&eacute;e sur ce point.<br />Toutes les informations concernant les d&eacute;lais de livraisons sont disponibles ici : <a title=\"http://www.micropuces.com/shipping.php\" href=\"http://www.micropuces.com/shipping.php\" target=\"_self\">http://www.micropuces.com/shipping.php</a></p>");
    $faq_question12->setWeight(0);
    $faq_question12->setPublished(true);
    $manager->persist($faq_question12);
    
    // Question 13
    $faq_question13 = new FAQQuestion();
    $faq_question13->setPageFAQ($page_faq);
    $faq_question13->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question13->setQuestion("Comment suivre mon colis ?");
    $faq_question13->setReponse("<p>Un courriel d'exp&eacute;dition vous est envoy&eacute; avec le num&eacute;ro de suivi de votre colis.<br />Si vous avez pass&eacute; votre commande sur le site, vous pouvez aussi retrouver ce num&eacute;ro dans la partie \"Mes commandes\" de votre compte personnel : <a title=\"http://www.micropuces.com/account_history.php\" href=\"http://www.micropuces.com/account_history.php\" target=\"_self\">http://www.micropuces.com/account_history.php</a><br />Si vous avez pass&eacute; commande sur une place de march&eacute; (ebay, C-Discount, Amazon) vous retrouverez ces informations dans votre espace client de la place de march&eacute;.<br /><br />Connectez vous sur le site du transporteur pour acc&eacute;der aux informations de suivi.<br />ATTENTION : les informations sont disponibles &agrave; chaque fois que le colis est flash&eacute; pendant son voyage. Une recherche trop pr&eacute;coce ne donnera rien, il est pr&eacute;f&eacute;rable d'attendre 24 heures.<br />Pour suivre un colis Mondial Relay, vous devez saisir le num&eacute;ro du colis et le code postal du relais, qui peut &ecirc;tre diff&eacute;rent du votre.</p>");
    $faq_question13->setWeight(0);
    $faq_question13->setPublished(true);
    $manager->persist($faq_question13);
    
    // Question 14
    $faq_question14 = new FAQQuestion();
    $faq_question14->setPageFAQ($page_faq);
    $faq_question14->setFAQCategorie($categorie_livraison_et_suivi);
    $faq_question14->setQuestion("Quel est le coût des frais de livraison ?");
    $faq_question14->setReponse("<p>Toutes les informations concernant les frais de livraison sont disponibles ici : <a title=\"http://www.micropuces.com/shipping.php\" href=\"http://www.micropuces.com/shipping.php\" target=\"_self\">http://www.micropuces.com/shipping.php</a><br />Ces informations sont modifiables sans pr&eacute;avis.</p>");
    $faq_question14->setWeight(0);
    $faq_question14->setPublished(true);
    $manager->persist($faq_question14);
    
    // Question 15
    $faq_question15 = new FAQQuestion();
    $faq_question15->setPageFAQ($page_faq);
    $faq_question15->setFAQCategorie($categorie_remboursements_et_avoirs);
    $faq_question15->setQuestion("Comment vais-je être remboursé ?");
    $faq_question15->setReponse("<p>Vous vous etes tromp&eacute; ?<br />Vous avez chang&eacute; d'avis ?<br /><br />Nous remboursons le produit ainsi que les frais de port aller &agrave; r&eacute;ception du colis. Cela vous permet de commander le bon produit sans attendre.<br /><br />Si vous &ecirc;tes un particulier, le remboursement se fera par le m&ecirc;me mode que le paiement. (re cr&eacute;dit de carte bancaire ou Paypal, ch&egrave;que en cas d'un paiement par virement.)<br /><br />Si vous &ecirc;tes un professionnel inscrit sur notre site, le remboursement sera un code d'avoir &agrave; utiliser sur une prochaine commande.<br /><br />Si vous avez fait votre achat via une place de march&eacute;, vous serez rembours&eacute; par cette place de march&eacute; (Discount, Ebay, Amazon etc..)</p>");
    $faq_question15->setWeight(0);
    $faq_question15->setPublished(true);
    $manager->persist($faq_question15);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}