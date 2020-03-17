function getCookieToObject(item) {
  var cookieObject = document.cookie.split(';').map(function(c) {
    return c.trim().split('=').map(decodeURIComponent);
  }).reduce(function(a, b) {
    try {
      a[b[0]] = JSON.parse(b[1]);
    } catch (e) {
      a[b[0]] = b[1];
    }
    return a;
  }, {});

  if (cookieObject[item] != undefined)
    return cookieObject[item];
  
  return cookieObject;

}

var themeDomain = getCookieToObject('landing_host');
function getSeparateValuteValues(arrayValute, prevWord) {
  var resultObject = {};

  for (var key in arrayValute) {
    if (typeof arrayValute[key] != 'object') {
      if (prevWord)
        resultObject[prevWord + '_' + key] = arrayValute[key];
      else
        resultObject[key] = arrayValute[key];
    }
    else {
      var newObject = {};
      if (prevWord)
        newObject = getSeparateValuteValues(arrayValute[key], prevWord + '_' + key);
      else
        newObject = getSeparateValuteValues(arrayValute[key], key);

      Object.assign(resultObject, newObject);
    }
  }

  return resultObject;
}

function getValute(e) {
  if ($('[data-valuta-value]').length) {
    $.ajax({
      url: themeDomain + 'process/updateCurrency',
      method: 'POST',
      data: {
        "country": $("select[name='user_shipping_country']").val()
      },
      success: function(data) {
        var allPrices = getSeparateValuteValues(JSON.parse(data));
        console.log(allPrices);

        var prices = JSON.parse(data).formattedPrices;
        for (var key in allPrices) {
          if ($('[data-valuta-value=' + key + ']').length) {
            $('[data-valuta-value=' + key + ']').text(allPrices[key]);
          }
        }       
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
}

if ($("[name=user_shipping_country]").length) {
  $("select[name='user_shipping_country']").on('change', getValute);
}

// common dates for languages
var dateLang = {
  en: {
  'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  'monthNamesShort': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
  'weekNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
  },
  es: {
  'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  'monthNamesShort': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
  'weekNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
  },
  se: {
  'monthNames': ['januari','februari','mars','april','maj','juni','juli','augusti','september','oktober','november','december'],
  'monthNamesShort': ['jan', 'feb', 'mar', 'apr', 'maj', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec'],
  'weekNames': ['söndag','måndag','tisdag','onsdag','torsdag','fredag','lördag']
  },
  no: {
  'monthNames': ['januar','februar','mars','april','mai','juni','juli','august','september','oktober','november','desember'],
  'monthNamesShort': ['jan', 'feb', 'mar', 'apr', 'mai', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'des'],
  'weekNames': ['søndag','mandag','tirsdag','onsdag','torsdag','fredag','lørdag']
  },
  fr: {
  'monthNames': ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
  'monthNamesShort': ['Jan','Fév','Mar','Avr','Mai','Juin','Juillet','Août','Sept','Oct','Nov','Dec'],
  'weekNames': ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi']
  }
};

/**
 * Open page in popup
 * @type string
 */
var docs = {
  /**
   * Open standart terms or privacy
   */
  open : function( page ) {
    if (typeof isSpecial != 'undefined' && isSpecial) {page+='/special';}
    window.open('/docs/'+page ,'','scrollbars=yes,width=700,height=700');
    return false;
  },
  /**
   * Open specific file
   */
  file : function( page, id, theme ) {

    // /docs/file/apex-termsSpecial-new/no#AutomaticRenewal

    var url = '/';
    if (theme) url += theme +'/';
    url += 'docs/file/' + page + '/' + getLanguage();
    if (id) url += id;

    window.open(url,'','scrollbars=yes,width=700,height=700');
    
    return false;

  }
};

$.fn.caret = function (begin, end)
{
  // если строка пуста - выходим из функции
  if (this.length == 0) return;
  if (typeof begin == 'number')
  {
    end = (typeof end == 'number') ? end : begin;
    return this.each(function ()
    {
      if (this.setSelectionRange)
      {
        this.setSelectionRange(begin, end);
      } else if (this.createTextRange)
      {
        var range = this.createTextRange();
        range.collapse(true);
        range.moveEnd('character', end);
        range.moveStart('character', begin);
        try { range.select(); } catch (ex) { }
      }
    });
  } else {
    if (this[0].setSelectionRange) {
      begin = this[0].selectionStart;
      end = this[0].selectionEnd;
    } else if (document.selection && document.selection.createRange) {
      var range = document.selection.createRange();
      // если количество символов может превышать 100000 - напишите нужное вам число
      begin = 0 - range.duplicate().moveStart('character', -100000);
      end = begin + range.text.length;
    }
    return { begin: begin, end: end };
  }
}
/**
 * Open pdf files in garcinia
 * @type string
 */
var study = {
  open : function( file ) {
    window.open(file,'','scrollbars=1,Width=600,Height=800')
    return false;
  }
};

var states=[];
states['US'] = {'AL':'Alabama','AK':'Alaska','AZ':'Arizona','AR':'Arkansas','CA':'California','CO':'Colorado','CT':'Connecticut','DE':'Delaware','DC':'District Of Columbia','FL':'Florida','GA':'Georgia','HI':'Hawaii','ID':'Idaho','IL':'Illinois','IN':'Indiana','IA':'Iowa','KS':'Kansas','KY':'Kentucky','LA':'Louisiana','ME':'Maine','MD':'Maryland','MA':'Massachusetts','MI':'Michigan','MN':'Minnesota','MS':'Mississippi','MO':'Missouri','MT':'Montana','NE':'Nebraska','NV':'Nevada','NH':'New Hampshire','NJ':'New Jersey','NM':'New Mexico','NY':'New York','NC':'North Carolina','ND':'North Dakota','OH':'Ohio','OK':'Oklahoma','OR':'Oregon','PA':'Pennsylvania',/*'PR':'Puerto Rico',*/'RI':'Rhode Island','SC':'South Carolina','SD':'South Dakota','TN':'Tennessee','TX':'Texas','UT':'Utah','VT':'Vermont','VA':'Virginia','WA':'Washington','WV':'West Virginia','WI':'Wisconsin','WY':'Wyoming'};
states['CA'] = {'AB':'Alberta','BC':'British Columbia','MB':'Manitoba','NB':'New Brunswick','NL':'Newfoundland and Labrador','NS':'Nova Scotia','NT':'Northwest Territories','NU':'Nunavut','ON':'Ontario','PE':'Prince Edward Island','QC':'Quebec','SK':'Saskatchewan','YT':'Yukon Territory'};
states['NO'] = {'Finnmark':'Finnmark','Troms':'Troms','Nordland':'Nordland','Nord-Trøndelag':'Nord-Trøndelag','Sør-Trøndelag':'Sør-Trøndelag','Møre og Romsdal':'Møre og Romsdal','Sogn og Fjordane':'Sogn og Fjordane','Hordaland':'Hordaland','Rogaland':'Rogaland','Vest-Agder':'Vest-Agder','Aust-Agder':'Aust-Agder','Telemark':'Telemark','Buskerud':'Buskerud','Hedmark':'Hedmark','Oppland':'Oppland','Akershus':'Akershus','Oslo':'Oslo','Vestfold':'Vestfold','Østfold':'Østfold'};
states['SE'] = {'Ångermanland':'Ångermanland','Blekinge':'Blekinge','Bohuslän':'Bohuslän','Dalarna':'Dalarna','Dalsland':'Dalsland','Gotland':'Gotland','Gästrikland':'Gästrikland','Halland':'Halland','Hälsingland':'Hälsingland','Härjedalen':'Härjedalen','Jämtland':'Jämtland','Lappland':'Lappland','Medelpad':'Medelpad','Norrbotten':'Norrbotten','Närke':'Närke','Öland':'Öland','Östergötland':'Östergötland','Skåne':'Skåne','Småland':'Småland','Södermanland':'Södermanland','Uppland':'Uppland','Värmland':'Värmland','Västmanland':'Västmanland','Västerbotten':'Västerbotten','Västergötland':'Västergötland'};
states['FR'] = {"Aquitaine":"Aquitaine","Auvergne":"Auvergne","Basse-Normandie":"Basse-Normandie","Bourgogne":"Bourgogne","Bretagne":"Bretagne","Centre":"Centre","Champagne-Ardenne":"Champagne-Ardenne","Corse":"Corse","Franche-Comté":"Franche-Comté","Haute-Normandie":"Haute-Normandie","Île-de-France":"Île-de-France","Languedoc-Roussillon":"Languedoc-Roussillon","Limousin":"Limousin","Lorraine":"Lorraine","Midi-Pyrénées":"Midi-Pyrénées","Nord-Pas-de-Calais":"Nord-Pas-de-Calais","Pays de la Loire":"Pays de la Loire","Picardie":"Picardie","Poitou-Charentes":"Poitou-Charentes","Provence-Alpes-Côte d'Azur":"Provence-Alpes-Côte d'Azur","Rhône-Alpes":"Rhône-Alpes","Alsace":"Alsace"};
states['UK'] = {'EN':'England','NI':'Northern Ireland','SC':'Scotland','WA':'Wales'};

/**
 * Common functions for language
 */
function getLanguage() {

  lang = $('html').attr('lang') ? $('html').attr('lang') : 'en';

  if (typeof isLanguage != 'undefined' && isLanguage)
  lang = isLanguage;

//    console.log('language: '+lang);
  return lang;

}

function getLanguageData(data) {

  lang = getLanguage();
  
  return data[lang];

}

function processingDiv() {

  var processingDivLang = {
    en: {
    'process': 'We are currently<br>processing your order',
    'please': 'Please',
    'dont': 'Don`t',
    'close': 'Close <small>or</small><br>Refresh',
    'title': 'This page'
    },
    no: {
    'process': 'Vi behandler for <br> øyeblikket bestillingen din',
    'please': 'Vennligst',
    'dont': 'Ikke',
    'close': 'Lukk <small>&nbsp;</small><br> Oppdater',
    'title': 'Denne siden'
    },
    se: {
    'process': 'Vi bearbetar <br> din beställning',
    'please': 'Vänligen',
    'dont': 'Stäng',
    'close': 'Inte <small>eller</small><br>Uppdatera',
    'title': 'Den Här sidan'
    },  
    es: {
    'process': 'Estamos actualmente<br>procesando su pedido',
    'please': 'Por favor',
    'dont': 'No',
    'close': 'Cerrar <small>o</small><br>Actualizar',
    'title': 'Esta página'
    },  
    fr: {
    'process': 'Nous traitons actuellement<br>votre commande',
    'please': 'Veuillez',
    'dont': 'Ne',
    'close': 'Pas fermer <small>ou</small><br>Actualiser',
    'title': 'Cette page'
    }

  };
  var lang = getLanguageData(processingDivLang);

  var h = $(document).height();
  var w = $(window).height();

  jQuery("html, body").animate({ scrollTop: 0 }, "slow");
  jQuery('.overflow').removeClass('hide').css({height: h + 'px'});

  var processing = '<div class="processing">\
        <div class="spinner">\
        <div class="dot1"></div>\
        <div class="dot2"></div>\
        </div>\
        <div class="msg">\
        <div class="process">'+lang['process']+'</div>\
        <div class="title please">'+lang['please']+'</div>\
        <h2>\
          <strong>'+lang['dont']+'</strong>\
          <span>'+lang['close']+'</span>\
        </h2>\
        <div class="title">'+lang['title']+'</div>\
        </div>\
      </div>';

  // mobile height fix
  if (w > 480 ) {
    process_height = w - 225;
  } else {
    process_height = w - 40;
  }
  
  jQuery('body').append($(processing).css({height: process_height}));
  jQuery('body').css({'overflow': 'hidden'});
}

function showLoader(){
  var h = $(document).height();
  var w = $(window).height();
  
  $("html, body").animate({ scrollTop: 0 });
  $('.overflow').removeClass('hide').css({height: h + 'px'});
  
  if( $('#processing').length>0 ){
    $('#processing').css({'display':'block'});
  }
}


$(function() {

  var input = document.createElement("input");

  if(!('placeholder' in input)) {
    $('input[placeholder]').each(function() {
      var placeholder = $(this).attr("placeholder");
      if(!$(this).val())
        $(this).val(placeholder);
    });
    
    $('input[placeholder]').click(function() {
      var placeholder = $(this).attr("placeholder");
      var value = $(this).val();
      
      if(placeholder == value) {
        $(this).val("");
      }
    });
    
    $('input[placeholder]').blur(function() {
      var placeholder = $(this).attr("placeholder");
      var value = $(this).val();
      
      if(value == "") {
        $(this).val(placeholder);
      }
    });
  }


  $('.row.code a, a.what').click(function() {
    $(this).next().toggleClass("hide");
    
    $('body').click(function(e) {
      if( !$(e.target).closest('.row.code a, .row.code .inform, .what, .inform').length ){
        $('.row.code .inform,.inform').addClass('hide');
      };
    });
    
  });
  $('.row.code .inform h3,.inform-close').click(function() {
    $(".row.code .inform,.inform").toggleClass("hide");
  });

  //////////////////////////////////
  // BILLING ADDRESS ACTIONS - START
  if ($('[name="user_billing_country"]').length>0) {
    changeState('billing');
    $('[name="user_billing_country"]').change(function() {
      changeZip(
        $('[name="user_billing_country"]:visible').val(),
        $('[name="user_billing_country"]').val(),
        $('[name="user_billing_zip"]:visible'),
        $('[name="user_billing_zip"]'),
        $('[name="user_billing_province"]:visible'));
      changeState('billing');
      $('[name="user_billing_city"]').val('');
    });
  }
  if ($('[name="user_billing_zip"]').length>0) {
    changeZip(
      $('[name="user_billing_country"]:visible').val(),
      $('[name="user_billing_country"]').val(),
      $('[name="user_billing_zip"]:visible'),
      $('[name="user_billing_zip"]'),
      $('[name="user_billing_province"]:visible'));
    useZipMask('user_billing_zip');
    getStateCity('billing');
    $('body').focus();
    $('[name="user_billing_zip"]').on('input', function(){
      useZipMask('user_billing_zip');
      getStateCity('billing');
    });
  }
  //////////////////////////////////
  // BILLING ADDRESS ACTIONS - END


  //////////////////////////////////
  // BSHIPPING ADDRESS ACTIONS - START
  if ($('[name="user_shipping_country"]').length>0) {
    changeState('shipping');
    $('[name="user_shipping_country"]').change(function() {
      changeZip(
        $('[name="user_shipping_country"]:visible').val(),
        $('[name="user_shipping_country"]').val(),
        $('[name="user_shipping_zip"]:visible'),
        $('[name="user_shipping_zip"]'),
        $('[name="user_shipping_province"]:visible'));
      changeState('shipping');
      $('[name="user_shipping_city"]').val('');
    });
  }
  if ($('[name="user_shipping_zip"]').length>0) {
    changeZip(
      $('[name="user_shipping_country"]:visible').val(),
      $('[name="user_shipping_country"]').val(),
      $('[name="user_shipping_zip"]:visible'),
      $('[name="user_shipping_zip"]'),
      $('[name="user_shipping_province"]:visible'));
    useZipMask('user_shipping_zip');
    getStateCity('shipping');
    $('body').focus();
    $('[name="user_shipping_zip"]').on('input', function(){
      useZipMask('user_shipping_zip');
      getStateCity('shipping');
    });
  }
  //////////////////////////////////
  // BSHIPPING ADDRESS ACTIONS - END

  
  $('a.up-me').on('click',function(){
    var top=0;
    if( $(window).width()<=1023 ){
      top=$('.form:visible, .form-up').offset().top;
    };
    $('html, body').stop().animate({scrollTop: top+'px'},600);
  });
  
  $('button.up-me, .button.up-me').on('click',function(){
    var top=0;
    if( $(window).width()<=1023 ){
      top=$('form:visible, .form-up').offset().top;
    };
    $('html, body').animate({scrollTop: top+'px'},600);
  });
  
  // Special Upsell step1
  function getCurrentState(a){
    var allStates=states['US'];
    for(var i in allStates){
      if(  a==i ){
        currentState=allStates[i];
      }
    };

    allStates=states['CA'];
    for(var i in allStates){
      if(  a==i ){
        currentState=allStates[i];
      }
    };

    return(currentState);
  }
  if( $('#extra-special-form').length>0 ){
    $('#state').val( getCurrentState($('#state').val() ));
  }
  
  
});

$(function() {
  if(typeof isclosed == 'undefined') return;

  var unloadCount = 0;
  
  $('a[href]:not([target]), a[href][target=_self]').on('click', function() { inFormOrLink = true; });

  window.onbeforeunload = function (e) {

    //console.log(inFormOrLink);
    if(inFormOrLink) return;
    
    if ( typeof avLandingName != 'undefined' && typeof isSpecial != 'undefined' && avLandingName == 'garcinia' && isSpecial ) {
      window.open('http://jmpmer.com/MKF2BRJPOb?sa0=&sa1=&sa2=&creative=&r=&pubclickid=');
    }

    $('.overflow, a.banner, a.banner_special, a.downsell, a.downsell.special').removeClass('hide');
    $('.overflow').addClass('beforeUnload');
    $('body').css({'overflow': 'hidden'});

    unloadCount++;

    if (typeof overflowTop != 'undefined') {
      top = overflowTop; // use hardcoded top value
    } else {
      top = $(window).scrollTop(); // use auto top value
    }
    $('.overflow').css({'top': top});

    $('.overflow').click(function() {
      $('.overflow, a.banner, a.banner_special, a.downsell, a.downsell.special').addClass('hide');
      $('.overflow').removeClass('beforeUnload');
      $('body').removeAttr('style');
    });

    e = e || window.event;
    if (e) {
      e.returnValue = window.beforeunload_message;
    }

    console.log('unloadCount: '+unloadCount);

    return window.beforeunload_message;
  };
  
});


$(function() {

  
  if($("form").length && (typeof jQuery.fn.validate === "function")) {

    // no processing popup
    if ($("form").hasClass('no-processingDiv')) {
      $("form").validate();
    } else if ( $("form").hasClass('showLoader') ) {
      $("form").validate(showLoader);
    } else if ( $("form").hasClass('customLoader') ) {
      $("form").validate(customLoader);
    } else {
      // with processing popup
      $("form").validate(processingDiv);
    }
    
    $('.error', $('form')).errors();
    
  }
  

});


$(document).ready(function() {

  // fix form height for androind
  var ua = navigator.userAgent.toLowerCase();
  var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
  var isIphone = ua.indexOf("iphone") > -1; //&& ua.indexOf("mobile");

  if(isAndroid || isIphone) {
    $('.products .form').addClass('android');
  } else {
    $('.products .form').removeClass('android');
  }
});


// zip mask
function useZipMask(name){
  var data=$('[name="'+name+'"]:visible');
  if( data.length==0 ) data = $('[name="'+name+'"]');
  
  if ( data.data('rule-type')=='zip-us' ) {

    if ( data.val().length>0  ) {
      var dataValue = data.val().replace(/[^0-9]/g, "").substr(0, 5);
      
      data.val( dataValue );
      var dataValueLength = dataValue.length;
      
      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
    }
    
  } else if ( data.data('rule-type')=='zip-au' ) {

    if ( data.val().length>0  ) {
      var dataValue = data.val().replace(/[^0-9]/g, "").substr(0, 4);
      
      data.val( dataValue );
      var dataValueLength = dataValue.length;
      
      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
    }
    
  } else if ( data.data('rule-type')=='zip-no' ) {

    if ( data.val().length>0  ) {
      var dataValue = data.val().replace(/[^0-9]/g, "").substr(0, 4);

      data.val( dataValue );
      var dataValueLength = dataValue.length;

      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
    }

  } else if ( data.data('rule-type')=='zip-fr' ) {

    if ( data.val().length>0  ) {
      var dataValue = data.val().replace(/[^0-9]/g, "").substr(0, 5);

      data.val( dataValue );
      var dataValueLength = dataValue.length;

      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
    }
    
  } else if ( data.data('rule-type')=='zip-se' ) {

    if ( data.val().length>0  ) {
      var dataValue = data.val().replace(/[^0-9]\s/g, "").substr(0, 6);

      data.val( dataValue );
      var dataValueLength = dataValue.length;

      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
    }
    
    } else if ( data.data('rule-type')=='zip-uk' ) {

    if (data.val().length>0 && !/^[0-9a-zA-Z]{3} [0-9a-zA-Z]{3}$/i.test(data.val().substr(0, 7))) {

      var clNumber = data.val().replace(/[^0-9a-zA-Z]/g, "").substr(0, 6).split('');
      
      while( clNumber[0] && !/^[0-9a-zA-Z]$/i.test(clNumber[0]) && clNumber!='' ){
        clNumber.splice(0, 1);
      }
      
      while( clNumber[1] && !/^[0-9a-zA-Z]$/i.test(clNumber[1]) && clNumber!='' ){
        clNumber.splice(1, 1);
      }
      
      while( clNumber[2] && !/^[0-9a-zA-Z]$/i.test(clNumber[2]) && clNumber!='' ){
        clNumber.splice(2, 1);
      }
      
      while( clNumber[3] && !/^[0-9a-zA-Z]$/i.test(clNumber[3]) && clNumber!='' ){
        clNumber.splice(3, 1);
      }
      
      while( clNumber[4] && !/^[0-9a-zA-Z]$/i.test(clNumber[4]) && clNumber!='' ){
        clNumber.splice(4, 1);
      }
      
      while( clNumber[5] && !/^[0-9a-zA-Z]$/i.test(clNumber[5]) && clNumber!='' ){
        clNumber.splice(5, 1);
      }
      
      if( clNumber[3] ){
        clNumber.splice(3, 0, ' ');
      }
      
      clNumber=clNumber.join('');
      
      data.val(clNumber.toUpperCase());
      var l=clNumber.length;
      
      setTimeout(function(){
        data[0].setSelectionRange(l, l);
      }, 0);
    }
  } else if ( data.data('rule-type')=='zip-other' ) {
    
    if ( data.val().length>0 && !/^[0-9A-Z\s]{3,12}$/g.test(data.val())  ) {

      var dataValue = data.val().replace(/[^0-9a-zA-Z ]/g, "").substr(0, 12);
      
      data.val( dataValue.toUpperCase() );
      var dataValueLength = dataValue.length;
      
      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
      
    } 
  
  } else if ( data.data('rule-type')=='zip-ca' ) {
      
    if (data.val().length>0 && !/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} \d{1}[A-Z]{1}\d{1}$/i.test(data.val().substr(0, 7))) {

      var clNumber = data.val().replace(/[^0-9a-zA-Z]/g, "").substr(0, 6).split('');
      
      while( clNumber[0] && !/^[ABCEGHJKLMNPRSTVXY]$/i.test(clNumber[0]) && clNumber!='' ){
        clNumber.splice(0, 1);
      }
      
      while( clNumber[1] && !/^\d{1}$/i.test(clNumber[1]) && clNumber!='' ){
        clNumber.splice(1, 1);
      }
      
      while( clNumber[2] && !/^[A-Z]$/i.test(clNumber[2]) && clNumber!='' ){
        clNumber.splice(2, 1);
      }
      
      while( clNumber[3] && !/^[\d]$/i.test(clNumber[3]) && clNumber!='' ){
        clNumber.splice(3, 1);
      }
      
      while( clNumber[4] && !/^[A-Z]$/i.test(clNumber[4]) && clNumber!='' ){
        clNumber.splice(4, 1);
      }
      
      while( clNumber[5] && !/^[\d]$/i.test(clNumber[5]) && clNumber!='' ){
        clNumber.splice(5, 1);
      }
      
      if( clNumber[3] ){
        clNumber.splice(3, 0, ' ');
      }
      
      clNumber=clNumber.join('');
      
      data.val(clNumber.toUpperCase());
      var l=clNumber.length;
      
      setTimeout(function(){
        data[0].setSelectionRange(l, l);
      }, 0);
    }
  
  } else {
      
    if ( data.val().length>0  ) {
      var dataValue = data.val().replace(/[^0-9a-zA-Z ]/g, "").substr(0, 12);
      
      data.val( dataValue );
      var dataValueLength = dataValue.length;
      
      setTimeout(function(){
        data[0].setSelectionRange(dataValueLength, dataValueLength);
      }, 0);
    }
  
  }
}

function getStateCity(prefix) {

  if (
    $('[name="user_'+prefix+'_country"]').length>0 &&
    $('[name="user_'+prefix+'_zip"]').length>0 &&
    $('[name="user_'+prefix+'_province"]').length>0 &&
    $('[name="user_'+prefix+'_city"]').length>0 &&
    $('[name="user_'+prefix+'_city"]').data('value')==''
  ) {

    var countryVal = $('[name="user_'+prefix+'_country"]:visible').val();
    if (!countryVal) var countryVal = $('[name="user_'+prefix+'_country"]').val();

    var zipVal = $('[name="user_'+prefix+'_zip"]:visible').val();
    var cityVal = $('[name="user_'+prefix+'_city"]:visible').val();

    var state =  $('[name="user_'+prefix+'_province"]:visible');

    var rightUS = /^\d{5}(-\d{4})?$/;
    var rightCA = /^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/;
    var rightNO = /^[0-9]{4,4}$/;
    var rightFR = /^[0-9]{4,5}$/;
    var rightSE = /^\d{3}\s\d{1,2}$/;
    var rightUK = /^[0-9a-zA-Z]{3} *[0-9a-zA-Z]{3}$/;
    var rightAU = /^[0-9]{3,4}$/;

    $('[name="user_'+prefix+'_zip"]:visible').val( zipVal );

    if(
      (countryVal=='US' && rightUS.test( zipVal )) ||
      (countryVal=='CA' && rightCA.test( zipVal )) ||
      (countryVal=='NO' && rightNO.test( zipVal )) ||
      (countryVal=='FR' && rightFR.test( zipVal )) ||
      (countryVal=='SE' && rightSE.test( zipVal )) ||
      (countryVal=='UK' && rightUK.test( zipVal )) ||  
      (countryVal=='AU' && rightAU.test( zipVal ))   
    ){

      $.post("/process/checkState", { 'zip': zipVal, 'country': countryVal }, function( data ) {

        if( data.city!=null && data.city.length>0 ){
          placeholder_up(prefix,data.city);
          $('[name="user_'+prefix+'_city"]').val( data.city );
        }else{
          $('[name="user_'+prefix+'_city"]').val('');
        };

        if( data.state!=null && data.state.length>0 ){
          state.val( data.state );
        };

      }, "json");
    }
  }
  
  if ($('[name="user_'+prefix+'_city"]').data('value')!='') {
    $('[name="user_'+prefix+'_city"]').data('value','');
  }
}

/**
 * Move placeholder to top after populating input
 */
function placeholder_up(prefix,value) {

  if (typeof field_active != 'undefined' && field_active) {
  if (value) {
    var target = $('[name="user_'+prefix+'_city"]');
    var parent = target.closest('.row');
    if ( !parent.hasClass('field_active') ) {
    parent.addClass('field_active');
    console.log('add field_active to city: '+prefix);
    }
  }
  }

}

/**
 * Move ALL placeholders to top if input has value
 */
function placeholder_up_all() {

  if (typeof field_active != 'undefined' && field_active) {

  inputs = $('form.av-main-header-form').find('input[type=text],input[type=tel],input[type=email]');
  
  $.each(inputs, function(key, input) {
    if ($(input).val()) {

    parent = $(input).closest('.row');
    if ( !parent.hasClass('field_active') )
      parent.addClass('field_active');

    }
    
  });

  }

}



function changeZip(countryVal, wcountryVal, zip, wzip, state) {

  var changeZipLang = {
    en: {
    'placeholder_postal': 'Postal Code',
    'invalid_postal': 'Invalid Postal Code',
    'required_postal': 'Postal Code is Required',
    'placeholder_zip': 'Zip Code',
    'invalid_zip': 'Invalid Zip Code',
    'required_zip': 'Zip Code is Required',
    'placeholder_postcode': 'Postcode',
    'invalid_postcode': 'Postcode',
    'required_postcode': 'Postcode is Required'
    },
    no: {
    'placeholder_postal': 'Postnummer',
    'invalid_postal': 'Ugyldig Postnummer',
    'required_postal': 'Postnummer er påkrevd',
    'placeholder_zip': 'Postnummer',
    'invalid_zip': 'Ugyldig Postnummer',
    'required_zip': 'Postnummer er påkrevd',

    'placeholder_postcode': 'Postcode',
    'invalid_postcode': 'Postcode',
    'required_postcode': 'Postcode is Required'
    },
    se: {
    'placeholder_postal': 'Postnummer',
    'invalid_postal': 'Ogiltig Postnummer',
    'required_postal': 'Postnummer krävs',
    'placeholder_zip': 'Postnummer',
    'invalid_zip': 'Ogiltig Postnummer',
    'required_zip': 'Postnummer krävs',

    'placeholder_postcode': 'Postcode',
    'invalid_postcode': 'Postcode',
    'required_postcode': 'Postcode is Required'
    },
    fr: {
    'placeholder_postal': 'Code postal',
    'invalid_postal': 'Code postal invalide',
    'required_postal': 'Code postal obligatoire',
    'placeholder_zip': 'Code postal',
    'invalid_zip': 'Code postal invalide',
    'required_zip': 'Le code postal est obligatoire',

    'placeholder_postcode': 'Postcode',
    'invalid_postcode': 'Postcode',
    'required_postcode': 'Postcode is Required'
    },
    es: {
    'placeholder_postal': 'Código postal',
    'invalid_postal': 'Inválido Código postal',
    'required_postal': 'Código postal es Requerido',
    'placeholder_zip': 'Código postal',
    'invalid_zip': 'Inválido Código postal',
    'required_zip': 'Código postal es Requerido',

    'placeholder_postcode': 'Postcode',
    'invalid_postcode': 'Postcode',
    'required_postcode': 'Postcode is Required'
    }
  };
  var lang = getLanguageData(changeZipLang);

  var countryVal = countryVal;
  if (!countryVal) countryVal = wcountryVal;

  var zip = zip;
  if (zip.length==0) zip = wzip;

  var state = state;
  var zipError = zip.next('.tooltip');

  if( countryVal=='CA' || countryVal=='Canada' ) {

    if ( zip.val().length>0 && !/^([ABCEGHJKLMNPRSTVXY]{1}[0-9]{1}[A-Z]{1} *[0-9]{1}[A-Z]{1}[0-9]{1})$/.test( zip.val() ) )
      zip.val('');

    zip.attr({
      'type':'text',
      'placeholder':lang['placeholder_postal'],
      'data-rule-type':'zip-ca',
      'data-rule-minlength':'7',
      'data-rule-maxlength':'7',
      'maxlength':'7',
      'data-original-title':lang['invalid_postal'],
      'data-original-required':lang['required_postal']
    }).data({
      'type':'text',
      'rule-type':'zip-ca',
      'rule-minlength':'7',
      'rule-maxlength':'7',
      'original-title':lang['invalid_postal'],
      'original-required':lang['required_postal']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postal']);
      }else{
        zipError.text(lang['invalid_postal']);
      }
    }
  } else if( countryVal=='UK' || countryVal=='United Kingdom' ) {
                if ( zip.val().length>0 && !/^([0-9a-zA-Z]{3} *[0-9a-zA-Z]{3})$/.test( zip.val() ) )
      zip.val('');

    zip.attr({
      'type':'text',
      'placeholder':lang['placeholder_postcode'],
      'data-rule-type':'zip-uk',
      'data-rule-minlength':'7',
      'data-rule-maxlength':'7',
      'maxlength':'7',
      'data-original-title':lang['invalid_postcode'],
      'data-original-required':lang['required_postcode']
    }).data({
      'type':'text',
      'rule-type':'zip-uk',
      'rule-minlength':'7',
      'rule-maxlength':'7',
      'original-title':lang['invalid_postcode'],
      'original-required':lang['required_postcode']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postcode']);
      }else{
        zipError.text(lang['invalid_postcode']);
      }
    }
  } else if( countryVal=='NO' || countryVal=='Norway' ) {

    if ( zip.val().length>0 && !/^[0-9]{4,4}$/.test( zip.val() ) )
      zip.val('');

    zip.attr({
      'type':'text',
      'placeholder':lang['placeholder_postal'],
      'data-rule-type':'zip-no',
      'data-rule-minlength':'4',
      'data-rule-maxlength':'4',
      'maxlength':'4',
      'data-original-title':lang['invalid_postal'],
      'data-original-required':lang['required_postal']
    }).data({
      'type':'text',
      'rule-type':'zip-no',
      'rule-minlength':'4',
      'rule-maxlength':'4',
      'original-title':lang['invalid_postal'],
      'original-required':lang['required_postal']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postal']);
      }else{
        zipError.text(lang['invalid_postal']);
      }
    }

  } else if( countryVal=='FR' || countryVal=='France' ) {

    if ( zip.val().length>0 && !/^[0-9]{4,5}$/.test( zip.val() ) )
      zip.val('');

    zip.attr({
      'type':'text',
      'placeholder':lang['placeholder_postal'],
      'data-rule-type':'zip-fr',
      'data-rule-minlength':'4',
      'data-rule-maxlength':'5',
      'maxlength':'5',
      'data-original-title':lang['invalid_postal'],
      'data-original-required':lang['required_postal']
    }).data({
      'type':'text',
      'rule-type':'zip-fr',
      'rule-minlength':'4',
      'rule-maxlength':'5',
      'original-title':lang['invalid_postal'],
      'original-required':lang['required_postal']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postal']);
      }else{
        zipError.text(lang['invalid_postal']);
      }
    }

  } else if( countryVal=='SE' || countryVal=='Sweden' ) {

    if ( zip.val().length>0 && !/^\d{3}\s\d{1,2}$/.test( zip.val() ) )
      zip.val('');

    zip.attr({
      'type':'text',
      'placeholder':lang['placeholder_postal'],
      'data-rule-type':'zip-se',

      'data-rule-minlength':'5',
      'data-rule-maxlength':'6',
      'maxlength':'6',
      'data-original-title':lang['invalid_postal'],
      'data-original-required':lang['required_postal']
    }).data({
      'type':'text',
      'rule-type':'zip-se',
      'rule-minlength':'5',
      'rule-maxlength':'6',
      'original-title':lang['invalid_postal'],
      'original-required':lang['required_postal']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postal']);
      }else{
        zipError.text(lang['invalid_postal']);
      }
    }
    
  } else if( countryVal=='US' || countryVal=='United States' ) {
    
    if ( zip.val().length>0 && !/^[0-9]{5}$/.test( zip.val() ) ){
      zip.val('');
    };

    zip.attr({
      'type':'tel',
      'placeholder':lang['placeholder_zip'],
      'data-rule-type':'zip-us',
      'data-rule-minlength':'5',
      'data-rule-maxlength':'5',
      'maxlength':'5',
      'data-original-title':lang['invalid_zip'],
      'data-original-required':lang['required_zip']
    }).data({
      'type':'tel',
      'rule-type':'zip-us',
      'rule-minlength':'5',
      'rule-maxlength':'5',
      'original-title':lang['invalid_zip'],
      'original-required':lang['required_zip']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_zip']);
      }else{
        zipError.text(lang['invalid_zip']);
      }
    }
    
  } else if( countryVal=='AU' || countryVal=='Australia' ) {
    
    if ( zip.val().length>0 && !/^[0-9]{4}$/.test( zip.val() ) ){
      zip.val('');
    };

    zip.attr({
      'type':'tel',
      'placeholder':lang['placeholder_postcode'],
      'data-rule-type':'zip-au',
      'data-rule-minlength':'3',
      'data-rule-maxlength':'4',
      'maxlength':'4',
      'data-original-title':lang['invalid_postcode'],
      'data-original-required':lang['required_postcode']
    }).data({
      'type':'tel',
      'rule-type':'zip-au',
      'rule-minlength':'3',
      'rule-maxlength':'4',
      'original-title':lang['invalid_postcode'],
      'original-required':lang['required_postcode']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postcode']);
      }else{
        zipError.text(lang['invalid_postcode']);
      }
    }
    
  } 
  else {
     // && !/^([0-9A-Z\s]{3,12})$/.test( zip.val() ) 
    if ( zip.val().length>0){
      zip.val('');
    };

    zip.attr({
      'type':'text',
      'placeholder':lang['placeholder_postal'],
      'data-rule-type':'zip-other',
      'data-rule-minlength':'3',
      'data-rule-maxlength':'12',
      'maxlength':'12',
      'data-original-title':lang['invalid_postal'],
      'data-original-required':lang['required_postal']
    }).data({
      'type':'text',
      'rule-type':'zip-other',
      'rule-minlength':'3',
      'rule-maxlength':'12',
      'original-title':lang['invalid_postal'],
      'original-required':lang['required_postal']
    });

    if( zipError ){
      if( zipError.hasClass('required') ){
        zipError.text(lang['required_postal']);
      }else{
        zipError.text(lang['invalid_postal']);
      }
    }
    
  };
  
};

function changeState(type) {
  var countryVal = $('[name="user_'+type+'_country"]:visible').val();
  if (!countryVal) var countryVal = $('[name="user_'+type+'_country"]').val();

  if (type == 'shipping') {
    us_class = '.us-ship-province';
    ca_class = '.ca-ship-province';
    uk_class = '.uk-ship-province';
    au_class = '.au-ship-province';
    other_class = '.other-ship-province';
  } else {
    us_class = '.us-province';
    ca_class = '.ca-province';
    uk_class = '.uk-province';
    au_class = '.au-province';
    other_class = '.other-province';
  }

  if ( countryVal == 'US' ) {
    $(us_class).attr({'name':'user_'+type+'_province'}).show();
    $(ca_class).attr({'name':''}).hide();
    $(uk_class).attr({'name':''}).hide();
    $(au_class).attr({'name':''}).hide();
    $(other_class).attr({'name':''}).hide();
  }else if ( countryVal == 'CA' ) {
    $(us_class).attr({'name':''}).hide();
    $(ca_class).attr({'name':'user_'+type+'_province'}).show();
    $(uk_class).attr({'name':''}).hide();
    $(au_class).attr({'name':''}).hide();
    $(other_class).attr({'name':''}).hide();
  } else if ( countryVal == 'UK' ) {
    $(us_class).attr({'name':''}).hide();
    $(ca_class).attr({'name':''}).hide();
    $(uk_class).attr({'name':'user_'+type+'_province'}).show();
    $(au_class).attr({'name':''}).hide();
    $(other_class).attr({'name':''}).hide();
  }else if ( countryVal == 'AU' ) {
    $(us_class).attr({'name':''}).hide();
    $(ca_class).attr({'name':''}).hide();
    $(uk_class).attr({'name':''}).hide();
    $(au_class).attr({'name':'user_'+type+'_province'}).show();
    $(other_class).attr({'name':''}).hide();
  } else{
    $(us_class).attr({'name':''}).hide();
    $(ca_class).attr({'name':''}).hide();
    $(uk_class).attr({'name':''}).hide();
    $(au_class).attr({'name':''}).hide();
    $(other_class).attr({'name':'user_'+type+'_province', 'placeholder': 'Region'}).show();
  }
}

// Phone mask
var oldPhoneData='';
function phoneMask(a){
  
  var data=a;
  var caretPosition = data.caret().begin;
  var realVal=data.val();
  var val=realVal.trim().split('-');
  var correctVal='';
  
  if( val[0] != undefined )
    correctVal+=val[0];
  if( val[1] != undefined )
    correctVal+='-'+val[1];
  if( val[2] != undefined )
    correctVal+='-'+val[2];
  
  if( 
  /^.*[^0-9\-]+.*$/.test( correctVal ) || 
  /^[0-9]{3,}$/.test( correctVal ) || 
  /^[0-9]{4,}(.*)?$/.test( correctVal ) || 
  /^([0-9]+)?\-[0-9]{3,}$/.test( correctVal ) || 
  /^([0-9]+)?\-[0-9]{4,}(.*)?$/.test( correctVal ) || 
  /^([0-9]+)?\-([0-9]+)?\-[0-9]{5,}$/.test( correctVal )
  ){
    
    val=correctVal.replace(/[^0-9\-]/g, "").split('-');
    if( val.length==1 && val[0].length>3 ){
      var newVal=[];
      if( val[0].substr(0, 3)!='' )
        newVal[0]=val[0].substr(0, 3);
      if( val[0].substr(3, 3)!='' )
        newVal[1]=val[0].substr(3, 3);
      if( val[0].substr(6, 4)!='' )
        newVal[2]=val[0].substr(6, 4);
      
      val=newVal; 
    }
    
    correctVal='';
    var tempVal='';
    
    if( val[0] != undefined ){
      tempVal=val[0].substr(0, 3);
      correctVal+=tempVal;
    
      if( tempVal.length==3 || val[1] != undefined )
        correctVal+='-';
    }
    if( val[1] != undefined ){
      tempVal=val[1].substr(0, 3);
      correctVal+=tempVal;
      
      if( tempVal.length==3 || val[2] != undefined )
        correctVal+='-';
    }
    if( val[2] != undefined ){
      correctVal+=val[2].substr(0, 4);
    }
    
    
    if( realVal==correctVal.slice(0, -1) && correctVal[correctVal.length-1]=='-' && oldPhoneData.length>=correctVal.length ){
      correctVal=correctVal.substring(0, correctVal.length-2);
    }
    
    oldPhoneData=correctVal;
    data.val(correctVal);
    var l=correctVal.length;
    
    setTimeout(function(){
      data[0].setSelectionRange(l, l);
    }, 0)
  }
}

if($('.phone-mask').length>0) {
  
  $('.phone-mask').on('input', function (e){
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if(keycode == 9) return;
    
    phoneMask( $(this) );
  });
  
  if( $('.phone-mask').val() != '' ){
    phoneMask( $('.phone-mask') );
  }
}


// Get Date
var getDate = {
  
  monthNames : false,
  monthNamesShort : false,
  weekNames : false,

  init : function() {
    var lang = getLanguageData(dateLang);
    getDate.monthNames = lang.monthNames;
    getDate.monthNamesShort = lang.monthNamesShort;
    getDate.weekNames = lang.weekNames;
  },

  currentFullDay: function(){
    getDate.init();
    var date = new Date();
    return getDate.weekNames[date.getDay()]+', '+getDate.monthNames[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

  },
  currentDay: function(){
    getDate.init();
    var date = new Date();
    return getDate.monthNames[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

  },
  arriveFullDay: function(offset){
    getDate.init();
    var date = new Date();
    if (offset) {
      date.setDate(date.getDate() + offset);
    }
    return getDate.weekNames[date.getDay()]+' '+getDate.monthNamesShort[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

  },
  arriveFullDayFullMonth: function(offset){
    getDate.init();
    var date = new Date();
    if (offset) {
      date.setDate(date.getDate() + offset);
    }
    return getDate.weekNames[date.getDay()]+' '+getDate.monthNames[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

  },
  arriveFullDayYear: function(offset){
    getDate.init();
    var date = new Date();
    if (offset) {
      date.setDate(date.getDate() + offset);
    }
    return getDate.monthNames[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

  },
  arriveDay: function(){
    getDate.init();
    var date = new Date();
    date.setDate(date.getDate() + 5);
    return getDate.monthNames[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();
  }

};

// Insert Timer
(function($){
  jQuery.fn.insertTimer = function(){

    var data = $(this);
    var counter = 0;

    format = function(t) {
      var minutes = Math.floor(t/600),
        seconds = Math.floor( (t/10) % 60);
        minutes = (minutes < 10) ? "0" + minutes.toString() : minutes.toString();
        seconds = (seconds < 10) ? "0" + seconds.toString() : seconds.toString();
      return minutes + ":" + seconds + "." + "0" + Math.floor(t % 10);
    };
    setInterval(function() {
      counter++;
      data.text( format(counter) );
    },100);

  };
})(jQuery);


/**
 * Top warning date and time
 */
var warning = {

  init : function() {
    // check for div
    if (!$('.av-warning').length) return;
    
    var lang = getLanguageData(dateLang);
    var monthNames = lang.monthNames;
    var weekNames = lang.weekNames;

    var date = new Date();
    var currentDate = weekNames[date.getDay()]+', '+monthNames[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();
    $('.av-warning-date').text(currentDate);

    var counter = 9000;
    form = function(t) {
      var minutes = Math.floor(t/600),
      seconds = Math.floor( (t/10) % 60);
      minutes = (minutes < 10) ? "0" + minutes.toString() : minutes.toString();
      seconds = (seconds < 10) ? "0" + seconds.toString() : seconds.toString();
      $('.av-warning-timer').text(minutes + ":" + seconds + "." + "0" + Math.floor(t % 10));
      
    };

    setInterval(function() {
       counter--;
       form(counter);
       if (counter==0) counter = 9000;
    },100);

  }
  
};

// auto init warning
$(document).ready(function() {
  warning.init();
});

/**
 * Add facebook pixel
 */
var facebook = {

  pixel : function( id, action, params ) {

    !function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments) };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', id);

    if (action == 'Purchase') {
      if (params !== undefined) {
        fbq('track', 'Purchase', params);
      } else {
        fbq('track', 'Purchase', {value: 0.00, currency: 'USD'});
      }
    } else {
      if (params !== undefined) {
        fbq('track', action, params);
      } else {
        fbq('track', action);
      }
    }

  }
  
};

(function($){
  if ($('#step-action__viewers').length > 0) {
    setInterval(function() {
      var viewers = $('#step-action__viewers');
      viewers.text( parseInt(viewers.text())+3 );
    }, 15000);
  }
})(jQuery);

// test processing div
//$(document).ready(function() { processingDiv(); });
