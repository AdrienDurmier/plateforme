<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\Produit;

class LoadProduit extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $produit1 = new Produit();
    $produit1->setMarque($this->getReference('marque_1'));
    $produit1->setTitre('Star Wars 75105 Millennium Falcon');
    $produit1->setContenu("<p>Légo sort le vaisseau phare du Réveil de la Force de Star Wars épisode 7,  le Lego Star Wars 75105 Millennium Falcon par excellence pour tous les fans de Han Solo, Rey et Finn.</p><p>Pour revivre les aventures formidables et épiques de la rébellion avec le Lego Star Wars 75105 Millennium Falcon</p><p>Avec la nouvelle version du Falcon Millennium, Légo permet à votre chérubin d'imaginer et d'inventer les aventures de Rey, Finn et Han solo à la recherche de Luke Skywalker. Les plus grands pourront retomber en enfance et revivre les épisodes précédents. Le vaisseau emblématique permet des heures de construction et de jeu pour petits et grands.</p><p>Le Faucon Millenium de l'épisode 7 est fourni avec six figurines : Rey, Han Solo, Finn, Chewbacca, BB8, Tasu Leech et un personnage du gang du Kanjiklub. Les armes sont fournies avec le vaisseau telles qu'une arbalète, un blaster.  Le vaisseau est composé d'un cockpit, un jeu d'holo-échecs et de cachettes pour les armes.</p><p>Cet article est conseillé aux enfants dès 9 ans. Surveillez les enfants en bas âge à proximité du jeu de construction. La présence d'un adulte est conseillée en raison des pièces de petite taille.</p>");
    $produit1->setPrix('189.99');
    $produit1->setImage($this->getReference('image_1'));
    $produit1->setTva($this->getReference('tva1'));
    $produit1->setStock(50);
    $produit1->setPoids(1.800);
    $manager->persist($produit1);
    
    $produit2 = new Produit();
    $produit2->setMarque($this->getReference('marque_1'));
    $produit2->setTitre('La caserne des pompiers');
    $produit2->setContenu("<p>Pour tous les enfants de plus de six ans, ce kit  Lego city 60110 casern pompier est une aventure formidable : celle de secourir les personnages, d'intervenir à l'aide du camion et de l'hélicoptère !</p><p>Un héros en herbe avec le Lego city 60110 casern pompier !</p><p>Dans ce jeu complet, vous retrouverez six figurines de pompiers, un vendeur de hot dog avec son petit chien, une caserne qui comprend deux garages, des voitures, une plate forme élévatrice ainsi que de nombreux accessoires ! Avec une telle caserne, votre enfant pourra réagir efficacement en cas de demande d'intervention dans sa ville ou dans son jeu ! Il convient à la fois aux garçons et aux filles et comme tous les jeux de construction et de simulation, il est idéal pour stimuler l'imagination, créer des histoires, appliquer des scénarios et pour donner vie à des personnages fictifs ! Les pompiers ont toujours fascine les enfants : vous pouvez ici leur donner l'occasion d'incarner des héros du quotidien pour leurs séances de jeu ! Ils peuvent y jouer seul ou avec leurs amis : aventures et sauvetages garantis ! </p>");
    $produit2->setPrix('94.99');
    $produit2->setImage($this->getReference('image_2'));
    $produit2->setTva($this->getReference('tva2'));
    $produit2->setStock(250);
    $produit2->setPoids(2.450);
    $manager->persist($produit2);
    
    $produit3 = new Produit();
    $produit3->setMarque($this->getReference('marque_2'));
    $produit3->setTitre('Sam le Pompier - Caserne de pompier Pontypandy');
    $produit3->setContenu("<p>Une caserne de pompiers avec sons et lumières pour un univers miniature complet à l'image de Sam le pompier ! Ce jouet aux fonctions multiples sera idéal pour occuper et amuser..</p>");
    $produit3->setPrix('59.99');
    $produit3->setImage($this->getReference('image_3'));
    $produit3->setTva($this->getReference('tva2'));
    $produit3->setStock(4);
    $produit3->setPoids(2.450);
    $manager->persist($produit3);
    
    $produit4 = new Produit();
    $produit4->setMarque($this->getReference('marque_3'));
    $produit4->addCategory($this->getReference('categorie_basket'));
    $produit4->setTitre('Converse All Star Ox Classic Baskets Enfant');
    $produit4->setContenu("<ul><li>Dessus: lin</li><li>Doublure: lin</li><li>Matériau de semelle: Caoutchouc</li><li>Fermeture: Lacets</li></ul>");
    $produit4->setPrix('39.40');
    $produit4->setImage($this->getReference('image_4'));
    $produit4->setTva($this->getReference('tva2'));
    $produit4->setStock(15);
    $produit4->setPoids(0.250);
    $manager->persist($produit4);
    
    $manager->flush();
    
    $this->addReference('produit_1', $produit1);
    $this->addReference('produit_2', $produit2);
    $this->addReference('produit_3', $produit3);
    $this->addReference('produit_4', $produit4);
  }
  
  public function getOrder() {
    return 3;  // Order in which this fixture will be executed
  }
}