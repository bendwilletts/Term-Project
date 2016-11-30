<?php
require_once '/home/benwilletts/workspace/FoodTruckManagement/persistence/PersistenceFoodTruckManager.php';
require_once '/home/benwilletts/workspace/FoodTruckManagement/model/Employee.php';
require_once '/home/benwilletts/workspace/FoodTruckManagement/model/StaffManager.php';

class PersistenceFoodTruckManagerTest extends PHPUnit_Framework_TestCase{
	protected $pm;
		
	protected function setUp(){
		$this->pm = new PersistenceFoodTruckManager();
	}
	
	protected function tearDown(){
		
	}
	
	public function testPersistence(){
		//1. Create Data
		$sm = StaffManager::getInstance();
		$staff = new Employee("Bob", "Chef", "40");
		$sm->addEmployee($staff);
		
		//Writing Data
		$this->pm->writeDataToStore($sm);
		
		//clear data
		$sm->delete();
		$this->assertEquals(0, count($sm->getEmployees()));
		
		//load data in
		$sm = $this->pm->loadDataFromStore();
		
		//Check loaded data
		$this->assertEquals(1, count($sm->getEmployees()));
		$myEmployee = $sm->getEmployee_index(0);
		$this->assertEquals("Bob", $myEmployee->getStaffName());
		$this->assertEquals("Chef", $myEmployee->getStaffRoles());
		$this->assertEquals("40", $myEmployee->getHours());
	}
}