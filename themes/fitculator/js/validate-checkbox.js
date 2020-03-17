function customLoader() {
  $('#loader').css('display', 'flex').hide().fadeIn();
}
var gen = JSON.parse(localStorage.getItem('data'))[0].gender;
if (gen == 'Female') {
  $("body").removeClass('male');
  $("body").addClass('female');
} else {
  $("body").addClass('male');
}

var timer;
var minutes;
var seconds;
function startTimer(duration, display) {
  timer = duration, minutes, seconds;
  var intervaltimer = setInterval(function () {
    minutes = parseInt(timer / 60, 10);
    seconds = parseInt(timer % 60, 10);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    display.text(minutes + ":" + seconds);

    if (--timer < 0) {
      clearInterval(intervaltimer);
    }
  }, 1000);
}

// if ($('.main__footer').length > 0 && !$('.main__footer').hasClass('large')){
//   $('.main__footer, footer').hide();
// }

if ($('.main__step-4').length > 0) {
  var timerStart = localStorage.getItem('timer');
  $('.timer').text('');
}

$(document).ready(function () {

  if($('.step2__right').length > 0) {
    if ($('.timer').length > 0) {
      startTimer(60 * 13 + 40, $('.timer'));
    }
    $('.step2__right form').submit(function() {
      localStorage.setItem('timer', (timer - 4))

    });
  } else if ($('.main__step-4').length > 0) {
    var timer1 = localStorage.getItem('timer');
    startTimer(parseInt(timer1), $('.timer'));
  }
  
  if($('.carousel').length > 0) {
    $('.carousel .owl-carousel').owlCarousel({
      loop:true,
      margin:14,
      nav:false,
      responsive:{
          0:{
              items:1
          },
          420:{
              items:2
          },
          670:{
              items:3
          }
      }
    })
  }

  // $(function() {
  //   if ($('.step4').length > 0) {
  //     var a = $('input[name="user_shipping_zip"]').val();
  //     $('input[name="user_shipping_zip"]').on('input', function() {
  //       var _this = $(this);
  //       if (!$('.step4__right').hasClass('active')) {
  //         $('input[name="user_shipping_zip"]').val(a);
  //       }
  //     })
  //     $('.total-price .button').on('click', function() {
  //       $(this).closest('.step4__left').removeClass('active').siblings('.step4__right').addClass('active');
  //       $('input[name="user_shipping_zip"]').trigger('input');
  //     });
  //   }
  // });

  // $(function() {
  //   if ($('.main__footer').length > 0 && !$('.main__footer').hasClass('large')){
  //     var _element = $('.fb-comments');
  //     var counter = 0;
  //     var scrollCheck = 0;

  //     function scrollOut(offset) {
  //       $(window).scroll(function() {
  //         var scroll = $(window).scrollTop() + $(window).height();  
  //         if (scroll <= offset) {
  //           $(document).unbind('scroll');
  //           mainScroll(2, offset);
  //         }
  //       });
  //     }

  //     function scrollTimer() {
  //       setTimeout(function() {
  //         $(document).unbind('scroll');
  //         $('.main__footer, footer').show();
  //       }, 1100);
  //     }

  //     function mainScroll(index, end) {
  //       $(window).scroll(function() {
  //         if (counter < index) {
  //           var scroll = $(window).scrollTop() + $(window).height();
  //           var offsetStart = _element.offset().top + _element[0].offsetHeight - 60;
  //           var offset = (end == undefined) ? offsetStart : end;
  //           if (scroll >= offset) {
  //             counter++;

  //             if (counter == index) {
  //               scrollCheck = scroll;
  //               scrollOut(scrollCheck - 60);

  //               if (counter == 1) {
  //                 scrollTimer();
  //               }

  //               if (counter == 2) {
  //                 $('.main__footer, footer').show();
  //               }
  //               $(document).unbind('scroll');
  //             } 
  //           }
  //         }
  //       });
  //     }
  //     mainScroll(1);
  //   }
  // });
  
  $(function() {
    $('.step2-title a').click(function(e) {
      e.preventDefault();
      $('.step-1 form').submit();
    });
  });
  
  $(function() {
    isChekboxesChecked();
    onCheckboxValueChange();

    function onCheckboxValueChange() {
      $('.checkbox').on('click', function() {
        isChekboxesChecked()
      })
  }
    function isChekboxesChecked() {
      if($('input.checkbox:checked').length === $('input.checkbox').length) {
        $('.submitBtn').attr('disabled', false)
      } else {
        $('.submitBtn').attr('disabled', true)
      }
    }
  });

  $('.main__step-4 form input:not([type="checkbox"]), .main__step-4 form select').change(function() {
    $('.billing-address__checkbox input[type="checkbox"]').removeAttr('checked');
  });
});
