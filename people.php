<?php
/*
* Автор: Алексей Сушкевич
*
* Дата реализации: 27.07.2022 15:00
*
* Дата изменения: 28.07.2022 15:00
*
* Содержит класс People 
*/
if (!class_exists('Person')) {
    die('Class Person is not exist');
}
class People{
    /*
    * Класс People
    * Принимает рейнж айпи и возвращает или удаляет экземпляры Person класса из People DB
    */
    public $ids = array();

    function __construct($id, $comparison){
        $connectionDb =  getConnect();
        $result = mysqli_query($connectionDb, "SELECT * FROM `People` WHERE `Id` $comparison $id");
        if(!$result){
            die(mysqli_error($connectionDb));
        }
        while($record = mysqli_fetch_assoc($result)){
            array_push($this->ids, $record['Id']);
        }
        mysqli_close($connectionDb);
    }

    public function getPeople(){
        $connectionDb =  getConnect();
        $result = mysqli_query($connectionDb, "SELECT * FROM `People` WHERE `Id` IN (".getArrayIdsAsStr($this->ids).")");
        if(!$result){
            die(mysqli_error($connectionDb));
        }
        $people = array();
        while($record = mysqli_fetch_assoc($result)){
            array_push($people, new Person($record['Id'], $record['Name'], $record['Surname'], $record['Birthday'], $record['Gender'], $record['Birthplace']));
        }
        mysqli_close($connectionDb);
        return $people;
    }

    public function deletePeople(){
        $connectionDb =  getConnect();
        $result = mysqli_query($connectionDb, "DELETE FROM `People` WHERE `Id` IN (".getArrayIdsAsStr($this->ids).")");
        if(!$result){
            die(mysqli_error($connectionDb));
        }
        mysqli_close($connectionDb);
    }
}