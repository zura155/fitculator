<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
//კლასის აღწერა
class products
{
	public $ID;
	public $product_dictionary_key;
	public $water;
	public $protein;
	public $fat;
	public $Carbohydrates;
	public $total_kcal;
	public $product_type_id;
	public $product_category_id;
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
	function get_product_info($id,$product_type_id,$product_category_id)
	{
		try
		{
			if(IsNullOrEmptyString($id) && IsNullOrEmptyString($product_type_id) && IsNullOrEmptyString($product_category_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}

			if (!($stmt = $this->database->mysqli->prepare("select * from products where ID=? or product_type_id=? or product_category_id=? status='A' limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("iii", $id,$product_type_id,$product_category_id))
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
				$this->product_dictionary_key=$row["product_dictionary_key"];
				$this->water=$row["water"];
				$this->protein=$row["protein"];
				$this->fat=$row["fat"];
				$this->Carbohydrates=$row["Carbohydrates"];
				$this->total_kcal=$row["total_kcal"];
				$this->status=$row["Status"];
				$this->product_type_id=$row["product_type_id"];
				$this->product_category_id=$row["product_category_id"];
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
	function get_product_info_by_id($id)
	{
		try
		{
			if(IsNullOrEmptyString($id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}

			if (!($stmt = $this->database->mysqli->prepare("select * from products where ID=? and status='A' limit 1"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("i", $id))
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
				$this->product_dictionary_key=$row["product_dictionary_key"];
				$this->water=$row["water"];
				$this->protein=$row["protein"];
				$this->fat=$row["fat"];
				$this->Carbohydrates=$row["Carbohydrates"];
				$this->total_kcal=$row["total_kcal"];
				$this->status=$row["Status"];
				$this->product_type_id=$row["product_type_id"];
				$this->product_category_id=$row["product_category_id"];
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
	function get_random_product($product_type_id,$not_wanted_product_ids,$not_match_products,$selected_products,$min_kcal=0,$max_kcal=1000000)
	{
		try
		{
			/*if(IsNullOrEmptyString($product_type_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}*/
			if(IsNullOrEmptyString($not_wanted_product_ids))
				$not_wanted_product_ids="' '";
			if(IsNullOrEmptyString($not_match_products))
				$not_match_products="' '";
			if(IsNullOrEmptyString($selected_products))
				$selected_products="' '";
			/*$query="
			SELECT 
				t.*
			FROM
				products AS t
					JOIN
				(SELECT 
					ROUND(RAND() * (SELECT 
								MAX(ID)
							FROM
								products)) AS product_id
				) AS x
			WHERE
				t.id >= x.product_id 
				 and t.id not in (".$not_wanted_product_ids.")  
				 and t.id not in (".$not_match_products.")  
				 and t.id not in (".$selected_products.")  
				 and t.product_type_id=? 
				 and t.total_kcal>=?
				 and t.total_kcal<=?
				 and t.status='A' 
				 limit 1";*/
			$query="
			SELECT 
				t.*
			FROM
				products t
			WHERE
				 t.id not in (".$not_wanted_product_ids.")  
				 and t.id not in (".$not_match_products.")  
				 and t.id not in (".$selected_products.")  
				 and t.product_type_id=? 
				 and t.total_kcal>=?
				 and t.total_kcal<=?
				 and t.status='A' 
				 order by rand()
				 limit 1";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("iii", $product_type_id,$min_kcal,$max_kcal))
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
				return $row["ID"];
			}
			else
			{
				return 0;
				//throw new Exception( $this->dictionary->get_text("text.not_found"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_full_random_product($not_wanted_product_ids,$not_match_products,$selected_products,$min_kcal=0,$max_kcal=1000000)
	{
		try
		{
			if(IsNullOrEmptyString($not_wanted_product_ids))
				$not_wanted_product_ids="' '";
			if(IsNullOrEmptyString($not_match_products))
				$not_match_products="' '";
			if(IsNullOrEmptyString($selected_products))
				$selected_products="' '";
			/*$query="
			SELECT 
				t.*
			FROM
				products AS t
					JOIN
				(SELECT 
					ROUND(RAND() * (SELECT 
								MAX(ID)
							FROM
								products)) AS product_id
				) AS x
			WHERE
				t.id >= x.product_id 
				 and t.id not in (".$not_wanted_product_ids.")  
				 and t.id not in (".$not_match_products.")  
				 and t.id not in (".$selected_products.")  
				 and t.total_kcal>=?
				 and t.total_kcal<=?
				 and t.status='A' 
				 limit 1";*/
			$query="
			SELECT 
				t.*
			FROM
				products AS t
			WHERE
				 t.id not in (".$not_wanted_product_ids.")  
				 and t.id not in (".$not_match_products.")  
				 and t.id not in (".$selected_products.")  
				 and t.total_kcal>=?
				 and t.total_kcal<=?
				 and t.status='A' 
				 order by rand()
				 limit 1";
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ii",$min_kcal,$max_kcal))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			//echo json_encode(get_defined_vars());
			if(isset($row["ID"]) && $row["ID"]>0)
			{
				return $row["ID"];
			}
			else
			{
				return 0;
				//throw new Exception( $this->dictionary->get_text("text.not_found"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function not_match_products($product_ids='')
	{
		try
		{

			if (!($stmt = $this->database->mysqli->prepare("
			SELECT  t.product_second_id as res from product_not_match t
			where t.product_first_id in (?)
				 and t.status='A' 
			union 
			SELECT  t.product_first_id as res from product_not_match t
						where t.product_second_id in (?)
							 and t.status='A' 
				 "))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->bind_param("ii", $product_ids,$product_ids))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			
			if(isset($row["res"]) && $row["res"]!='')
			{
				return $row["res"];
			}
			else
			{
				return '';
				//throw new Exception( $this->dictionary->get_text("text.not_found"));
			}
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_products_total_info($products_ids)
	{
		try
		{
			if(IsNullOrEmptyString($products_ids))
				$products_ids="' '";
			
			if (!($stmt = $this->database->mysqli->prepare("
			select 
			sum(water) as sum_water,
			sum(protein) as sum_protein,
			sum(fat) as sum_fat,
			sum(Carbohydrates) as sum_Carbohydrates,
			sum(total_kcal) as sum_total_kcal
			from products p
			where p.id in (".$products_ids.")"))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			/*if (!$stmt->bind_param("i", $products_ids))
			{
				throw new Exception( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}*/
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			//$row = $res->fetch_assoc();
			return $res;
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
}