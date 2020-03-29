<?php
	require_once("header_template.php");
?>
<body class="steps-page">
	<header class="container">
		<div class="logo">
			<img src="themes/fitculator/images/logo.png" alt="Fitculator.com" />
		</div>      
		
		<!--
		<div class="nav theme">
			<div class="agile_social_icons_banner">
				<ul class="agileits_social_list">
					<li><a href="#"><i class="lang" aria-hidden="true" onclick="changelang('geo')"> ქარ </i></a></li>
					<li><a href="#"><i class="lang" aria-hidden="true" onclick="changelang('eng')"> ENG </i></a></li>
					<li><a href="#"><i class="lang" aria-hidden="true" onclick="changelang('rus')"> РУС </i></a></li>
				</ul>
			</div>
		</div>
		-->

		<div class="mob__menu">
			<svg>
				<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
			</svg>
		</div>
		<div class="mob__nav theme">
			<div class="header">
				<div class="logo">
					<img src="themes/fitculator/images/logo.png" alt="Fitculator.com" />
					<!-- Fitculator.com -->
				</div>          <div class="close">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
					</svg>
				</div>
			</div>
			<div class="list"></div>
		</div>
	</header>

	<main>
		<section class="question">
			<div class="question__nav theme">
				<a class="question__back" href="javascript:void(0)">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-43"></use>
					</svg>
					<div class="question_text"><?PHP echo BACK; ?></div>
				</a>
			</div>
		</section>
		<section class="main container">

			<div class="main__step active" data-step="23%" id="naxshirwylebi">
				<div class="question__help">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="question_text"><?php echo Help; ?></div>
				</div>
				<div class="question__help-window theme">
					<div class="question__help-window-close">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
						</svg>
					</div>
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="answer"><?php echo DAIRY_ANSWER; ?></div>
				</div>
				<div class="main__header">
					<!--p.main__header-action Please click to include <br>products you like-->
					<div class="h1"><b><?php echo "ცხიმები"; ?></b></div>
					<p class="main__header-action"><?php echo WICH_PRODUCT; ?></p>
					<svg class="main__icon">
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-31"></use>
					</svg>
					<div class="mob-helper"><?php echo SELECT_TO_REMOVE; ?></div>
				</div>
				<div class="main__test multi-svg-choose">
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-24"></use>
						</svg><span data-answer="egg"><?php echo "ჰერკულესი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-21"></use>
						</svg><span data-answer="soy_milk"><?php echo "ბრინჯი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-20"></use>
						</svg><span data-answer="cheese"><?php echo "წიწიბურა"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-23"></use>
						</svg><span data-answer="nuts"><?php echo "მოხარშული კარტოფილი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-22"></use>
						</svg><span data-answer="yogurt"><?php echo "სპაგეტი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ჭვავის პური"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "იოგურტი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "კეფირი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "რძე"; ?></span>
					</div>
					<p class="test-multi-svg-answer next-question"> <?php echo CONTI; ?></p>
				</div>
			</div>
			<div class="main__step" data-step="37%" id="cilebi">
				<div class="question__help">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="question_text"><?php echo Help; ?></div>
				</div>
				<div class="question__help-window theme">
					<div class="question__help-window-close">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
						</svg>
					</div>
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="answer"><?php echo PROTAIN_ANSWER; ?></div>
				</div>
				<div class="main__header">
					<!--p.main__header-action Please click to include <br>products you like-->
					<div class="h1"><b><?php echo Protein ?></b></div>
					<p class="main__header-action"><?php echo WICH_PRODUCT; ?></p>
					<svg class="main__icon">
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-38"></use>
					</svg>
					<div class="mob-helper"><?php echo SELECT_TO_REMOVE ?></div>
				</div>
				<div class="main__test multi-svg-choose">
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-01"></use>
						</svg><span data-answer="chicken"><?php echo EGG; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-03"></use>
						</svg><span data-answer="beef"><?php echo BEEF; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-02"></use>
						</svg><span data-answer="fish"><?php echo FISH; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-04"></use>
						</svg><span data-answer="turkey"><?php echo CHICKEN; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-04"></use>
						</svg><span data-answer="turkey"><?php echo "ინდაური"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-05"></use>
						</svg><span data-answer="pork"><?php echo "ხაჭო"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-05"></use>
						</svg><span data-answer="pork"><?php echo "კრევეტები"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-23"></use>
						</svg><span data-answer="nuts"><?php echo NUTS; ?></span>
					</div>
					<div class="none" data-multi-choose="no-check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-06"></use>
						</svg><span data-answer="no"><?php echo NO_ANIMALS; ?></span>
					</div>
					<p class="test-multi-svg-answer next-question"> <?php echo CONTI; ?>  </p>
				</div>
			</div>
			<div class="main__step" data-step="63%" id="cximebi">
				<div class="question__help">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="question_text"><?php echo Help; ?></div>
				</div>
				<div class="question__help-window theme">
					<div class="question__help-window-close">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
						</svg>
					</div>
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="answer"><?php echo DAIRY_ANSWER; ?></div>
				</div>
				<div class="main__header">
					<!--p.main__header-action Please click to include <br>products you like-->
					<div class="h1"><b><?php echo "ცხიმები"; ?></b></div>
					<p class="main__header-action"><?php echo WICH_PRODUCT; ?></p>
					<svg class="main__icon">
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-31"></use>
					</svg>
					<div class="mob-helper"><?php echo SELECT_TO_REMOVE; ?></div>
				</div>
				<div class="main__test multi-svg-choose">
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-24"></use>
						</svg><span data-answer="egg"><?php echo EGG; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-21"></use>
						</svg><span data-answer="soy_milk"><?php echo "ზეითუნის ზეთი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-20"></use>
						</svg><span data-answer="cheese"><?php echo CHEESE; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-23"></use>
						</svg><span data-answer="nuts"><?php echo "არაქისის კარაქი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-22"></use>
						</svg><span data-answer="yogurt"><?php echo "მზესუმზირა"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "არაჟანი"; ?></span>
					</div>
					<p class="test-multi-svg-answer next-question"> <?php echo CONTI; ?></p>
				</div>
			</div>
			<div class="main__step" data-step="75%" id="bostneuli">
				<div class="question__help">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="question_text"><?php echo Help; ?></div>
				</div>
				<div class="question__help-window theme">
					<div class="question__help-window-close">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
						</svg>
					</div>
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="answer"><?php echo VEGIES_ANSWER; ?></div>
				</div>
				<div class="main__header">
					<!--p.main__header-action Please click to include <br>products you like-->
					<div class="h1"><b><?php echo VEGGIES ?></b></div>
					<p class="main__header-action"><?php echo WICH_PRODUCT; ?></p>
					<svg class="main__icon">
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-37"></use>
					</svg>
					<div class="mob-helper"><?php echo SELECT_TO_REMOVE; ?></div>
				</div>
				<div class="main__test multi-svg-choose">
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-01"></use>
						</svg><span data-answer="bell_peppers"><?php echo BELL_PEPPERS; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-02"></use>
						</svg><span data-answer="green_beans"><?php echo GREEN_BEANS; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-03"></use>
						</svg><span data-answer="ZUCCHINI"><?php echo "ბადრიჟანი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-07"></use>
						</svg><span data-answer="broccoli"><?php echo BROCCOLI; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-02"></use>
						</svg><span data-answer="broccoli"><?php echo "წითელი ლობიო"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="broccoli"><?php echo "სალათის ფურცელი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-05"></use>
						</svg><span data-answer="mushrooms"><?php echo MUSHROOMS; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "ზეთის ხილი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "კიტრი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "პომიდორი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "ისპანახი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "მწვანილი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "ბოლოკი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "გოგრა"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-04"></use>
						</svg><span data-answer="cauliflower"><?php echo "ჭარხალი"; ?></span>
					</div>
					<p class="test-multi-svg-answer next-question"> <?php echo CONTI; ?></p>
				</div>
			</div>
			<div class="main__step" data-step="88%" id="xili">
				<div class="question__help">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="question_text"><?php echo Help; ?></div>
				</div>
				<div class="question__help-window theme">
					<div class="question__help-window-close">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
						</svg>
					</div>
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="answer"><?php echo DAIRY_ANSWER; ?></div>
				</div>
				<div class="main__header">
					<!--p.main__header-action Please click to include <br>products you like-->
					<div class="h1"><b><?php echo "ცხიმები"; ?></b></div>
					<p class="main__header-action"><?php echo WICH_PRODUCT; ?></p>
					<svg class="main__icon">
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-31"></use>
					</svg>
					<div class="mob-helper"><?php echo SELECT_TO_REMOVE; ?></div>
				</div>
				<div class="main__test multi-svg-choose">
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-24"></use>
						</svg><span data-answer="egg"><?php echo "გრეიფრუტი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-21"></use>
						</svg><span data-answer="soy_milk"><?php echo "ფორთოხალი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-20"></use>
						</svg><span data-answer="cheese"><?php echo "ანანასი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-23"></use>
						</svg><span data-answer="nuts"><?php echo "ბანანი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-22"></use>
						</svg><span data-answer="yogurt"><?php echo "ავოკადო"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ქოქოსი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ვაშლი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "მარწყვი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ლიმონი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "კომში"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ალუჩა"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ალუბალი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ბროწეული"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "მსხალი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ლეღვი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "შინდი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ატამი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ქლიავი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ხურმა"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ბალი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "თუთა"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "მანდარინი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ყირძენი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "მაყვალი"; ?></span>
					</div>
					<div data-multi-choose="check">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-19"></use>
						</svg><span data-answer="tofu"><?php echo "ჟოლო"; ?></span>
					</div>
					<p class="test-multi-svg-answer next-question"> <?php echo CONTI; ?></p>
				</div>
			</div>
			<div class="main__step" data-step="100%" id="characteristics">
				<div class="question__help">
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="question_text"><?php echo Help; ?></div>
				</div>
				<div class="question__help-window theme">
					<div class="question__help-window-close">
						<svg>
							<use xlink:href="themes/fitculator/img/sprite.svg#close-01"></use>
						</svg>
					</div>
					<svg>
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
					</svg>
					<div class="answer"><?php echo MEASUREMENTS_ANSWER; ?></div>
				</div>
				<div class="main__header">
					<!--p.main__header-action enter-->
					<div class="h1"><b><?php echo MEASUREMENTS; ?></b></div>
					<!-- <div class="h1"><b>Personal <br>feature</b></div> -->
					<svg class="main__icon">
						<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-35"></use>
					</svg>
				</div>
				<div class="main__test tabs-form">
					<div class="switch-field">
						<input class="metr" type="radio" id="switch_left" name="switch_2" value="yes" checked>
						<label for="switch_left"><?php echo METRIC; ?></label>
						<input type="radio" id="switch_right" name="switch_2" value="no">
						<label for="switch_right"><?php echo IMPERIAL; ?></label>
					</div>
					<div class="form-menu">
						<script>
							function alphaOnly(event) {
								var key = event.keyCode;
								return ((key >= 65 && key <= 90) || key == 8 || key == 9);
							};
						</script>
						<form id="imperial">
							<label class="stop">
								<svg>
									<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-08"></use>
								</svg>
								<input name="age" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo AGE; ?>"><span><?php echo YEARS; ?></span>
								<p class="err"></p>
							</label>
							<label class="stop half">
								<svg>
									<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-09"></use>
								</svg>
								<input name="ft" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo ' '.FT  ?>"><span><?php echo FT; ?></span>
								<p class="err"></p>
							</label>
							<label class="stop">
								<input name="inch" type="tel" pattern="[0-9]*" autocomplete="off" placeholder=" <?php echo INCH; ?>"><span><?php echo INCH; ?></span>
								<p class="err"></p>
							</label>
							<label class="stop">
								<svg>
									<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-10"></use>
								</svg>
								<input name="weight" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo WEIGHT_LB; ?>"><span><?php echo LB; ?></span>
								<p class="err"></p>
							</label>
							<label class="stop">
								<svg>
									<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-11"></use>
								</svg>
								<input name="target" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo TARGET_WEIGHT_LB; ?>"><span><?php echo LB; ?></span>
								<p class="err"></p>
							</label>
							<label class="stop">
								<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54 53"><defs><style>
																																	   .cls-1 {
																																		   fill: #00b0ea;
																																	   }
								</style></defs><title>Untitled-2</title><path class="cls-1" d="M42.5,12h-30A2.5,2.5,0,0,0,10,14.5v27A2.5,2.5,0,0,0,12.5,44h30A2.5,2.5,0,0,0,45,41.5v-27A2.5,2.5,0,0,0,42.5,12Zm0,1a1.51,1.51,0,0,1,.64.15L27.5,26.84,11.86,13.15A1.51,1.51,0,0,1,12.5,13ZM11.16,42.16l.68.68A1.49,1.49,0,0,1,11.16,42.16ZM44,41.5a1.48,1.48,0,0,1-.81,1.32l.66-.68-11-10.5-.7.72,11,10.49a1.51,1.51,0,0,1-.64.15h-30a1.51,1.51,0,0,1-.64-.15l10.49-10.5-.7-.7L11.15,42.14A1.51,1.51,0,0,1,11,41.5v-27a1.5,1.5,0,0,1,.76-1.3l-.59.68L27.5,28.16,43.83,13.88l-.59-.68A1.5,1.5,0,0,1,44,14.5Z" /></svg>
								<input name="email" type="email" autocomplete="off" placeholder="<?php echo EMAIL; ?>">
								<p class="err"></p>
							</label>
							<button onclick="submitStepOne()" class="next-question"><?php echo CONTI; ?></button>

						</form>
						<form class="active" id="metric">
							<form id="metric">
								<label class="stop">
									<svg>
										<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-08"></use>
									</svg>
									<input name="age" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="Age"><span><?php echo YEARS; ?></span>
									<p class="err"></p>
								</label>
								<label class="stop">
									<svg>
										<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-09"></use>
									</svg>
									<input name="height" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo HEIGHT_CM; ?>"><span><?php echo CM; ?></span>
									<p class="err"></p>
								</label>
								<label class="stop">
									<svg>
										<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-10"></use>
									</svg>
									<input name="weight" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo WEIGHT_KG; ?>"><span><?php echo KG; ?></span>
									<p class="err"></p>
								</label>
								<label class="stop">
									<svg>
										<use xlink:href="themes/fitculator/img/sprite.svg#_icon_-11"></use>
									</svg>
									<input name="target" type="tel" pattern="[0-9]*" autocomplete="off" placeholder="<?php echo TARGET_WEIGHT_KG; ?>"><span><?php echo KG; ?></span>
									<p class="err"></p>
								</label>
								<label class="stop">
									<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54 53"><defs><style>
																								  }
									</style></defs><title>Untitled-2</title><path class="cls-1" d="M42.5,12h-30A2.5,2.5,0,0,0,10,14.5v27A2.5,2.5,0,0,0,12.5,44h30A2.5,2.5,0,0,0,45,41.5v-27A2.5,2.5,0,0,0,42.5,12Zm0,1a1.51,1.51,0,0,1,.64.15L27.5,26.84,11.86,13.15A1.51,1.51,0,0,1,12.5,13ZM11.16,42.16l.68.68A1.49,1.49,0,0,1,11.16,42.16ZM44,41.5a1.48,1.48,0,0,1-.81,1.32l.66-.68-11-10.5-.7.72,11,10.49a1.51,1.51,0,0,1-.64.15h-30a1.51,1.51,0,0,1-.64-.15l10.49-10.5-.7-.7L11.15,42.14A1.51,1.51,0,0,1,11,41.5v-27a1.5,1.5,0,0,1,.76-1.3l-.59.68L27.5,28.16,43.83,13.88l-.59-.68A1.5,1.5,0,0,1,44,14.5Z" /></svg>
									<input name="email" type="email" autocomplete="off" placeholder="<?php echo EMAIL; ?>">
									<p class="err"></p>
								</label>
								<!--a.next-question Continue-->
								<!--label-->
								<button onclick="submitStepOne()" class="next-question"><?php echo CONTI; ?></button>
							</form>
							<form method='post' id="gotostep3">
								<input type='hidden' name='test_results' value='' />
								<input type='hidden' name='customer_data' value='' />
								<input type='hidden' name='user_shipping_fname' value='' />
								<input type='hidden' name='user_shipping_lname' value='' />
								<input type='hidden' name='user_email' value='' />
								<input type='hidden' name='user_shipping_country' value='GE' />
							</form>
					</div>

					<div class="carousel carousel-eat">
						<div class="owl-carousel">
							<div class="carousel-item">
								<img src="themes/fitculator/images/eat/4.jpg" alt="">
							</div>
							<div class="carousel-item">
								<img src="themes/fitculator/images/eat/1.jpg" alt="">
							</div>
							<div class="carousel-item">
								<img src="themes/fitculator/images/eat/3.jpg" alt="">
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="main__gender">
				<fieldset class="theme">
					<a>
						<legend class="female"><?php echo FEMALE; ?></legend>
						<legend class="male"><?php echo MALE; ?></legend><img class="female" src="themes/fitculator/img/png/Asset1.png" alt=""><img class="male" src="themes/fitculator/img/png/Asset3.png" alt="">
					</a>
				</fieldset>
			</div>
		</section>
		<section class="product-modal">
			<div class="product-modal__back"></div>
			<div class="product-modal__body">
				<svg>
					<use xlink:href="themes/fitculator/img/sprite.svg#_icon_set-44"></use>
				</svg>
				<p>You haven't select any product. Please select few products in order to get a complete and diversified meal plan. If you don't want to select any product please continue.</p>
				<div class="product-modal__action">
					<div class="close">Select more</div>
					<div class="next-question no-choosen"><?php echo CONTI; ?></div>
				</div>
			</div>
		</section>
		<section class="steps container theme">
			<div class="steps_allsteps">
				<a class="step complete" href="javascript:void(0)"><?php  echo GENDER; ?></a>
				<a class="step" href="javascript:void(0)"><?php echo "ნახშირწყლები"; ?></a>
				<a class="step active" href="javascript:void(0)"><?php echo Protein ?></a>
				<a class="step" href="javascript:void(0)"><?php echo "ცხიმები" ?></a>
				<a class="step" href="javascript:void(0)"><?php echo VEGGIES; ?></a>
				<a class="step" href="javascript:void(0)"><?php echo "ხილი"; ?></a>
				<a class="step" href="javascript:void(0)"><?php echo MEASUREMENTS; ?></a>
			</div>
			<div class="steps_line">
				<div class="steps_line__progress"></div>
				<div class="steps_line__text"><span>23 %</span></div>
			</div>
		</section>
	</main>
	<footer class="container">
		<div class="nav theme male">
			<a href="javascript:void(0);" onclick="docs.open('privacy-policy');return false;">Privacy Policy</a>
			<a href="javascript:void(0);" onclick="docs.open('terms');return false;">General Conditions</a>
			<a href="javascript:void(0)" onclick="docs.open('policy');return false;">Data Protection policy</a>
			<a href="javascript:void(0)" onclick="docs.open('cookies');return false;">Cookie policy</a>
		</div>

		<div class="footer-text">
			<?php echo FOOTER_TEXT; ?><
		</div>
	</footer>
	<script src="themes/fitculator/js/vendor.js"></script>
	<script src="/js/base.js"></script>
	<script src="/js/email-autocomplete.js"></script>
	<script src="themes/fitculator/js/main.js"></script>
	<script src="themes/fitculator/js/owl.carousel.min.js"></script>
	<script>
		function submitStepOne() {

			setTimeout(function () {
				var data = localStorage.getItem('data');
				var data_from = JSON.parse(data);
				console.log(data_from)
				var measurements = data_from[9].measurements;
				var mail = data_from[9].measurements.email;

				$('#gotostep3 input[name=test_results]').val(data);
				$('#gotostep3 input[name=user_email]').val(mail);


				delete measurements.email;
				measurements.gender = data_from[0].gender;
				$('#gotostep3 input[name=customer_data]').val(JSON.stringify(measurements));
				$('#gotostep3').submit();
			}, 500);
			return false;

		}

		$(document).on('keypress', '#imperial, #metric', function (e) {
			var count = 0;
			if (e.which == 13) {
				$(this).find('input[name="email"]').blur();
				$(this).find('input').each(function (index, el) {
					if ($(el).closest('label').hasClass('stop') || $(el).closest('label').hasClass('inval')) {
						count++;
					}
				});

				if ($(this).attr('id') === 'metric' && count !== 0 || $(this).attr('id') === 'imperial' && count !== 0) return false;
			}
		});
	</script>




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


	<script>
		function handleOutboundLinkClicks(category) {
			gtag('event', 'opened', {
				'event_category': category,
				'event_label': 'calculator'
			});
		}

		$(document).ready(function () {
			handleOutboundLinkClicks('1_gender');

			var isOnIOS = navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPhone/i);
			var eventName = isOnIOS ? "pagehide" : "beforeunload";
			window.addEventListener(eventName, function (event) {
				window.event.cancelBubble = true;
				var result = [];

				if ($('#imperial').hasClass('active')) {
					$('#imperial input').each(function (idx, value) {
						if (value.value != '' && result.indexOf(value.name) === -1) {
							if (value.name === 'ft' || value.name === 'inch') {
								if (result.indexOf('height') === -1) {
									result.push('height');
								}
							} else {
								result.push(value.name);
							}
						}
					});
				} else if ($('#metric').hasClass('active')) {
					$('#metric input').each(function (idx, value) {
						if (value.value != '' && result.indexOf(value.name) === -1) {
							result.push(value.name);
						}
					});
				}

				if ($('#characteristics').hasClass('active') && result.length === 0) {
					result = ['Nothing'];
				}

				gtag('event', 'closed', {
					'event_category': result.join(', '),
					'event_label': 'calculator'
				});
			});

			function gaSend(element) {
				$(element[0] + ' .next-question').on('click', function () {
					handleOutboundLinkClicks(element[1])
				});
			}

			gaSend(['#protein', '2_protein']);
			gaSend(['#veggies', '3_veggies']);
			gaSend(['#fruit', '4_fruit']);
			gaSend(['#products', '5_products']);
			gaSend(['#activity', '6_physical activity']);
			gaSend(['#lifestyle', '7_lifestyle']);
		});
	</script>
	<script>
		fbq('track', 'ViewContent');
	</script>












	<div style='position: fixed; z-index: -1; top: 100%; height: 0 !important; width: 0 !important; line-height: 0 !important; font-size: 0 !important; opacity: 0;'>
	</div>
	<script>
		$(document).ready(function () {
			if ($('.carousel').length > 0) {
				$('.carousel').css({ 'opacity': 0 })
				$('#lifestyle .next-question').on('click', function () {
					setTimeout(function () {
						$('.carousel').css({ 'opacity': 1 })
					}, 500)
				})

				$('.carousel .owl-carousel').owlCarousel({
					loop: true,
					margin: 14,
					nav: false,
					responsive: {
						0: {
							items: 1
						},
						420: {
							items: 2
						},
						670: {
							items: 3
						}
					}
				})
			}

			$('#imperial input[type="email"], #metric input[type="email"]').blur(function (e) {
				if ($(this).closest('label').hasClass('inval')) {
					$.ajax({
						type: 'POST',
						url: 'https://fitculator.com/debug.php',
						dataType: 'json',
						data: { 'wrong_email': e.target.value }
					});
				}
			});
		});
	</script>

</body>
</html>
<!--svg-->
<!--    use(xlink:href="themes/fitculator/img/sprite.svg#404")-->