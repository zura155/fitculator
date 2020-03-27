<?php

//default_charset = "utf-8";

ini_set('default_charset', 'utf-8');
class data

{

    public $mysqli;

    private $server='localhost';

    private $username='root';

    private $password='';

    private $database='fitculator';

    function __construct()

    {



        $this->connect();

    }

    public function connect()

    {

        try{

            if(session_status() !== PHP_SESSION_ACTIVE)
			{
				session_start();
			}

            if(!isset($_SESSION['lang']))

            {

                $_SESSION['lang']='geo';

            }

            //echo session_id()."<br/>". session_status();//."<br/>". session_create_id();



            //echo "<br/> open connection <br/>";

            $this->mysqli=new mysqli($this->server,$this->username,$this->password,$this->database);

            $this->mysqli->query('SET NAMES utf8');

            $this->mysqli->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

            if($this->mysqli->connect_error)

            {

                /*$error="<p>ბაზასთან დაკავშირება ვერ მოხერხდა: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error."! </p>";

                header('Location: error.php?error='.$error);

                exit;*/



                throw new Exception("ბაზასთან დაკავშირება ვერ მოხერხდა: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error."!");

            }

            /*else

                {

                    //echo "კავშირი დამყარდა";

                }*/

        }

        catch(Exception $e)

        {

            echo $e->getMessage();

        }

    }



    function check_connection()

    {



        //echo "<br/>check connection<br/>";

        if($this->mysqli->ping())

        {

            return true;

        }

        else

        {

            return false;

        }

    }





    function __destruct()

    {

        //echo "<br/>close connection from destructor<br/>";

        $this->close_connection();



        //echo "განადგურდა";

    }

    function close_connection()

    {

        //echo "<br/>close connection from close_connection<br/>";

        $this->mysqli->close();

        /*$theead=$this->mysqli->thread_id;

        $this->mysqli->kill($thread);*/

    }

}

?>