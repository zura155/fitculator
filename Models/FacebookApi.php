<?php
require_once __DIR__ . '/../vendor/autoload.php';   
//class section 
class FacebookApi
{
	private $App_ID="361987473976736";
	private $App_Secret="75136ff20218779a574e6a5df71e7c38";
	private $Graph_Api_Version="v5.0";
	public $Access_Token="";
	private $default_graph_version="v3.2";
	//logined user info
	public $Login_State=false;
	public $Login_User_ID;
	public $Login_User_Name;
	public $Login_User_Email;
	public $Login_User_FirstName;
	public $Login_User_LastName;
	public $Login_User_Gender;
	public $Login_User_Picture;
	
	function __construct()
	{
		
		try
		{
			if(session_status() !== PHP_SESSION_ACTIVE)
			{
				session_start();
			}
			else
			{
				if(isset($_SESSION['fb_access_token']))
				{
					$this->Access_Token=$_SESSION['fb_access_token'];
				}
				 //var_dump($_SESSION);
			}
		}
		catch(Exception $e)
        {
            echo $e->getMessage();
        }
	}
	function Get_User_Info()
	{
		//check user is logined or not
		if(isset($this->Access_Token) && $this->Access_Token!="")
		{
			$this->Login_State=true;
			
			$fb = new \Facebook\Facebook([
			  'app_id' => $this->App_ID,           //Replace {your-app-id} with your app ID
			  'app_secret' => $this->App_Secret,   //Replace {your-app-secret} with your app secret
			  'graph_api_version' => $this->Graph_Api_Version,
			]);

			try {
				// Get your UserNode object, replace {access-token} with your token
				$response = $fb->get('/me?fields=id,name,first_name,last_name,picture,email', $this->Access_Token);
			} 
			catch(\Facebook\Exceptions\FacebookResponseException $e) 
			{
					// Returns Graph API errors when they occur
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
			} 
			catch(\Facebook\Exceptions\FacebookSDKException $e) 
			{
					// Returns SDK errors when validation fails or other local issues
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
			}
			$me = $response->getGraphUser();

			/*//All that is returned in the response
			echo 'All the data returned from the Facebook server: ' . $me;
			//Print out my name
			echo 'My name is ' . $me->getName();*/
			//var_dump($response);
			$this->Login_User_ID=$me->getId();
			$this->Login_User_Name=$me->getName();
			$this->Login_User_Email=$me->getEmail();
			$this->Login_User_FirstName=$me->getFirstName();
			$this->Login_User_LastName=$me->getLastName();
			$this->Login_User_Gender=$me->getGender();
			$this->Login_User_Picture=$me->getPicture();
			$_SESSION["username"]=$me->getName();
			$_SESSION["facebook_id"]=$me->getId();
			
			//if not exists insert into database; age, wheight etc.
		}
	   else
	   {
		   $this->Login_State=false;
	   }
	}
	function Login()
	{
		$fb = new Facebook\Facebook([
		  'app_id' => $this->App_ID, // Replace {app-id} with your app id
		  'app_secret' => $this->App_Secret,
		  'default_graph_version' => $this->default_graph_version,
		  ]);

		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['public_profile,email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('https://fitculator.ge/fb-callback.php', $permissions);
		/*echo '<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ka_GE/sdk.js#xfbml=1&version=v6.0&appId=361987473976736&autoLogAppEvents=1"></script>';
		echo '<div class="fb-login-button" data-width="" data-size="small" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false"></div>';*/
		echo '<a href="' . htmlspecialchars($loginUrl) . '"><img src="../themes/fitculator/images/fb.png" alt="Fitculator.com" style="width: 40%;" /></a>';
		//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
		//echo '<div onclick="popitup('."'" . htmlspecialchars($loginUrl) ."'".')">Log in with Facebook!</div>';
	}
	
	function get_Login_url()
	{
		$fb = new Facebook\Facebook([
		  'app_id' => $this->App_ID, // Replace {app-id} with your app id
		  'app_secret' => $this->App_Secret,
		  'default_graph_version' => $this->default_graph_version,
		  ]);

		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['public_profile,email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('https://fitculator.ge/fb-callback.php', $permissions);
		return $loginUrl;
	}
	
	function Login_Call_Back()
	{
		
		$fb = new Facebook\Facebook([
		  'app_id' => $this->App_ID, // Replace {app-id} with your app id
		  'app_secret' => $this->App_Secret,
		  'default_graph_version' => $this->default_graph_version,
		  ]);

		$helper = $fb->getRedirectLoginHelper();
		if (isset($_GET['state'])) 
		{ 
			$helper->getPersistentDataHandler()->set('state', $_GET['state']); 
		}
		
		
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			echo "Error: " . $helper->getError() . "\n";
			echo "Error Code: " . $helper->getErrorCode() . "\n";
			echo "Error Reason: " . $helper->getErrorReason() . "\n";
			echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
			header('HTTP/1.0 400 Bad Request');
			echo 'Bad request';
		  }
		  exit;
		}

		// Logged in
		/*echo '<h3>Access Token</h3>';
		var_dump($accessToken->getValue());*/

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		/*echo '<h3>Metadata</h3>';
		var_dump($tokenMetadata);*/

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId($this->App_ID); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
			echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
			exit;
		  }

		  echo '<h3>Long-lived</h3>';
		  var_dump($accessToken->getValue());
		}

		$_SESSION['fb_access_token'] = (string) $accessToken;
		$this->Access_Token=(string) $accessToken;
		//echo '<h3>'.$_SESSION['fb_access_token'].'</h3>';
		//header("Location: index.php");
		// User is logged in with a long-lived access token.
		// You can redirect them to a members-only page.
		//header('Location: https://example.com/members.php');
	}
	function fb_logout()
	{
		session_start();
		session_unset();
		session_destroy();
		session_abort();
		header("Location: index.php", true, 301);
        exit();
	}
	function js_login()
	{
		echo "	<script>
  function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      testAPI();  
    } else {                                 // Not logged into your webpage or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this webpage.';
    }
  }
  function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);
    });
  }
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '".$this->App_ID."',
      cookie     : true,                     // Enable cookies to allow the server to access the session.
      xfbml      : true,                     // Parse social plugins on this webpage.
      version    : 'v6.0'           // Use this Graph API version for this call.
    });
    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
      statusChangeCallback(response);        // Returns the login status.
    });
  };
  
  (function(d, s, id) {                      // Load the SDK asynchronously
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
 
  function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>
	
<div id='fb-root'></div>";
	}
}
?>