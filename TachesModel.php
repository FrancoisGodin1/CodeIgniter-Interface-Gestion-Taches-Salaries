<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TachesModel
 *
 * @author adminSio
 */
class TachesModel extends CI_Model {
    
    public $ValidationRules=array(
        array('field'=>'Tache','label'=>'Tache','rules'=>'required|max_length[255]'),
       
    );

    function __construct() {
        parent::__construct();
    }

    function get_taches_by_idEmploye($idEmploye) {
        return $this->db->get_where('Repartition',array('idEmploye'=>$idEmploye))->row_array();
    }
    

    function get_all_taches() {
        
        return $this->db->order_by('id','asc')->get('Tache')->result_array();
    }
    
    function get_taches_by_employe($idEmploye){
        $this->db->select();
        $this->db->from('tache');
        $this->db->join('repartition', 'tache.id = repartition.idTache');
        $this->db->where('idEmploye',$idEmploye);
        return  $this->db->get()->result_array();
    }
    
    function get_tache_by_id($id){
        return $this->db->get_where('tache',array('id'=>$id))->row_array();
    }
    
    function get_tache_orderby_libelle() {
        return $this->db->order_by('libelle','asc')->get('Tache')->result_array();     
    }
    
    function get_tache_orderby_heureDebut() {
        return $this->db->order_by('heureDebut','asc')->get('Tache')->result_array();     
    }
    
    function get_tache_orderby_heureFin() {
        return $this->db->order_by('heureFin','asc')->get('Tache')->result_array();     
    }
    
    function get_employes() {
        
        return $this->db->get('employe')->result_array();
    }
    
    function get_heures() {
        
        return $this->db->get('heures')->result_array();
    }

    function add($params) {
        $this->db->insert('Tache',$params);
        return $this->db->insert_id();
    }
    
    function add_tache_employe($params) {
        $this->db->insert('repartition',$params);
        return $this->db->insert_id();
    }
    

    function update($id,$params) {
        $this->db->where('id',$id);
        $this->db->update('Tache',$params);
    }

    function delete($id) {
        $this->db->delete('Tache',array('id'=>$id));
    }
    
    function delete_tache_from_repartition($id){
        $this->db->delete('Repartition',array('idTache'=>$id));
    }
            
    function count(){
        
    }

    //put your code here
}