<h1> Interface de visualisation des taches de chaque employé </h1>
<?php

foreach ( $employes as $e)
{
    echo 'Emp_'.$e['id'].' : ';
    
    foreach($e['taches'] as $t)
    {
        echo 'T'.$t['id'].' : '.$t['heureDebut'].' - '.$t['heureFin'].' , ';
    }
    echo "<br><br>";   
}
?>
<a href="<?php echo base_url(); ?>">Home</a><br><br>

