<?php

namespace Controller;

class CommandeController extends Controller{

  public $id_commande;

  public function adminCommande(){

    // tester si je suis admin
    if(isset($_SESSION['membre']) && $_SESSION['membre']->isAdmin()){
      $params['title'] = 'Admin Commandes';
      $params['commandes'] = $this->getModel()->getallDetailsCommandes();
      foreach($params['commandes'] as $ligne){
        echo $ligne['id_commande'].'<br />';
      $params['details_commandes'][$ligne['id_commande']]  =  $this->getModel()->getDetailsMyCommandes($ligne['id_commande']);
      }

      return $this->render('layout.html','adminCommande.html',$params);
    }
    else{
      $this->redirect($this->url . 'membre/connexion');
    }
  }

  public function changeStatut($idPlusStatut){
    if( isset($_SESSION['membre']) && $_SESSION['membre']->isAdmin() ){
      $tab= explode("-", $idPlusStatut);
      switch($tab[1]){
        case 2 : $statut='Envoyé';break;
        case 3 : $statut='Livré';break;
        default : $statut='en cours de traitement';break;
      }
      $this->getModel()->update($tab[0],array('etat'=>$statut));
      $this->redirect($this->url . 'commande/adminCommande');
    }
    else{
      $this->redirect($this->url . 'membre/connexion');
    }
  }

  public function afficheDetailsCommande($id){

if(!empty($id)){

    $params['details_commande'] = $this->getModel()->getDetails($id);
      $params['title'] = 'Détail de ma commande';
      $params['commande'] = $this->getModel()->getMyCommande($id);
      return $this->render('layout.html','detailscommande.html',$params);
  }}
  public function afficheCommande(){

      if(isset($_POST['validerpanier'])){
        $this->validationCommande();
      }

      $params['title'] = 'Mes Commandes';
      $params['commandes'] = $this->getModel()->getMesCommandes();
      return $this->render('layout.html','commande.html',$params);
  }

  public function validationCommande(){
    // panier devient une commande
    if(isset($_SESSION['panier'])){
      // insertion de la commande
      $montant = 0;
      for($i=0; $i<count($_SESSION['panier']['id_produit']);$i++){
        $montant += $_SESSION['panier']['prix'][$i] * $_SESSION['panier']['quantite'][$i];
      }
      $infos = array(
        'id_membre' => $_SESSION['membre']->getField('id_membre'),
        'montant' => $montant,
        'date_enregistrement' => date('Y-m-d H:i:s'),
        'etat' => 'en cours de traitement'
      );
      $this->id_commande = $this->getModel()->registerCommande($infos);
      $membre = new Model/Membre;
      $_SESSION['membre']->setField('experience',$montant+$_SESSION['membre']->getField('experience'));
      $membre->update(array('experience'=>$_SESSION['membre']->getField('experience')));

      // insertion des détails de la commande
      for($i=0; $i<count($_SESSION['panier']['id_produit']);$i++){
        $details = array(
          'id_commande' => $this->id_commande,
          'id_produit' => $_SESSION['panier']['id_produit'][$i],
          'quantite' =>$_SESSION['panier']['quantite'][$i],
          'prix' => $_SESSION['panier']['prix'][$i]
        );
        $this->getModel()->registerDetails($details);
      }
      // faire appel aux méthodes liées au produit
      $this->redirect($this->url.'produit/majStocks');

    }
  }

}
