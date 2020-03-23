<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
//კლასის აღწერა
class menus
{
	public $ID;
	public $menu_type_id;
	public $gender_id;
	public $from_kg;
	public $to_kg;
	public $protein;
	public $protein_kcal;
	public $fat;
	public $fat_kcal;
	public $Carbohydrates;
	public $Carbohydrates_kcal;
	public $total_kcal;
	public $status;
	//ბაზასთან კავშირისთვის ცვლადი:
	public $database;
	//ლოგირების ცვლადი
	public $Loging;
	//json
	public $result;
	//შეცდომების გამოსატანი ცლასისთვის და დასალოგი
	public $myexception;
	public $dictionary;
	
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
		$this->dictionary=new dictionaries($database);
		$this->myexception=new myexception($database);
	}
	function get_menu_info($menu_type_id,$gender_id,$target_kg)
	{
		try
		{
			if(IsNullOrEmptyString($menu_type_id) || IsNullOrEmptyString($gender_id)||IsNullOrEmptyString($target_kg))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			//მინიმალური წონა რომ მიუთითოს ვერ იპოვის ბაზაში ჩანაწერს, ამიტომ 0.01-ს ვუმატებ
			$target_kg=$target_kg+0.01;
			if (!($stmt = $this->database->mysqli->prepare("select * from menus where menu_type_id =? and gender_id =? and ? > from_kg and ?<= to_kg and status='A' limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("iidd", $menu_type_id,$gender_id,$target_kg,$target_kg))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				$this->ID=$row["ID"];
				$this->menu_type_id=$row["menu_type_id"];
				$this->gender_id=$row["gender_id"];
				$this->from_kg=$row["from_kg"];
				$this->to_kg=$row["to_kg"];
				$this->protein=$row["protein"];
				$this->protein_kcal=$row["protein_kcal"];
				$this->fat=$row["fat"];
				$this->fat_kcal=$row["fat_kcal"];
				$this->Carbohydrates=$row["Carbohydrates"];
				$this->Carbohydrates_kcal=$row["Carbohydrates_kcal"];
				$this->total_kcal=$row["total_kcal"];
				$this->status=$row["Status"];
			}
			else
			{
				throw new Exception( $this->dictionary->get_text("text.not_found"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
}