<?php

/** @property TachesModel $TachesModel
  

/**
 * Description of Taches
 *
 * @author adminSio
 */
class Taches extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->Model('TachesModel');
    }

    public function index($orderby=NULL) {
        if($orderby=='libelle')
        {
            $all_taches = $this->TachesModel->get_tache_orderby_libelle();
            //preparer données pour la vue
            $data = array();
            $data['title'] = "au boulot!";
            $data['taches'] = $all_taches;
            // generer la vue et lui transmettre les données
            $this->load->view('TachesIndex', $data);
        }
        else if($orderby=='heureDebut'){
            $all_taches = $this->TachesModel->get_tache_orderby_heureDebut();
            $data = array();
            $data['title'] = "au boulot!";
            $data['taches'] = $all_taches;
            $this->load->view('TachesIndex', $data);
        }
        else if($orderby=='heureFin'){
            $all_taches = $this->TachesModel->get_tache_orderby_heureFin();
            $data = array();
            $data['title'] = "au boulot!";
            $data['taches'] = $all_taches;
            $this->load->view('TachesIndex', $data);
        }
        else{
            $all_taches = $this->TachesModel->get_all_taches();
            $data = array();
            $data['title'] = "au boulot!";
            $data['taches'] = $all_taches;
            $this->load->view('TachesIndex', $data);
        }
    }
    
     public function affectation() {
        $this->load->library('form_validation');
        LoadValidationRules($this->TachesModel, $this->form_validation);
        
        if ($this->form_validation->run() == TRUE) {
            //succès ok !!!
            //on recupere l'objet tache en question avec son id
            $idTache = $this->input->post('Tache');
            $tache = $this->TachesModel->get_tache_by_id($idTache);
            // on recupere les heure de debut et de fin de la tache en question
            $hDebut = $tache['heureDebut'];
            $hFin = $tache['heureFin'];
            $duree = $tache['duree'];
            //on recupere les taches de l'employe en question
            $idEmploye = $this->input->post('Employe');
            $taches = $this->TachesModel->get_taches_by_employe($idEmploye);
            
            $count =0;
            foreach ($taches as $t) {
                //on test les cas ou la tache en question va empieter sur la tache T parcouru de l'employe 
                if(($hDebut >= $t['heureDebut']&& $hDebut < $t['heureFin'])OR ($hFin >$t['heureDebut'] && $hFin<=$t['heureFin'])){
                    redirect('Taches/erreur/1');
                }
                else {
                // dans le cas contraire on additionne les durées des taches parcourus pour savoir le total d'heures de travail de l'employe
                $count = $count+$t['duree'];
                }
            }
            // si on est deja a 8h ou + ou bien si on les dépasse avec la nouvelle tache selectionnée
            if(($count>=8) or (($count+$duree)>8)){
                redirect('Taches/erreur/2');
            }
            // si la tache selectionnée dépasse la journée J
            
            else{
            
            $params = array('idEmploye' => $idEmploye,
                            'idTache' => $idTache
            );
            $this->TachesModel->add_tache_employe($params);
            redirect('Taches/index');
            }
        } 
        else {
            //pas de validation ko! on recharge la vue
            $employes = $this->TachesModel->get_employes();
            $cbProperties = array( 
                'selectName' => 'Employe',
                'selectedAttributName' => 'id',
                'selectedValue' => $this->input->post('Employe'),
                'optionAttributesNames' => array('nom'),
                'options' => $employes,
                'selectMessage' => 'sélectionnez un employé',
                'emptyMessage' => 'aucun employe à sélectionner'
            );
            
            $this->load->library('ComboBox', $cbProperties, 'cbEmployes');
            $data['comboBoxEmployes'] = $this->cbEmployes; 
            
            $taches = $this->TachesModel->get_all_taches();
            $cbProperties = array( 
                'selectName' => 'Tache',
                'selectedAttributName' => 'id',
                'selectedValue' => $this->input->post('Tache'),
                'optionAttributesNames' => array('libelle'),
                'options' => $taches,
                'selectMessage' => 'sélectionnez une tache',
                'emptyMessage' => 'aucune tache à sélectionner'
            );
            
            $this->load->library('ComboBox', $cbProperties, 'cbTaches');
            $data['comboBoxTaches'] = $this->cbTaches; 
            
            $this->load->view('TacheAffectation',$data);
            }
     }
     
     public function erreur($id){
         if($id==1){
             $data['message']= 'la tache selectionnée ne peut pas être affectée à l employé car une autre tâche se trouve dans la tranche horaire';
         }
         elseif ($id==2) {
             $data['message']= 'la charge quotidienne de travail de 8h a été atteinte, impossible de lui affecter une nouvelle tache';  
         }
         else{
             $data['message']= 'vous ne pouvez pas affecter une tache qui dont la durée s étend au jour suivant';
         }
         
         $this->load->view('ErreurAffectation',$data);
     }


     public function planning() {
        
       $employes = $this->TachesModel->get_employes();
       
       foreach ($employes as $i=>$e) {
           $taches = $this->TachesModel->get_taches_by_employe($e['id']);
           //on stocke les tache de l'employe
           $employes[$i]['taches']=$taches;
       }
       $data['employes'] = $employes;
       $this->load->view('PlanningIndex',$data);
       
     }
     

    
    
    public function delete($id) {
        $this->TachesModel->delete_tache_from_repartition($id);
        $this->TachesModel->delete($id);
        $this->load->helper('url');
        redirect('Taches/index');
    }

    public function add() {
        $this->load->library('form_validation');
        LoadValidationRules($this->TachesModel, $this->form_validation);
        

        if ($this->form_validation->run() == TRUE) {
            //succès ok !!!
            $hDebut = $this->input->post('hDebut');
            $hFin = $this->input->post('hFin');
            if($hDebut>$hFin){
                redirect('Taches/erreur/3');
            }
            $duree = $hFin - $hDebut;
                       
                $params = array('libelle' => $this->input->post('Tache'),
                            'heureDebut' => $hDebut,
                            'heureFin' => $hFin,
                            'duree' => $duree
                );
                $this->TachesModel->add($params);
                redirect('Taches/index');
        } else {
            //pas de validation ko! on recharge la vue
            
            //je recupere mes heures que j'ai stocké dans une table
            $heures = $this->TachesModel->get_heures();
          
            $cbProperties = array( 
                'selectName' => 'hDebut',
                'selectedAttributName' => 'heure',
                'selectedValue' => $this->input->post('hDebut'),
                'optionAttributesNames' => array('heure'),
                'options' => $heures,
                'selectMessage' => 'sélectionnez une heure',
                'emptyMessage' => 'aucune heure à sélectionner'
            );
            $this->load->library('ComboBox', $cbProperties, 'cbHeuresDebut');
            $data['comboBoxHeuresDebut'] = $this->cbHeuresDebut; 
            
            $cbProperties = array( 
                'selectName' => 'hFin',
                'selectedAttributName' => 'heure',
                'selectedValue' => $this->input->post('hFin'),
                'optionAttributesNames' => array('heure'),
                'options' => $heures,
                'selectMessage' => 'sélectionnez une heure',
                'emptyMessage' => 'aucune heure à sélectionner'
            );
            
            $this->load->library('ComboBox', $cbProperties, 'cbHeuresFin');
            $data['comboBoxHeuresFin'] = $this->cbHeuresFin; 
            
            $employes = $this->TachesModel->get_employes();
            $cbProperties = array( 
                'selectName' => 'idEmploye',
                'selectedAttributName' => 'id',
                'selectedValue' => $this->input->post('idEmploye'),
                'optionAttributesNames' => array('nom'),
                'options' => $employes,
                'selectMessage' => 'sélectionnez une heure',
                'emptyMessage' => 'aucune heure à sélectionner'
            );
            
            $this->load->library('ComboBox', $cbProperties, 'cbEmployes');
            $data['comboBoxEmployes'] = $this->cbEmployes; 
            
            $this->load->view('TacheAdd',$data);
        }
    }

}
