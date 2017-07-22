<?php echo validation_errors(); 
echo form_open('Taches/add'); ?>

<a href="<?php echo base_url(); ?>">Home</a><br><br>

<div>
    Tache : <input type="text" name="Tache" value="<?php echo $this->input->post('Tache'); ?>"/><br><br>
    
    heure de début : <?php $comboBoxHeuresDebut->Render(); ?><br><br>
    
    heure de fin: <?php $comboBoxHeuresFin->Render(); ?><br><br>
    
</div>

<button type="submit">Save</button>
<?php echo form_close();?>


