<div class="container-fluid">

    <div class="panel panel-dark table-wrapper">

        <div class="panel-heading">

            ტექსტები

            <form id="search-form">

                <div class="input-group">

                    <input type="text" class="form-control" id="search-input" placeholder="Search Text">

                    <span class="input-group-btn">

                        <button class="btn btn-default" type="submit">Search</button>

                    </span>

                </div>

            </form>

        </div>

        <div class="panel-body">

            <div class="progress hidden" style="height: 5px">

                <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%"></div>

            </div>

            <table class="table table-responsive hidden" id="text-list-table">

                <tr>

                    <td class="key">

                        <input class="form-control" readonly type="text" name="Dictionary_Key">

                        <span></span>

                    </td>

                    <td class="val_ge">

                        <input class="form-control" type="text" name="Dictionary_value_ge">

                        <span></span>

                    </td>

                    <td class="val_en">

                        <input class="form-control" type="text" name="Dictionary_value_eng">

                        <span></span>

                    </td>

                    <td class="button" style="width: 200px">

                        <button type="button" class="edit-button btn btn-primary">

                            <i class="glyphicon glyphicon-pencil"></i>

                        </button>

                        <div class="btn-group">

                            <button type="button" class="save-button btn btn-success">

                                <i class="glyphicon glyphicon-ok"></i>

                            </button>

                            <button type="button" class="cancel-button btn btn-danger">

                                <i class="glyphicon glyphicon-remove"></i>

                            </button>

                        </div>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>



<script>

    $(document).ready(function () {

        var $table = $('#text-list-table');

        var $tr = $table.children(":first").clone();

        $table.html('').removeClass('hidden');

        $('#search-form').on('submit', function (e) {

            e.preventDefault();

            var datalist_value = $('#search-input').val();

            if(datalist_value.length >= 3){

                $('.progress').removeClass('hidden');

                $table.html('');

                $.ajax({

                    type: 'POST',

                    url: "/dictionary_find.php",

                    data: {

                        datalist_value : datalist_value

                    }

                }).done(function (data) {

                    $('.progress').addClass('hidden');

                    obj1 = JSON.parse(data);

                    if(obj1[0].status_code === 200){

                        var textList = obj1[0].response_text;

                        if (textList.length) {

                            for (var i in textList) {

                                var textData = textList[i];

                                var newRow = $tr.clone();

                                newRow.find('.key span').html(textData.Dictionary_Key);

                                newRow.find('.key').find('input[name=Dictionary_Key]').val(textData.Dictionary_Key);

                                newRow.find('.val_ge span').html(textData.Dictionary_value_ge);

                                newRow.find('.val_ge').find('input[name=Dictionary_value_ge]').val(textData.Dictionary_value_ge);

                                newRow.find('.val_en span').html(textData.Dictionary_value_eng);

                                newRow.find('.val_en').find('input[name=Dictionary_value_eng]').val(textData.Dictionary_value_eng);

                                $table.append(newRow)

                            }

                        } else {

                            $table.html('No Result');

                        }

                    }

                });

            }



        })



        $(document).on('click', '.edit-button', function(e) {

            var $parentTr = $(this).closest('tr');

            $parentTr.addClass('changing');

        });



        $(document).on('click', '.cancel-button', function(e) {

            var $parentTr = $(this).closest('tr');

            $parentTr.removeClass('changing');

        });



        $(document).on('click', '.save-button', function(e) {

            var $parentTr = $(this).closest('tr');

            var key = $parentTr.find('input[name=Dictionary_Key]').val();

            var geValue = $parentTr.find('input[name=Dictionary_value_ge]').val();

            var enValue = $parentTr.find('input[name=Dictionary_value_eng]').val();

            if (key && geValue && enValue) {

                $.ajax({

                    type: 'POST',

                    url: "../../controler/admin/dictionary_change.php",

                    data: {

                        dictionary_key : key,

                        Dictionary_value_ge : geValue,

                        Dictionary_value_eng : enValue

                    }

                }).done(function (data) {

                    obj1 = JSON.parse(data);

                    len=obj1.length;

                    //alert (len);

                    bootbox.alert(obj1[len-2].response_text);

                    $parentTr.find('.val_ge span').html(geValue);

                    $parentTr.find('.val_en span').html(enValue);

                    $parentTr.removeClass('changing');

                });

            }

        });

    })

</script>



<style>

    #text-list-table tr input, #text-list-table tr .btn-group {

        display: none;

    }

    #text-list-table tr.changing input, #text-list-table tr.changing .btn-group {

        display: initial;

    }

    #text-list-table tr.changing span, #text-list-table tr.changing .edit-button {

        display: none;

    }

</style>





<?php if (false) { ?>

<div class="modal fade" id="myModal" role="dialog">

   <div class="modal-dialog">

      <!-- Modal content-->

      <div class="modal-content">

         <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">შეტყობინება</h4>

         </div>

         <div class="modal-body">

            <p id="backError">შეტყობინების ტექსტი</p>

            <p id="all_field_require"></p>

            <p id="private_number_require" style="display:none"></p>

         </div>

         <div class="modal-footer">

            <button type="button" class="btn btn-default" style="color: #FFF !important; background-color: #337ab7; " data-dismiss="modal">Close</button>

         </div>

      </div>

   </div>

</div>





<div class="wrapper-md">



      <!-- stats -->



<div class="row">



<div class="col-md-10 col-md-offset-1">



<div class="panel-heading wrapper b-b b-light">

<div class="row">

<div class="col-md-5 col-md-offset-1">

	<i class="fa fa-arrow"></i>

    <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo  $dictionary->get_text("text.dictionary");  ?></h4>

</div>

<div class="col-md-5 col-md-offset-1">

	<form method="post">

    	<input name="datalist_value" placeholder="Search Text" id="field" list="datal" style="float: right; width: 100%; border-radius: 4px; height: 40px; border: none; text-indent: 10px;">

    	<datalist id="datal">







    	</datalist>

    </form>

</div>

</div>















<div class="row">



	<form>

		<div class="col-md-3 col-md-offset-1">

			<input name="search_dictionary">

		</div>



		<div class="col-md-3 col-md-offset-1">

			<input name="search_dictionary">

		</div>



		<div class="col-md-3 col-md-offset-1">

			<input name="search_dictionary">

		</div>

	</form>





	<table id="t1" class="t1" border="1">



	</table>





</div>





</div>





</div>



</div>



</div>







<style>



.col-md-5, .col-md-3 {



    padding:12px 12px;



}



.col-md-5 div {



    font-weight:bold;



    padding-top:5px;



}



.col-md-5 div span {



    font-weight:none !important



}



.col-md-9, .col-md-10 {



    background-color:#3a3f51 !important;



    margin-top:12px;



    color:white



}



.t1{

	margin-top: 20px;

    font-size: 12px !important;

}



.t1 td{

	padding: 12px;

}



.t1 ul, .t1 li, .t1 p, .t1 span{

	font-size: 14px !important;

	color: #fff !important;

	font-weight: normal !important;

}



input{

	color:#000 !important;

}



</style>

<script type="text/javascript">





$( document ).ready(function() {





//setup before functions

	let typingTimer;                //timer identifier

	let doneTypingInterval = 1000;  //time in ms (3 seconds)

	let myInput = document.getElementById('field');



	//on keyup, start the countdown

	myInput.addEventListener('keyup', () => {

	    clearTimeout(typingTimer);

	    if (myInput.value) {

	        typingTimer = setTimeout(doneTyping, doneTypingInterval);

	    }

	});



	//user is "finished typing," do something

	function doneTyping () {

	  var datalist_value=$("[name='datalist_value']").val();



		if(datalist_value.length >= 3){

			document.getElementById("t1").innerHTML = '';

			$.ajax({

				type: 'POST',

				url: "../../controler/admin/dictionary_find.php",

				data: {

					datalist_value : datalist_value

				}

			}).done(function (data) {

				obj1 = JSON.parse(data);

				//console.log(obj1);



				if(obj1[0].status_code == 200){

					obj2 = obj1[0].response_text;

					//console.log(obj2);



					var x = obj2.length;



					for(var i=0; i<x; i++){

						document.getElementById("t1").innerHTML += `<tr>

						<td id='Dictionary_Key`+i+`'>`+ obj2[i].Dictionary_Key +`</td>

						<td  contenteditable='true' id='Dictionary_value_ge`+i+`'>`+ obj2[i].Dictionary_value_ge +`</td>

						<td  contenteditable='true' id='Dictionary_value_eng`+i+`'>`+ obj2[i].Dictionary_value_eng +`</td>

						<td> <button class="btn" style="background-color: #337ab7; color: #FFF !important;" name="`+obj2[i].Dictionary_Key+`" id='Dictionary_value_eng`+i+`'

								onclick="change_info('Dictionary_Key`+i+`','Dictionary_value_ge`+i+`','Dictionary_value_eng`+i+`')"



								> Edit </button> </td>

						</tr>`;



						document.getElementById("datal").innerHTML += `

						<option value='`+ obj2[i].Dictionary_Key +`'>

						<option value='`+ obj2[i].Dictionary_value_ge +`'>

						<option value='`+ obj2[i].Dictionary_value_eng +`'>`;

					}



				}

			});

		}else{

			document.getElementById("t1").innerHTML = '';

		}

	}





});



	function change_info(dictionary,value_ge,value_en)

	{

		var dictionary1=document.getElementById(dictionary).innerText;

		var value_ge1=document.getElementById(value_ge).innerText;

		var value_en1=document.getElementById(value_en).innerText;

		var a="dictionary: "+dictionary1+'<br> value_ge: '+value_ge1+' <br> value_en: '+value_en1;

		//alert(a);



		if( typeof dictionary1!=="undefined" && typeof value_ge1!=="undefined" && typeof value_en1!=="undefined")

		{



			$.ajax({

				type: 'POST',

				url: "../../controler/admin/dictionary_change.php",

				data: {

					dictionary_key : dictionary1,

					Dictionary_value_ge : value_ge1,

					Dictionary_value_eng : value_en1

				}

			}).done(function (data) {

				obj1 = JSON.parse(data);

				console.log(obj1);

				len=obj1.length;

				//alert (len);

				if(obj1[len-2].status_code == 200){

					//alert ("asdsa");

					$("#myModal").modal();

            		document.getElementById("backError").innerHTML= obj1[len-2].response_text;

					//alert(obj1[len-2].response_text);

				}

        else

          {

			$("#myModal").modal();

            document.getElementById("backError").innerHTML= obj1[len-2].response_text;

            //alert(obj1[len-2].response_text);

          }

			});

		}



	}

</script>

<?php } ?>