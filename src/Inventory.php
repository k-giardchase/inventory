<?php

    class Inventory
    {
        private $name;
        private $description;
        private $keep;
        private $id;

        function __construct($name, $description = "", $keep = 1, $id = null)
        {
            $this->name = $name;
            $this->description = $description;
            $this->keep = $keep;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function setKeep($new_keep)
        {
            $this->keep = (boolean) $new_keep;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function getName()
        {
            return $this->name;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getKeep()
        {
            return $this->keep;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO things (name, description, keep) VALUES ('{$this->getName()}', '{$this->getDescription()}', '{$this->getKeep()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);

        }

        static function getAll()
        {
            $returned_inventory = $GLOBALS['DB']->query("SELECT * FROM things;");
            $inventory = array();

            foreach($returned_inventory as $item){
                $name = $item['name'];
                $description = $item['description'];
                $keep = $item['keep'];
                $id = $item['id'];
                $new_item = new Inventory($name, $description, $keep, $id);
                array_push($inventory, $new_item);
            }
            return $inventory;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM things *;");
        }


    }

 ?>
