<?php
session_start();
include_once("db.php");

class Model
{
	public $model;

    public function __construct()
	{

		$this->db = new Database();		
	}
	
	public function getlogin()
	{
		if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
		{
			$query = "SELECT * FROM super_admin WHERE `username`='{$_REQUEST['username']}' AND `password`='{$_REQUEST['password']}'";
	     	$this->db->query($query);
	     	if($this->db->numRows() != 0)
			{
				$this->db->singleRecord();
				$_SESSION['id'] = $this->db->Record['id'];
				$_SESSION['username'] = $this->db->Record['username'];
				return 'login';
			}
			else
			{
				return 'invalid user';				
			}
		}
	}
	public function home()
	{
		if(isset($_SESSION['username']) && isset($_SESSION['id']))
		{			
			return 'success';
		}
		else
		{
			return 'invalid user';				
		}
		
	}
	public function totalDriver()
	{
		$query = "SELECT * FROM driver WHERE status=1";
		$this->db->query($query);
		return $this->db->numRows();
	}
	public function totalPassanger()
	{
		$query = "SELECT * FROM passanger WHERE status=1";
		$this->db->query($query);
		return $this->db->numRows();
	}
	public function todayJoinedDriver()
	{
		$query="SELECT * FROM driver WHERE DATE(`created_date`) = CURDATE() AND status=1";			
		$this->db->query($query);
		return $this->db->numRows();		
	}
	public function todayJoinedPassanger()
	{
		$query="SELECT * FROM passanger WHERE DATE(`created_date`) = CURDATE() AND status=1";			
		$this->db->query($query);
		return $this->db->numRows();		
	}
	public function totalEarning()
	{
		$query="SELECT SUM(amount) AS earn FROM admin_earn WHERE status=1";
		$this->db->query($query);
		$this->db->singleRecord();
		return $this->db->Record['earn'];
	}
	public function todayAdminEarn()
	{
		$query="SELECT SUM(amount) AS earn FROM admin_earn WHERE DATE(`created_date`) = CURDATE() AND status=1";			
		$this->db->query($query);
		$this->db->singleRecord();
		return  $this->db->Record['earn'];
	}
	public function profile()
	{
		if(isset($_SESSION['username']) && isset($_SESSION['id']))
		{
			$query = "SELECT * FROM super_admin WHERE id={$_SESSION['id']} ";
	        $this->db->query($query);
		    $this->db->singleRecord();
			/*
			echo $this->db->Record['username'];
						 print_r($this->db->singleRecord());
						exit;*/
			
				return $this->db->Record;
		}
		else
		{
				return 'invalid user';				
		}		
	}
	public function updatePasswordForm()
	{
		if(isset($_SESSION) && isset($_SESSION['id']))
		{
		$result1 = array();	

		if( isset($_REQUEST['old_password']) && isset($_REQUEST))
		{
			$this->model = new Model();
			$check_old_pwd = $this->model->check_password('admin','password',$_REQUEST['old_password']);
			if($check_old_pwd =='available')
			{
				if(trim($_REQUEST['new_password']) =='' || trim($_REQUEST['confirm_password'])=='')
				{
					$result1['update']='blank';
				}
				else 
				{	
					
			if($_REQUEST['new_password'] == $_REQUEST['confirm_password'])
			{
				$_REQUEST = array_map('trim',$_REQUEST);
			$query = "UPDATE super_admin SET password ='{$_REQUEST['new_password']}' WHERE `id`='{$_SESSION['id']}' ";
	     	$this->db->query($query);
	     	if($this->db->affectedRows() > 0)
			{
				 $result1['update']='success';
			}
			else
			{
				 $result1['update']='unsuccess';			
			}
			}
			else { $result1['update']='mismatch'; }
			
			     }
			}
			
			else { $result1['update']='not available'; }				
		}		
			$query = "SELECT * FROM super_admin WHERE id={$_SESSION['id']} ";
	        $this->db->query($query);
		    $this->db->singleRecord();
		    $result1['password'] =$this->db->Record['password'];
			$result1['username'] =$this->db->Record['username'];
			}
		 else
		 	{
		 		$result1 = 'not authorized!';
		 	}
        return $result1;		
	 }
	public function check_password($type,$field,$pwd)
	{
		$query = "SELECT * FROM super_admin WHERE id={$_SESSION['id']} AND password='$pwd' ";
	    $this->db->query($query);
		if($this->db->numRows() >0)
		{ return 'available'; }
		else { return 'not available'; }
	}
	public function drivers()
	{
		$row = array();
		$deleted = '';
		$statused= '';
		
		if(isset($_GET) && isset($_GET['operation']))
				{
					switch ($_GET['operation']) 
					{
						case 'delete':
							$query = "DELETE FROM {$_GET['type']} WHERE driver_id={$_GET['id']} ";
							$this->db->query($query);
							if($this->db->affectedRows()>0)
							{
							$deleted ='success';
							}
							else 
							{
							$deleted ='unsuccess';	
							}				
							break;
                       case 'status':
                            $status = ($_GET['status']==1) ? 0 : 1;
						    $query = "UPDATE driver SET status=$status WHERE driver_id={$_GET['id']}";
							$this->db->query($query);
							if($this->db->affectedRows() >0)
							{
								$statused = 'success';
							}
                            else
							{
								$statused = 'unsuccess';
							}	
	                        break;
					}			
				 }	
			
		$query = "SELECT * FROM driver ORDER BY created_date DESC ";
	    $this->db->query($query);
	    if($this->db->numRows() > 0)
		{
			while($this->db->nextRecord())
			{
				$row[] = $this->db->Record;
			}			
		}
		else
		{
			$row['message']='Not available';			
		}
		
		if($deleted !='')
		{ $row['deleted']['deleted']=$deleted; }
		if($statused !='')
		{ $row['status']['status']=$statused; }
		
		return $row;
	}
    public function passengers()
	{
		$row = array();
		$deleted = '';
		$statused= '';
		
		if(isset($_GET) && isset($_GET['operation']))
				{
					switch ($_GET['operation']) 
					{
						case 'delete':
							$query = "DELETE FROM passanger WHERE passanger_id={$_GET['id']} ";
							$this->db->query($query);
							if($this->db->affectedRows()>0)
							{
							$deleted ='success';
							}
							else 
							{
							$deleted ='unsuccess';	
							}				
							break;
                       case 'status':
                            $status = ($_GET['status']==1) ? 0 : 1;
						    $query = "UPDATE passanger SET status=$status WHERE passanger_id={$_GET['id']}";
							$this->db->query($query);
							if($this->db->affectedRows() >0)
							{
								$statused = 'success';
							}
                            else
							{
								$statused = 'unsuccess';
							}	
	                        break;
					}			
				 }	
			
		$query = "SELECT * FROM passanger ORDER BY created_date DESC ";
	    $this->db->query($query);
	    if($this->db->numRows() > 0)
		{
			while($this->db->nextRecord())
			{
				$row[] = $this->db->Record;
			}			
		}
		else
		{
			$row['message']='Not available';			
		}
		
		if($deleted !='')
		{ $row['deleted']['deleted']=$deleted; }
		if($statused !='')
		{ $row['status']['status']=$statused; }
	
		return $row;
	}
   public function updateDriverProfile()
   {
   	
   	$updated = '';
   	
   	if(isset($_POST) && isset($_POST['update']))
	{
		if(isset($_FILES) && isset($_FILES['driver_image']))
		{
			if($_FILES['driver_image']['error'] ==0)
			{
				$random_no = $this->db->random_no();
		        move_uploaded_file($_FILES['driver_image']['tmp_name'],"../avatar/".$random_no.$_FILES['driver_image']['name']);
		        $_POST['driver_image']= "http://admin.tvdevphp.com/Mycab/avatar/".$random_no.$_FILES['driver_image']['name'];
	        }
		}
        $Data = array_filter($_POST);
        $Data = array_map('trim',$Data);
        if(array_key_exists('update', $Data))
        unset($Data['update']);

        $query = $this->db->create_query($Data,'driver','UPDATE');
		$query = $query." WHERE driver_id='{$_GET['id']}' ";
        $this->db->query($query);
		if($this->db->affectedRows()>0)
		{
			$updated = 'success';
		}
		else 
		{
			$updated = 'unsuccess';	
		}
	}
   	if(isset($_GET) && isset($_GET['id']))
	{
		$query = "SELECT * FROM driver WHERE driver_id={$_GET['id']} ";
	    $this->db->query($query);
		$this->db->singleRecord();
		$row= $this->db->Record;
	}
	if($updated !='')
	{
		$row['updated']= $updated ;
	}
   	return $row;
   }
   public function updatePassengerProfile()
   {
   	$updated = '';
   	
   	if(isset($_POST) && isset($_POST['update']))
	{
		if(isset($_FILES) && isset($_FILES['passenger_image']))
		{
			if($_FILES['passenger_image']['error'] ==0)
			{
				$random_no = $this->db->random_no();
		        move_uploaded_file($_FILES['passenger_image']['tmp_name'],"../avatar/".$random_no.$_FILES['passenger_image']['name']);
		        $_POST['passanger_image']= "http://admin.tvdevphp.com/Mycab/avatar/".$random_no.$_FILES['passenger_image']['name'];
	        }
		}
        $Data = array_filter($_POST);
        $Data = array_map('trim',$Data);
        if(array_key_exists('update', $Data))
        unset($Data['update']);

        $query = $this->db->create_query($Data,'passanger','UPDATE');
		$query = $query." WHERE passanger_id={$_GET['id']} ";
        $this->db->query($query);
		if($this->db->affectedRows()>0)
		{
			$updated = 'success';
		}
		else 
		{
			$updated = 'unsuccess';	
		}
	}
   	if(isset($_GET) && isset($_GET['id']))
	{
		$query = "SELECT * FROM passanger WHERE passanger_id={$_GET['id']} ";
	    $this->db->query($query);
		$this->db->singleRecord();
		$row= $this->db->Record;
	}
	if($updated !='')
	{
		$row['updated']= $updated ;
	}
   	return $row;
   }
	
}

?>