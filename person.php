<?php
/*
* Автор: Алексей Сушкевич
*
* Дата реализации: 27.07.2022 12:00
*
* Дата изменения: 27.07.2022 19:00
*
* Содержит класс Person 
*/
class Person{
    /*
    * Класс Person
    * Создает экземпляр объекта Person в People BD и содержит методы для работы с экземпляром Person класса
    */
    public $id, $name, $surname, $birthday, $gender, $birthplace;

    function __construct($id, $name, $surname, $birthday, $gender, $birthplace){
        if($id == null){
            $connectionDb =  getConnect();
            $result = mysqli_query($connectionDb, "INSERT INTO `People` (`Id`, `Name`, `Surname`, `Birthday`, `Gender`, `Birthplace`) 
                                                   VALUES (null, '$name', '$surname', '$birthday', '$gender', '$birthplace')");
            if(!$result){
                die(mysqli_error($connectionDb));
            }
            $last_id = mysqli_insert_id($connectionDb);
            $this->id = $last_id;
            $this->name = $name;
            $this->surname = $surname;
            $this->birthday = $birthday;
            $this->gender = $gender;
            $this->birthplace = $birthplace;
            mysqli_close($connectionDb);
        }else{
            $connectionDb =  getConnect();
            $result = mysqli_query($connectionDb, "SELECT * FROM `People` WHERE `Id` = $id");
            if(!$result){
                die(mysqli_error($connectionDb));
            }
            $record = mysqli_fetch_assoc($result);
            $this->id = $record['Id'];
            $this->name = $record['Name'];
            $this->surname = $record['Surname'];
            $this->birthday = $record['Birthday'];
            $this->gender = $record['Gender'];
            $this->birthplace = $record['Birthplace'];
            mysqli_close($connectionDb);
        }
    }

    public function save(){
        $connectionDb = getConnect();
        $result = mysqli_query($connectionDb, "SELECT * FROM `People` WHERE `Id` = $this->id");
        if(!$result){
            die(mysqli_error($connectionDb));
        }
        $record = mysqli_fetch_assoc($result);
        $sql = "UPDATE `people` SET ";
        $update = false;
        if($record['name'] != $this->name){
            $sql .= "`Name`= '$this->name', ";
            $update = true;
        }
        if($record['surname'] != $this->surname){
            $sql .= "`Surname`= '$this->surname', ";
            $update = true;
        }
        if($record['birthday'] != $this->birthday){
            $sql .= "`Birthday`= '$this->birthday', ";
            $update = true;
        }
        if($record['gender'] != $this->gender){
            $sql .= "`Gender`= '$this->gender', ";
            $update = true;
        }
        if($record['birthplace'] != $this->birthplace){
            $sql .= "`Birthplace`= '$this->birthplace', ";
            $update = true;
        }
        if($update){
            $sql = substr($sql, 0, -2);
            $sql .= " WHERE `Id` = '$this->id'";
            mysqli_query($connectionDb, $sql);
            echo $sql;
        }
        mysqli_close($connectionDb);
    }

    public function remove(){
        $connectionDb = getConnect();
        $result = mysqli_query($connectionDb, "DELETE FROM `People` WHERE `Id` = $this->id");
        if(!$result){
            die(mysqli_error($connectionDb));
        }
        mysqli_close($connectionDb);
    }

    public static function getAge($date) {
        $interval = date_create('now')->diff(new DateTime($date));
        return $interval -> y;
    }

    public static function getGender($gender){
        if($gender == 1){
            return 'Man';
        }else{
            return 'Woman';
        }
    }

    public function formatPerson($formatAge, $formatGender){
        $obj = new stdClass();
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->surname = $this->surname;
        $obj->birthplace = $this->birthplace;
        if($formatAge){
            $obj->age = $this->getAge($this->birthday);
        }else{
            $obj->birthday = $this->birthday;
        }
        if($formatGender){
            $obj->gender = $this->getGender($this->gender);
        }else{
            $obj->gender = $this->gender;
        }
        return $obj;
    }
}
