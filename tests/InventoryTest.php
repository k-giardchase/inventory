<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Inventory.php";

    $DB = new PDO('pgsql:host=localhost;dbname=inventory_test');

    class InventoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Inventory::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "pencil";
            $description = "ticonderoga pencil";
            $keep = 1;
            $id = null;
            $test_inventory = new Inventory($name, $description, $keep, $id);

            //Act
            $test_inventory->save();

            //Assert
            $result = Inventory::getAll();
            $this->assertEquals($test_inventory, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "pencil";
            $description = "ticonderoga pencil";
            $keep = 0;
            $id = null;
            $test_inventory = new Inventory($name, $description, $keep, $id);
            $test_inventory->save();

            $name2 = "puppy";
            $description2 = "my dog";
            $keep2 = 0;
            $id2 = null;
            $test_inventory2 = new Inventory($name2, $description2, $keep2, $id2);
            $test_inventory2->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([$test_inventory, $test_inventory2], $result);
        }

        function test_deleteAll()
        {
            $name = "pencil";
            $description = "ticonderoga pencil";
            $keep = 0;
            $id = null;
            $test_inventory = new Inventory($name, $description, $keep, $id);
            $test_inventory->save();

            $name2 = "puppy";
            $description2 = "my dog";
            $keep2 = 0;
            $id2 = null;
            $test_inventory2 = new Inventory($name2, $description2, $keep2, $id2);
            $test_inventory2->save();

            //Act
            Inventory::deleteAll();

            //Assert
            $result = Inventory::getAll();
            $this->assertEquals([], $result);
        }
    }

?>
