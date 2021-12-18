<?php 
require '../functions.php';

$keyword = $_GET['keyword'];

$query = "SELECT * FROM tb_laundry WHERE 
                nama_laundry LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%' OR
                tipe_laundry LIKE '%$keyword%'
            ";
?>


<div id="container" class="">
    <?php if(strlen($keyword) > 0) : ?>
        <?php $laundry = query($query); ?>
        <?php foreach($laundry as $row) : ?>
            <a href="detail_laundry.php?id=<?=$row['id_laundry']?>"><span id="item"><?=$row['nama_laundry'] . ", " . $row['alamat']?></span></a><br>
        <?php endforeach ?> 
    <?php endif ?>
</div>

