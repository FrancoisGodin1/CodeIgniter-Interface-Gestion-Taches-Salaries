<?php echo validation_errors(); 
echo form_open('Taches/affectation'); ?>

<a href="<?php echo base_url(); ?>">Home</a><br><br>

<?php if(isset($message)){
    echo $message;
    }?>
<div>
    
    Selectionnez l'employé : <?php $comboBoxEmployes->Render(); ?><br><br>
    
    Tache: <?php $comboBoxTaches->Render(); ?><br><br>
    
</div>

<button type="submit">Save</button>
<?php echo form_close();?>

