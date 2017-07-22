<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?> </title>
    </head>
    <body>
        <div class="container">
            <h1> Interface de visualisation des taches </h1>
            <a href="<?php echo site_url('Taches/index/libelle') ?>">Ordonner par libelle</a> - 
            <a href="<?php echo site_url('Taches/index/heureDebut') ?>">Ordonner par heure de début</a> - 
            <a href="<?php echo site_url('Taches/index/heureFin') ?>">Ordonner par heure de fin</a>
            <table border="1">
                <tr>
                    <td>id</td>
                    <td>libelle</td>
                    <td>heure de début</td>
                    <td>heure de fin</td>
                    
                    <td>#</td>
                    
                    
                </tr>
                <?php foreach ($taches as $t): ?>
                    <tr>
                        <td><?php echo $t['id'];?></td>
                        
                            <td><?php echo $t['libelle']; ?></td>
                            <td><?php echo $t['heureDebut'];?></td>
                            <td><?php echo $t['heureFin'];?></td> 
                            <td><a href="<?php echo site_url('Taches/delete/'.$t['id']); ?>">delete</a></td><br>                    
                    </tr>
                <?php endforeach; ?> 
            </table>
        </div><br><br>  
        <li><a href="<?php echo site_url('Taches/add') ?>">Ajouter tache</a></li>
        <li><a href="<?php echo site_url('Taches/affectation') ?>">Affecter une tache à un employé</a></li>
        <li><a href="<?php echo site_url('Taches/planning') ?>">Visualiser le planning</a></li>
    </body>
</html>



