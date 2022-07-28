<?php
/**
* Автор: Алексей Сушкевич
*
* Дата реализации: 28.07.2022 10:00
*
* Дата изменения: 28.07.2022 15:00
*
* Общий файл с остальным кодом для подключения других файлов */

    require_once('person.php');
    require_once('people.php');

    $sqlTable = "CREATE TABLE `database_name`.`People` 
                ( `Id` INT(11) NOT NULL AUTO_INCREMENT , 
                `Name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
                `Surname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
                `Birthday` DATE NULL , `Birthplace` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
                `Gender` BOOLEAN NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;";


    function getConnect(){
        $connectionDb =  mysqli_connect('localhost','root', null,'database_name');
        if(!$connectionDb){
            die('Could not connect: ' . mysqli_connect_error());
        }else{
            return $connectionDb;
        }
    }

    function getArrayIdsAsStr($ids){
        $idsStr = '';
        foreach($ids as $id){
            $idsStr.= '\''. $id . '\'' . ', ';
        }
        $idsStr = substr($idsStr, 0, -2);
        return $idsStr;
    }
