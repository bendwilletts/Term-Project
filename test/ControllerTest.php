<?php
require_once 'C:\Users\Ben Willetts\workspace\FoodTruckManagement\controller\Controller.php';
require_once 'C:\Users\Ben Willetts\workspace\FoodTruckManagement\persistence\PersistenceFoodTruckManager.php';
require_once 'C:\Users\Ben Willetts\workspace\FoodTruckManagement\model\Schedule.php';
require_once 'C:\Users\Ben Willetts\workspace\FoodTruckManagement\model\StaffManager.php';
require_once 'C:\Users\Ben Willetts\workspace\FoodTruckManagement\model\Employee.php';
require_once 'C:\Users\Ben Willetts\workspace\FoodTruckManagement\model\ScheduleRegistration.php';

class ControllerTest extends PHPUnit_Framework_TestCase
{
    protected $c;
    protected $pm;
    protected $sm;

    protected function setUp()
    {
        $this->c = new Controller();
        $this->pm = new PersistenceFoodTruckManager();
        $this->sm = $this->pm->loadDataFromStore();
        $this->sm->delete();
        $this->pm->writeDataToStore($this->sm);
    }

    protected function tearDown()
    {
    }

    public function testCreateEmployee() {
        $this->assertEquals(0, count($this->sm->getEmployees()));
    
    	$name = "Bob";
    	$role = "Chef";
    	$hours = "40";
    
    	try {
    		$this->c->createEmployee($name, $role, $hours);
    	} catch (Exception $e) {
    		// check that no error occurred
    		$this->fail();
    	}
    
    	// check file contents
    	$this->sm = $this->pm->loadDataFromStore();
    	$this->assertEquals(1, count($this->sm->getEmployees()));
    	$this->assertEquals($name, $this->sm->getEmployee_index(0)->getStaffName());
    	$this->assertEquals($role, $this->sm->getEmployee_index(0)->getStaffRoles());
    	$this->assertEquals($hours, $this->sm->getEmployee_index(0)->getHours());
    }
    
    public function testcreateEmployeeNull() {
        $this->assertEquals(0, count($this->sm->getEmployees()));
    
    	$name = null;
    	$role = null;
    	$hours = null;
    
    	$error = "";
    	try {
    		$this->c->createEmployee($name,$role,$hours);
    	} catch (Exception $e) {
			$error = $e->getMessage();
    	}
    
    	// check error
    	$this->assertEquals("Employee name cannot be empty! Employee role must be specified correctly! Employee hours must be specified correctly!", $error);
        // check file contents
    	$this->sm = $this->pm->loadDataFromStore();
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    }
    
    public function testcreateEmployeeEmpty() {
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    
    	$name = "";
    	$role = "";
    	$hours = "";
    
    	$error = "";
    	try {
    		$this->c->createEmployee($name, $role, $hours);
    	} catch (Exception $e) {
    		$error = $e->getMessage();
    	}
    
    	// check error
    	$this->assertEquals("Employee name cannot be empty! Employee role must be specified correctly! Employee hours must be specified correctly!", $error);
    	// check file contents
    	$this->sm = $this->pm->loadDataFromStore();
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    }
    
    public function testcreateEmployeeSpaces() {
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    
    	$name = " ";
    	$role = " ";
    	$hours = " ";
    
    	$error = "";
    	try {
    		$this->c->createEmployee($name, $role, $hours);
    	} catch (Exception $e) {
    		$error = $e->getMessage();
    	}
    
    	// check error
    	$this->assertEquals("Employee name cannot be empty! Employee role must be specified correctly! Employee hours must be specified correctly!", $error);
    	// check file contents
    	$this->sm = $this->pm->loadDataFromStore();
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    }
    public function testcreateEmployeeWrongRole() {
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    
    	$name = "Bob";
    	$role = "Driver";
    	$hours = "40";
    
    	$error = "";
    	try {
    		$this->c->createEmployee($name, $role, $hours);
    	} catch (Exception $e) {
    		$error = $e->getMessage();
    	}
    
    	// check error
    	$this->assertEquals("Employee role should be a Chef or Cashier!", $error);
    	// check file contents
    	$this->sm = $this->pm->loadDataFromStore();
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    }    
    public function testcreateEmployeeOverHours() {
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    
    	$name = "Bob";
    	$role = "Chef";
    	$hours = "41";
    
    	$error = "";
    	try {
    		$this->c->createEmployee($name, $role, $hours);
    	} catch (Exception $e) {
    		$error = $e->getMessage();
    	}
    
    	// check error
    	$this->assertEquals("Employee must not have over 40 hours!", $error);
    	// check file contents
    	$this->sm = $this->pm->loadDataFromStore();
    	$this->assertEquals(0, count($this->sm->getEmployees()));
    }
}
?>
