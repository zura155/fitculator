<?php
	require_once("header_template.php");
?>
<body class="first-page theme male">
	<!--facebook login 1-->
	
<?php
require_once __DIR__ . '/Models/FacebookApi.php';   
require_once __DIR__ . '/Models/users.php';  
require_once __DIR__ . '/Models/dictionaries.php';  
require_once __DIR__ . '/database/database.php';  
	$database=new data();
	$dictionary=new dictionaries($database);
	$fbapi=new FacebookApi();
	//$user=new users();
	//$fbapi->Get_User_Info();
	if(isset($_SESSION['fb_access_token']))
	{
		//echo $_SESSION['fb_access_token'];
		$fbapi->Access_Token=$_SESSION['fb_access_token'];
		$fbapi->Get_User_Info();
		//$user->login_or_registration($fbapi->Login_User_ID,)
		//echo $fbapi->Login_User_Name;
	}
	//var_dump($_SESSION);
	//session_start();
	//echo $_SESSION["token"];
	//echo  $fbapi->Access_Token;
	//echo $fbapi->Login_User_Name;
	/*echo $fbapi->Login();*/
?>
	<!-- facebook login end -->
<link rel="stylesheet" href="css/main_<?php echo $_SESSION['lang']; ?>.css">

    <header class="container">
        <div class="logo">
			<a href="index.php">
            <img src="themes/fitculator/images/logo.png" alt="Fitculator.com" />
			</a>
        </div>      
        <div class="nav theme">
				<!-- <a href="#"><i class="lang" aria-hidden="true" onclick="changelang('geo')"> ქარ </i></a>
                <a href="#"><i class="lang" aria-hidden="true" onclick="changelang('eng')"> ENG </i></a>
                <a href="#"><i class="lang" aria-hidden="true" onclick="changelang('rus')"> РУС </i></a> -->
			<div class="agile_social_icons_banner">
                <ul class="agileits_social_list">
                    <!-- <li><a href="#"><i class="lang" aria-hidden="true" onclick="changelang('geo')"> ქარ </i></a></li>
                    <li><a href="#"><i class="lang" aria-hidden="true" onclick="changelang('eng')"> ENG </i></a></li>
                    <li><a href="#"><i class="lang" aria-hidden="true" onclick="changelang('rus')"> РУС </i></a></li> -->
					<li style="color: white;"><?php 
						if(isset($_SESSION['fb_access_token']))
						{
							//echo $fbapi->Login_User_Email;
							echo $_SESSION["username"];
						}
						else
						{
							 echo $fbapi->Login(); 
						}
						?>
                        <!--<img src="themes/fitculator/images/fb.png" alt="Fitculator.com" style="width: 40%;" />-->
                        </li>
					<li style="color: white;">
						<?php
							if(isset($_SESSION["username"]))
							{
								echo '<a href="logout.php">'.$dictionary->get_text("text.LogOut").'</a>';
							}
						?>
					</li>
                </ul>
            </div>

        </div>
        <div class="mob__menu">
            <svg>
                <use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
            </svg>
        </div>
        <div class="mob__nav theme">
            <div class="header">
                <div class="logo">
                    <img src="themes/fitculator/images/logo.png" alt="Fitculator.com" />
                </div>
                <div class="close">
                    <svg>
                        <use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
                    </svg>
                </div>
            </div>
            <div class="list"></div>
        </div>
    </header>

        <section class="question">
            <div class="question__nav theme">
                <a class="question__back" href="javascript:void(0)">
                    <svg>
                        <use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-43"></use>
                    </svg>
                    <div class="question_text"><?php echo $dictionary->get_text("text.BACK"); ?></div>
                </a>
            </div>
        </section>
        <section class="main container">
            <div class="text-plan"><?php echo $dictionary->get_text("text.FIRSTPAGE_TITLE"); ?></div>
            <div class="main__header">
                <div class="h1"> <b><?php echo $dictionary->get_text("text.SELECT_GENDER"); ?></b></div>
            </div>
            <div class="main__test choose-gender">
                <fieldset class="female">
                    <a href="steps.php" onclick="$('#gotostep1').submit();return true;">
                        <legend><?php echo $dictionary->get_text("text.FEMALE"); ?></legend><img src="themes/fitculator/img/png/Asset1.png" alt="">
                    </a>
                </fieldset>
                <p>or</p>
                <fieldset class="male">
                    <a href="steps.php" onclick="$('#gotostep1').submit();return true;">
                        <legend><?php echo $dictionary->get_text("text.MALE"); ?></legend><img src="themes/fitculator/img/png/Asset3.png" alt="">
                    </a>
                </fieldset>
            </div>
            <div class="main__gender"></div>
        </section>
    <footer class="container">
        <div class="copyright"></div>
        <div class="footer-text">
            <?php echo $dictionary->get_text("text.FOOTER_TEXT"); ?>
        </div>
    </footer>    
	<form method='post' id="gotostep1" action="steps.php">
        <input type='hidden' name='bidding' value='1' />
    </form>
    <script src="themes/fitculator/js/vendor.js"></script>
    <script src="/js/base.js"></script>
    <script src="themes/fitculator/js/main.js"></script>



    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141661089-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-141661089-1');
    </script>
    <!-- Serge Global site tag (gtag.js) - Google Ads: 672830691 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-672830691"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'AW-672830691');
    </script>
    <!-- Hotjar Tracking Code for https://{$.server.HTTP_HOST} -->
    <script>
        (function (h, o, t, j, a, r) {
            h.hj = h.hj || function () { (h.hj.q = h.hj.q || []).push(arguments) };
            h._hjSettings = { hjid: 1353207, hjsv: 6 };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script'); r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>
    <!-- Facebook Pixel Code General -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '453047072138307');
        fbq('init', '344937266424420');
        fbq('init', '829419397495962');
        fbq('init', '672180713550058');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=453047072138307&ev=PageView
  &noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code General -->
    <!-- Serge Bing -->
    <script>(function (w, d, t, r, u) { var f, n, i; w[u] = w[u] || [], f = function () { var o = { ti: "27004969" }; o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad") }, n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function () { var s = this.readyState; s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null) }, i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i) })(window, document, "script", "//bat.bing.com/bat.js", "uetq");</script>
    <!-- Serge Bing -->
    <!-- Start Bing 247 -->
    <script>(function (w, d, t, r, u) { var f, n, i; w[u] = w[u] || [], f = function () { var o = { ti: "17225492" }; o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad") }, n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function () { var s = this.readyState; s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null) }, i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i) })(window, document, "script", "//bat.bing.com/bat.js", "uetq");</script>
    <!-- End Bing 247 -->
    <!-- Start ActiveCampaign -->
    <script type="text/javascript">
        (function (e, t, o, n, p, r, i) { e.visitorGlobalObjectAlias = n; e[e.visitorGlobalObjectAlias] = e[e.visitorGlobalObjectAlias] || function () { (e[e.visitorGlobalObjectAlias].q = e[e.visitorGlobalObjectAlias].q || []).push(arguments) }; e[e.visitorGlobalObjectAlias].l = (new Date).getTime(); r = t.createElement("script"); r.src = o; r.async = true; i = t.getElementsByTagName("script")[0]; i.parentNode.insertBefore(r, i) })(window, document, "https://diffuser-cdn.app-us1.com/diffuser/diffuser.js", "vgo");
        vgo('setAccount', '649705795');
        vgo('setTrackByDefault', true);

        vgo('process');
    </script>
    <!-- End ActiveCampaign -->
    <!-- Snap Pixel Code Elias -->
    <script type='text/javascript'>
        (function (e, t, n) {
            if (e.snaptr) return; var a = e.snaptr = function () { a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments) };
            a.queue = []; var s = 'script'; r = t.createElement(s); r.async = !0;
            r.src = n; var u = t.getElementsByTagName(s)[0];
            u.parentNode.insertBefore(r, u);
        })(window, document,
            'https://sc-static.net/scevent.min.js');

        snaptr('init', 'f4b05c04-8e6e-4aa2-a30d-9fbc187bed2c', {
            'user_email': '__INSERT_USER_EMAIL__'
        });

        snaptr('track', 'PAGE_VIEW');

    </script>
    <!-- End Snap Pixel Code Elias -->

    <div style='position: fixed; z-index: -1; top: 100%; height: 0 !important; width: 0 !important; line-height: 0 !important; font-size: 0 !important; opacity: 0;'>
    </div>
</body>
</html>