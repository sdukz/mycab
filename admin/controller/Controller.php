<?php

include_once("model/Model.php");

class Controller
{
	public $model;

    public function __construct()
	{

		$this->model = new Model();		
	}
	
	public function index()
	{
		 $result = $this->model->getlogin();
		if($result == 'login')
		{
			include 'home.php';
		}
		else
		{
			include 'view/login.php';
		}
	}
	public function home()
	{
		$result = $this->model->home();
				
		if($result == 'success')
		{
			$totalE = $this->model->totalEarning();   
			$totalD = $this->model->totalDriver();
			$totalP = $this->model->totalPassanger();
			$todayD = $this->model->todayJoinedDriver();
			$todayP = $this->model->todayJoinedPassanger();
			$todayE = $this->model->todayAdminEarn();
			include 'view/home.php';
		}
		else
		{
			header("Location:index");
			//include 'view/login.php';
		}
	}
	public function profile()
	{
		$result = $this->model->profile();
		
		if(is_array($result))
		{
			include 'view/profile.php';
		}
		else
		{
			header("Location:index");
			//include 'view/login.php';
		}
	}
	public function updatePasswordForm()
	{
		$result = $this->model->updatePasswordForm();
		
		if(is_array($result))
		{
			include 'view/edit_profile.php';
		}
		else {
			header("Location:index");
		}
		
	}	
	public function drivers()
	{
		$result = $this->model->drivers();
		$deleted='';
		$status ='';
		if(isset($result['deleted']))
		{
			$deleted =$result['deleted']['deleted'];
		    unset($result['deleted']);
		}
		if(isset($result['status']))
		{
			$status =$result['status']['status'];
		    unset($result['status']);
		}
		
		$record = count($result);
		
		if(is_array($result))
		{
			include 'view/drivers.php';
		}
	}
	public function passengers()
	{
		$result = $this->model->passengers();
		$deleted='';
		$status ='';
		if(isset($result['deleted']))
		{
			$deleted =$result['deleted']['deleted'];
		    unset($result['deleted']);
		}
		if(isset($result['status']))
		{
			$status =$result['status']['status'];
		    unset($result['status']);
		}
		
		$record = count($result);
		
		if(is_array($result))
		{
			include 'view/passengers.php';
		}
	}
	public function updateDriverProfile()
	{
		
		$result = $this->model->updateDriverProfile();
		if(is_array($result))
		{
			if(isset($result['updated']))
			{
				$updated =$result['updated'];
		    	unset($result['updated']);
			}
			include 'view/edit_driver.php';
		}
	}
	public function updatePassengerProfile()
	{
		$result = $this->model->updatePassengerProfile();
		
		if(is_array($result))
		{
			if(isset($result['updated']))
			{
				$updated =$result['updated'];
		    	unset($result['updated']);
			}
			include 'view/edit_passenger.php';
		}
	}
    
}

?>
