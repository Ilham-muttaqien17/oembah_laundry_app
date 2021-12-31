<?php 

require '../functions.php';

$keyword = validateData($_GET['keyword']);

$query = "SELECT * FROM tb_laundry WHERE 
                nama_laundry LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%' OR
                tipe_laundry LIKE '%$keyword%'
            ";
?>

<div id="result" class="bg-white text-dark-blue absolute rounded px-4 py-2 mt-2 text-sm shadow-md">
    <?php if(strlen($keyword) > 2) : ?>
        <?php $laundry = query($query); ?>
        <?php foreach($laundry as $row) : ?>
            <a href="detail_laundry.php?id=<?=$row['id_laundry']?>"><span id="item"><?=$row['nama_laundry'] . ", " . $row['alamat']?></span></a>
            <br>
            <hr class="my-2">
        <?php endforeach ?> 
    <?php endif ?>
</div>

