<?php
require_once( __DIR__ . "/../database/database.php");
require_once( __DIR__ . "/../myfunctions/myfunction.php");
require_once( __DIR__ . "/../Models/Loging.php");
require_once( __DIR__ . "/../Models/result.php");
require_once( __DIR__ . "/../Models/myexeptions.php");
require_once( __DIR__ . "/../Models/dictionaries.php");
require_once( __DIR__ . "/../Models/menus.php");
require_once( __DIR__ . "/../Models/general.php");
require_once( __DIR__ . "/../Models/products.php");
require_once( __DIR__ . "/../Models/users.php");
require_once( __DIR__ . "/../Models/bogpay.php");
require_once( __DIR__ . "/../Models/invoices.php");
//კლასის აღწერა
class calculator
{
	//რამდენ დღეზე უნდა დაგენერირდეს მენიუ
	public $menu_generate_days;
	public $menu_allowed_mistake;
	//ბაზასთან კავშირისთვის ცვლადი:
	public $database;
	//ლოგირების ცვლადი
	public $Loging;
	//json
	public $result;
	//შეცდომების გამოსატანი ცლასისთვის და დასალოგი
	public $myexception;
	public $dictionary;
	public $menu;
	public $general;
	public $products;
	function __construct($database)
	{
		$this->database=$database;
		$this->Loging=new Loging($database);
		$this->result=new result($database);
		$this->dictionary=new dictionaries($database);
		$this->myexception=new myexception($database);
		$this->menu=new menus($database);
		$this->general=new general($database);
		$this->products=new products($database);
		$this->menu_generate_days=$this->general->get_system_parameters("menu_generate_days");
		$this->menu_allowed_mistake=$this->general->get_system_parameters("menu_allowed_mistake");
	}
	
	function save_data($menu_array,$gender_id,$menu_id,$my_weight,$age,$height,$target_weight,$email,$total_kcal,$physical_activity=null,$Lifestyle=null)
	{
		try
		{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				throw new Exception($this->dictionary->get_text("text.invalid_email"));
			}
			
			$this->database->mysqli->begin_Transaction();
			$users=new users($this->database);
			$users->add_user_menu_header($gender_id,$menu_id,$my_weight,$age,$height,$target_weight,$email,$total_kcal,$physical_activity,$Lifestyle);
			$master_id=$users->get_last_current_user_menu_header();
			$users->add_user_menu_details($master_id,$menu_array);
			//ინვოისის გენერაცია
			$menu=new menus($this->database);
			$menu->get_menu_info_by_id($menu_id);
			$invoice=new invoices($this->database);
			$invoice->invoice_registration($master_id,$menu->price);
			$invoice->get_last_current_user_invoice_info_by_header_id($master_id);
			//ინვოისის დაგენერირების შემდეგ პირდაპირ გადახდის გამოძახება:
			$bogpay=new bogpay($this->database);
			if(isset($_SESSION['username']) && isset($_SESSION["facebook_id"]) && isset($menu->price) && is_numeric($menu->price) && $menu->price>0 && isset($invoice->ID))
			{
				echo "[";
				$json_begin=1;
				$users->get_user_info(null,$_SESSION["facebook_id"]);
				$name=$users->first_name.' '.$users->last_name;
				$bogpay->fill_balance(abs($menu->price),"ინვოისის გადახდა-".$name.': '.$users->facebook_id.' '.$invoice->ID,$users->facebook_id,$invoice->ID);
				echo "{}]";
			}
			else
			{
				throw new Exception("text.required");
			}
			$this->database->mysqli->commit();
		}
		catch(Exception $e)
		{
			$this->database->mysqli->rollback();
			$this->result->get_result(500,"",$e->getMessage(),"");
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
	
	function calculate_menu($gender,$not_wanted_product_ids,/*$menu_type,*/$my_weight,$age,$height,$target_weight,$email,$physical_activity=null,$Lifestyle=null)
	{
		try
		{				
			if(IsNullOrEmptyString($gender) || IsNullOrEmptyString($my_weight) || IsNullOrEmptyString($age)|| IsNullOrEmptyString($height)||  IsNullOrEmptyString($target_weight)|| IsNullOrEmptyString($email))
			{
				throw new Exception($this->dictionary->get_text("text.required"));
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				throw new Exception($this->dictionary->get_text("text.invalid_email"));
			}
			
			$menu_type=null;
			$menu_type_id=null;
			$allowed_mistake_min=0; //დასაშვები ცდომილება კკალ-ებში
			$allowed_mistake_max=0; //დასაშვები ცდომილება კკალ-ებში
			if($my_weight==$target_weight)
			{
				$menu_type="Maintenance menu";
				$menu_type_id=3;
			}
			elseif($my_weight>$target_weight)
			{
				$menu_type="Decrease menu";
				$menu_type_id=1;
			}
			else
			{
				$menu_type="Increase menu";
				$menu_type_id=2;
			}
			$gender_id=$this->general->get_gender_id($gender);
			//მენიუს დღიური ნორმის გაგება:
			$this->menu->get_menu_info($menu_type_id,$gender_id,$target_weight);
			
			
			//დასაშვები ცდომილებების გამოთვლა
			if($menu_type_id==3)
			{
				$allowed_mistake_min=$this->menu->total_kcal-50; 
				$allowed_mistake_max=$this->menu->total_kcal+50;
			}
			elseif($menu_type_id=1)
			{
				$allowed_mistake_min=$this->menu->total_kcal-50; 
				$allowed_mistake_max=$this->menu->total_kcal;
			}
			else
			{
				$allowed_mistake_min=$this->menu->total_kcal; 
				$allowed_mistake_max=$this->menu->total_kcal+50;
			}
			echo "menu_id:".$this->menu->ID.' allowed_mistake_min: '.$allowed_mistake_min.' allowed_mistake_max: '.$allowed_mistake_max.' total_kcal: '. $this->menu->total_kcal.'<br>';
			//კატეგორიების სიის წამოღება, რომლებიდანაც უნდა მოხდეს შემდგომ პროდუქტების არჩევა.
			$selected_product_id_list_by_type=[]; //რა პროდუქტებია უკვე არჩეული პროდუქტის ტიპის მიხედვით
			$product_types_list=[]; //პროდუქტების ტიპების სია სადაც პროდუქტების ტიპის დასახელებებს ვყრით
			$generated_products=[]; //დღის ჭრილში შერჩეული პროდუქტები.
			
			$min_kcal=0; //მინიმალური კკალ  რაც უნდა აირჩიოს კონკრეტული პროდუქტის შერჩევისას.
			for($j=0; $j<$this->menu_generate_days; $j++)
			{
				array_push($generated_products,'');
			}
			$product_types_result=$this->general->get_product_types();
			foreach($product_types_result as $p_t)
			{
				//echo $p_t['Name']. '<br>';
				array_push($product_types_list, $p_t['Name']);
				//array_push($selected_product_id_list_by_type, 0);
				$selected_product_id_list_by_type[$p_t['Name']]='';
			}
			//var_dump($selected_product_id_list_by_type);
			//რამდენ დღეზეც უნდა მოხდეს გადათვლა იმდენჯერ ვატრიალებთ ციკლს
			for($counter=0; $counter<$this->menu_generate_days; $counter++)
			{
				/*echo '<br>'.$counter.'<br>';
				var_dump($selected_product_id_list_by_type);
				unset($selected_product_id_list_by_type);*/
				//echo "begin<br>";
				for($i=0; $i<count($product_types_list); $i++)
				{
					
					//echo $product_type_id.' '.$selected_product_id_list_by_type[$i].'<br>';
					try
					{
						$product_type_id=$this->general->get_product_type_id($product_types_list[$i]);
						//echo 'product_type_id: '.$product_type_id;
						$selected_product=$selected_product_id_list_by_type[$product_types_list[$i]];
						$not_match_products=$this->products->not_match_products($generated_products[$counter]);
						$products_total_info=$this->products->get_products_total_info($generated_products[$counter]);
						$sum_water=0;
						$sum_protein=0;
						$sum_fat=0;
						$sum_Carbohydrates=0;
						$sum_total_kcal=0;
						
						foreach($products_total_info as $p_t_i)
						{
							if(!IsNullOrEmptyString($p_t_i['sum_water']))
								$sum_water=$p_t_i['sum_water'];
							if(!IsNullOrEmptyString($p_t_i['sum_protein']))
								$sum_protein=$p_t_i['sum_protein'];
							if(!IsNullOrEmptyString($p_t_i['sum_fat']))
								$sum_fat=$p_t_i['sum_fat'];
							if(!IsNullOrEmptyString($p_t_i['sum_Carbohydrates']))
								$sum_Carbohydrates=$p_t_i['sum_Carbohydrates'];
							if(!IsNullOrEmptyString($p_t_i['sum_total_kcal']))
								$sum_total_kcal=$p_t_i['sum_total_kcal'];
						}
						$max_for_one_product=$allowed_mistake_max-$sum_total_kcal;
						$random_product_id=$this->products->get_random_product($product_type_id,$not_wanted_product_ids,$not_match_products,$selected_product,$min_kcal,$max_for_one_product);
						//echo '<br> $product_type_id: '.$product_type_id.' $not_wanted_product_ids: '.$not_wanted_product_ids.' $not_match_products: '.$not_match_products.' $selected_product: '.$selected_product.' $min_kcal: '.$min_kcal.' $max_for_one_product: '.$max_for_one_product.'<br>';
						//echo ' akaa: '.$random_product_id;
						//თუ მიმდინარე პროდუქტის ტიპიდან ყველა პროდუქტი უკვე გამოყენებულია, მაშინ უნდა მოხდეს უკვე არჩეულების სიის გასუფთავება და ხელახლა გამოყენება;
						if(IsNullOrEmptyString($random_product_id) || $random_product_id==0)
						{
							$selected_product='';
							$selected_product_id_list_by_type[$product_types_list[$i]]='';
							$random_product_id=$this->products->get_random_product($product_type_id,$not_wanted_product_ids,$not_match_products,$selected_product,$min_kcal,$max_for_one_product);
							
						}
						//თუ $random_product_id მაინც 0 დაბრუნა ე.ო პროდუქტების ტიპი ცარიელია
						if($random_product_id==0 && ($i+1)!=count($product_types_list))
						{
							continue;
						}
						elseif($random_product_id==0 && ($i+1)==count($product_types_list))
						{
							//continue;
							goto savepoint;
						}
						else
						{
						}
						
						if($selected_product_id_list_by_type[$product_types_list[$i]]=='')
						{
							$selected_product_id_list_by_type[$product_types_list[$i]]=$selected_product_id_list_by_type[$product_types_list[$i]].$random_product_id;
						}
						else
						{
							$selected_product_id_list_by_type[$product_types_list[$i]]=$selected_product_id_list_by_type[$product_types_list[$i]].','.$random_product_id;
						}
						//დღიური მენიუსთვის დაგენერირებული პროდუქტის მიმატება
						if(isset($generated_products[$counter]) && $generated_products[$counter]=='')
						{
							//array_push($generated_products,$random_product_id);
							$generated_products[$counter]=$random_product_id;
						}
						else
						{
							$generated_products[$counter]=$generated_products[$counter].','.$random_product_id;
						}
						
						//თუ დღის ჭრილში უკვე ყველა კატეგორიიდან მივამატე პროდუქტი და მაინც ვერ მივიღე იმ რაოდენობის კკალ რაც დასაშვებ შიალედში ჯდება, მაშინ უნდა დავამატო შემთხვევითობის პრინციპით პროდუქტები, რომლებიც აქამდე არ დამიმატებია, ისე რომ ჩავსვა აღნიშნულ დასაშვებ შუალედში.
						//echo 'akkaa '.$i;
						savepoint:
						{
							if(($i+1)==count($product_types_list))
							{
								$products_total_info1=$this->products->get_products_total_info($generated_products[$counter]);
								$sum_water1=0;
								$sum_protein1=0;
								$sum_fat1=0;
								$sum_Carbohydrates1=0;
								$sum_total_kcal1=0;
								foreach($products_total_info1 as $p_t_i1)
								{
									if(!IsNullOrEmptyString($p_t_i1['sum_water']))
										$sum_water1=$p_t_i1['sum_water'];
									if(!IsNullOrEmptyString($p_t_i1['sum_protein']))
										$sum_protein1=$p_t_i1['sum_protein'];
									if(!IsNullOrEmptyString($p_t_i1['sum_fat']))
										$sum_fat1=$p_t_i1['sum_fat'];
									if(!IsNullOrEmptyString($p_t_i1['sum_Carbohydrates']))
										$sum_Carbohydrates1=$p_t_i1['sum_Carbohydrates'];
									if(!IsNullOrEmptyString($p_t_i1['sum_total_kcal']))
										$sum_total_kcal1=$p_t_i1['sum_total_kcal'];
								}
								/*echo '<br>';
								echo ' sum_total_kcal1: '.$sum_total_kcal1;
								echo '<br>';*/
								/*var_dump($generated_products[$counter]);
								echo '<br>';*/
								//ჯერ ყველაზე დიდი კკალ-იის დამატებას ვცდილობთ რაც შეავსებდა, თუ არ ეყო მერე ვამცირებთ. while
								$max_for_one_product1=$allowed_mistake_max-$sum_total_kcal1;
								$min_for_one_product1=$allowed_mistake_min-$sum_total_kcal1;
								$min_for_one_product0=$allowed_mistake_min-$sum_total_kcal1; //იტერაციისთვის არის საჭირო
								
								//echo ' sum_total_kcal1: '.$sum_total_kcal1.' allowed_mistake_min '.$allowed_mistake_min.' allowed_mistake_max '.$allowed_mistake_max;
								//პირველ იტერაზიაზე ვცდილობ წინა დღეს არჩეული პროდუქტები არ გავამეორო.
								$iterration=0;
								while($sum_total_kcal1<$allowed_mistake_min)
								{
									
									if($min_for_one_product1<-100)
									{
										if($iterration==0)
										{
											$iterration=1;
											$min_for_one_product1=$min_for_one_product0;
											continue;
										}
										else
										{
											break;
										}
									}
									$selected_product1=$generated_products[$counter];
									$selected_product0=$generated_products[$counter];// $selected_product1-ის გასანულებლადაა საჭირო
									//echo '<br> selected_product111 '.$selected_product1.'<br>';
									foreach($selected_product_id_list_by_type as $s_p_i_t)
									{
										if(!IsNullOrEmptyString($s_p_i_t))
											$selected_product1=$selected_product1.','.$s_p_i_t;
									}
									//echo '<br> selected_product1 '.$selected_product1.'<br>';
									//echo 'while: '.$selected_product1;
									if($iterration==0)
									{
										$random_product_id1=$this->products->get_full_random_product($not_wanted_product_ids,$not_match_products,$selected_product1,$min_for_one_product1,$max_for_one_product1);
									}
									else
									{
									//თუ ვერ ვავსებ ბოლომდე ($random_product_id1 მოდის 0 რადან ვერ ნახა სხვა გარდა ისეთისა რომელიც მანამდე უკვე გამოყენებულია, ანუ არსებობს $selected_product1-ში მაშინ უნდა განულდეს $selected_product1-ი)
										$random_product_id1=$this->products->get_full_random_product($not_wanted_product_ids,$not_match_products,$selected_product0,$min_for_one_product1,$max_for_one_product1);
									}
									//echo ' random_product_id1 :'.$random_product_id1.' ';
									if($random_product_id1==0) //თუ ვერ მოიძებნა მინიმალურის შეზღუდვას ვამცირებთ 100-ით
									{
										$min_for_one_product1=$min_for_one_product1-100;
										continue;
									}
									else //$sum_total_kcal1 უნდა გაიზარდოს
									{
										
										$products=new products($this->database);
										$products->get_product_info_by_id($random_product_id1);
										$sum_total_kcal1=($sum_total_kcal1+$products->total_kcal);
										$product_type_name='';
										$product_type_id1=$products->product_type_id;
										
										$max_for_one_product1=$allowed_mistake_max-$sum_total_kcal1;
										
										
										$product_type_info1=$this->general->get_product_type_info($product_type_id1);
										foreach($product_type_info1 as $p_t_i_1)
										{
											$product_type_name=$p_t_i_1['Name'];
										}
										
										if($selected_product_id_list_by_type[$product_type_name]=='')
										{
											$selected_product_id_list_by_type[$product_type_name]=$selected_product_id_list_by_type[$product_type_name].$random_product_id1;
										}
										else
										{
											$selected_product_id_list_by_type[$product_type_name]=$selected_product_id_list_by_type[$product_type_name].','.$random_product_id1;
										}
										//დღიური მენიუსთვის დაგენერირებული პროდუქტის მიმატება
										if(isset($generated_products[$counter]) && $generated_products[$counter]=='')
										{
											//array_push($generated_products,$random_product_id);
											$generated_products[$counter]=$random_product_id1;
										}
										else
										{
											$generated_products[$counter]=$generated_products[$counter].','.$random_product_id1;
										}
									}
									//echo '<br>while section:';
							//echo $counter.": ". $generated_products[$counter].'<br>';
								}
								//echo ' sum_total_kcal1: '.$sum_total_kcal1;
								
								//თუ გადავცდი მაქსიმალურ კკალ-ს დასაშვებზე მეტად, ვცდილობ წავშალო სხვაობის შესაბამისად კკალ და დავამატო ისეთი რომ შუალედში ჩაჯდეს
								//მაქსიმუმს წესით არასდროს გაცდება
							}
						}
						//echo $random_product_id.' '.$product_types_list[$i].' '. $selected_product_id_list_by_type[$product_types_list[$i]]. '<br>';
					}
					catch(Exception $e)
					{
						echo $e->getMessage();
						continue;
					}
					//var_dump($selected_product_id_list_by_type);
				}
				//echo '<br>';
				//$a=explode(',',$generated_products[$counter]);
				
				//ბაზაში ინფორმაციის ჩაწერა:
				
				
				echo $counter.": ". $generated_products[$counter].' sul: '.$sum_total_kcal1.'<br>';
				//var_dump($generated_products);
			}
			$this->save_data($generated_products,$gender_id,$this->menu->ID,$my_weight,$age,$height,$target_weight,$email,$sum_total_kcal1,$physical_activity=null,$Lifestyle=null);
			//კატეგორიის მიხედვით random პროდუქტის აღება
			//echo $this->products->get_random_product(1,$not_wanted_product_ids);
			//აქამდე სწორია
			
			$this->Loging->process_succes_log(__FUNCTION__,json_encode(get_defined_vars()),$this->dictionary->get_text("text.success"),"");
		}
		catch(Exception $e)
		{
			$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$e->getMessage());
			throw $e;
		}
	}
}