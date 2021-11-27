    CREATE TABLE `db_oembah`.`tb_user` ( 
        `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
        `name_user` VARCHAR(50) NOT NULL , 
        `email` VARCHAR(100) NOT NULL , 
        `password` VARCHAR(100) NOT NULL , 
        `alamat` VARCHAR(100) NOT NULL , 
        `kontak` VARCHAR(50) NOT NULL , 
        PRIMARY KEY (`id_user`()
    ) ENGINE = InnoDB;

    CREATE TABLE `db_oembah`.`tb_laundry` ( 
        `id_laundry` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
        `nama_laundry` VARCHAR(50) NOT NULL , 
        `email` VARCHAR(100) NOT NULL , 
        `password` VARCHAR(150) NOT NULL , 
        `alamat` VARCHAR(100) NOT NULL , 
        `biaya` INT UNSIGNED NOT NULL , 
        `kontak` VARCHAR(50) NOT NULL , 
        `tipe_laundry` ENUM('Kiloan','Sepatu','Helm') NOT NULL , 
        `jam_buka` TIME NOT NULL , 
        `jam_tutup` TIME NOT NULL , 
        PRIMARY KEY (`id_laundry`)
    ) ENGINE = InnoDB;

    CREATE TABLE `db_oembah`.`tb_oembah` ( 
        `id_order` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
        `qty` SMALLINT UNSIGNED NOT NULL , 
        `status` ENUM('Waiting','Confirmed','On Process','On Delivery','Delivered') NOT NULL , 
        `tipe_antar` ENUM('Pick up','Delivery') NOT NULL , 
        `id_user` INT UNSIGNED NOT NULL , 
        `id_laundry` INT UNSIGNED NOT NULL , 
        PRIMARY KEY (`id_order`)
    ) ENGINE = InnoDB;

ALTER TABLE `tb_order` ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE; 
ALTER TABLE `tb_order` ADD CONSTRAINT `fk_laundry` FOREIGN KEY (`id_laundry`) REFERENCES `tb_laundry`(`id_laundry`) ON DELETE CASCADE ON UPDATE CASCADE;

