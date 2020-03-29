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
	public $logo;
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
	function add_product($product_name_ge,$product_name_en,$product_name_ru,$water,$protein,$fat,$Carbohydrates,$total_kcal,$logo_name,$product_type_id,$Status,$product_category_id=1)
	{
		try
		{
			if(IsNullOrEmptyString($product_name_ge) || IsNullOrEmptyString($product_name_en) || IsNullOrEmptyString($product_name_ru) || IsNullOrEmptyString($water) || IsNullOrEmptyString($protein)|| IsNullOrEmptyString($fat)|| IsNullOrEmptyString($Carbohydrates)|| IsNullOrEmptyString($total_kcal)|| IsNullOrEmptyString($product_type_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			if($Status==1)
			{
				$Status='A';
			}
			else
			{
				$Status='C';
			}
			$product_dictionary_key="text.product_".$product_name_en;
			//შემოწმება ინგლისურ და ქართულ ენაზე გაწერილი ხომარაა შესაბამისი dictionary
			$check_ge=$this->dictionary->check_dictionary($product_dictionary_key,"geo");
			$check_en=$this->dictionary->check_dictionary($product_dictionary_key,"eng");
			$check_ru=$this->dictionary->check_dictionary($product_dictionary_key,"rus");
			if($check_ge==false && $check_en==false && $check_ru==false)
			{
				$this->database->mysqli->begin_Transaction();
				$this->dictionary->add_dictionary($product_dictionary_key,"geo",$product_name_ge);
				$this->dictionary->add_dictionary($product_dictionary_key,"eng",$product_name_en);
				$this->dictionary->add_dictionary($product_dictionary_key,"rus",$product_name_ru);
				
				$query="insert into products (product_dictionary_key,water,protein,fat,Carbohydrates,total_kcal,product_type_id,logo,product_category_id,Status)
												values(?,?,?,?,?,?,?,?,?,?)";
				if (!($stmt1 = $this->database->mysqli->prepare($query))) 
				{
					throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt1->bind_param("sddddiisis", $product_dictionary_key,$water,$protein,$fat,$Carbohydrates,$total_kcal,$product_type_id,$logo_name,$product_category_id,$Status))
				{
					throw new Exception( "Binding parameters failed: (" . $stmt1->errno . ") " . $stmt1->error);
				}
				if (!$stmt1->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				$stmt1->close();
				$this->database->mysqli->commit();
				$this->result->get_result(200,"",$this->dictionary->get_text("text.success"),"", true);
			}
			else
			{
				//echo $this->dictionary->get_text("text.dictionary.exists");
				throw new Exception($this->dictionary->get_text("text.dictionary.exists"));
			}
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			$this->result->get_result(500,"",$e->getMessage(),"");
			//throw $e;
		}
	}
	function edit_product($id,$product_name_ge,$product_name_en,$product_name_ru,$water,$protein,$fat,$Carbohydrates,$total_kcal,$logo_name,$product_type_id,$Status,$product_category_id=1)
	{
		try
		{
			if( IsNullOrEmptyString($id) ||IsNullOrEmptyString($product_name_ge) || IsNullOrEmptyString($product_name_en) || IsNullOrEmptyString($product_name_ru) || IsNullOrEmptyString($water) || IsNullOrEmptyString($protein)|| IsNullOrEmptyString($fat)|| IsNullOrEmptyString($Carbohydrates)|| IsNullOrEmptyString($total_kcal)|| IsNullOrEmptyString($product_type_id))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			if($Status==1)
			{
				$Status='A';
			}
			else
			{
				$Status='C';
			}
			$this->get_product_info_by_id($id);
			$product_dictionary_key=$this->product_dictionary_key;
		/*	//შემოწმება ინგლისურ და ქართულ ენაზე გაწერილი ხომარაა შესაბამისი dictionary
			$check_ge=$this->dictionary->check_dictionary($product_dictionary_key,"geo");
			$check_en=$this->dictionary->check_dictionary($product_dictionary_key,"eng");
			$check_ru=$this->dictionary->check_dictionary($product_dictionary_key,"rus");
			if($check_ge==true && $check_en==true && $check_ru==true)
			{*/
				$this->database->mysqli->begin_Transaction();
				$this->dictionary->dictionary_change($product_dictionary_key,$product_name_ge,$product_name_en,$product_name_ru);
				
				$query="update products set product_dictionary_key=?,water=?,protein=?,fat=?,Carbohydrates=?,total_kcal=?,product_type_id=?,logo=?,product_category_id=?,Status=?
												where ID=?";
				if (!($stmt1 = $this->database->mysqli->prepare($query))) 
				{
					throw new Exception("Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
				}
				if (!$stmt1->bind_param("sddddiisisi", $product_dictionary_key,$water,$protein,$fat,$Carbohydrates,$total_kcal,$product_type_id,$logo_name,$product_category_id,$Status,$id))
				{
					throw new Exception( "Binding parameters failed: (" . $stmt1->errno . ") " . $stmt1->error);
				}
				if (!$stmt1->execute()) 
				{
					throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
				}
				$stmt1->close();
				$this->database->mysqli->commit();
				$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");
				$this->result->get_result(200,"",$this->dictionary->get_text("text.success"),"", true);
			/*}
			else
			{
				//echo $this->dictionary->get_text("text.dictionary.exists");
				throw new Exception($this->dictionary->get_text("text.dictionary.exists"));
			}*/
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			$this->result->get_result(500,"",$e->getMessage(),"");
			//throw $e;
		}
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
				$this->logo=$row["logo"];
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

			if (!($stmt = $this->database->mysqli->prepare("select * from products where ID=? limit 1"))) 
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
				$this->logo=$row["logo"];
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
	
	function get_producttypes($status=null)
	{
		try
		{
			if(IsNullOrEmptyString($status))
			{
				$query="SELECT * FROM product_types";
			}
			else
			{
				$query="SELECT * FROM product_types where Status='".$status."'";
			}
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
			return $res;
			$stmt->close();
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function get_products($status=null)
	{
		try
		{
			if(IsNullOrEmptyString($status))
			{
				$query="SELECT d.Value,pt.Name_Geo, p.* FROM `products` p, dictionaries d, product_types pt
						where p.product_dictionary_key=d.Dictionary_Key
						and d.Language_ID=1
                        and pt.ID=p.product_type_id ";
			}
			else
			{
				$query="SELECT d.Value,pt.Name_Geo, p.* FROM `products` p, dictionaries d, product_types pt
						where p.product_dictionary_key=d.Dictionary_Key
						and d.Language_ID=1
                        and pt.ID=p.product_type_id 
						and p.Status='".$status."'";
			}
			if (!($stmt = $this->database->mysqli->prepare($query))) 
			{
				throw new Exception( "Prepare failed: (" . $this->database->mysqli->errno . ") " . $this->database->mysqli->error);
			}
			if (!$stmt->execute()) 
			{
				throw new Exception( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			$res = $stmt->get_result();
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