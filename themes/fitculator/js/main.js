$(document).ready(function () {
    svg4everybody();

    $.fn.toggleAttr = function (attr, attr1, attr2) {
        return this.each(function () {
            var self = $(this);
            if (self.attr(attr) == attr1) {
                self.attr(attr, attr2);
            } else {
                self.attr(attr, attr1);
            }
        });
    };

    //---action help window
    $('.question__help-window-close').on('click', function () {
        $(this).parent().removeClass('open');
    });
    $('.question__help').on('click', function () {
        $(this).next('.question__help-window').addClass('open');
    });

    //---end


    //---multi-choose
    $('.multi-choose div').on('click', function () {
        $(this).toggleAttr('data-multi-choose', 'check', 'no-check');
        if ($(this).hasClass('none') && $(this).attr('data-multi-choose') == 'check') {
            $(this).siblings('div').not('.none').attr('data-multi-choose', 'no-check')
        } else if ($(this).not('.none') && $(this).attr('data-multi-choose') == 'check') {
            $(this).siblings('div.none').attr('data-multi-choose', 'no-check')
        }
    });
    //---end
    //---multi-svg-choose
    $('.multi-svg-choose div').on('click', function () {
        $(this).toggleAttr('data-multi-choose', 'check', 'no-check');
        if ($(this).hasClass('none') && $(this).attr('data-multi-choose') == 'check') {
            $(this).siblings('div').not('.none').attr('data-multi-choose', 'no-check')
        } else if ($(this).not('.none') && $(this).attr('data-multi-choose') == 'check') {
            $(this).siblings('div.none').attr('data-multi-choose', 'no-check')
        }
    });
    //---end

    $('.switch-field input').click(function () {
        if (($(this).is(':checked')) && ($(this).hasClass('metr'))) {
            $('#metric').addClass('active');
            $('#imperial').trigger('reset').removeClass('active').find('label').addClass('stop').removeClass('inval');

        } else {
            $('#metric').trigger('reset').removeClass('active').find('label').addClass('stop').removeClass('inval');
            $('#imperial').addClass('active');
        }
    });

    "use strict";

    $('.product-modal .close').on('click', function () {
        $(this).parents('.product-modal').removeClass('open');
    });

    //---slider
    function StepActive() {
        $('.main .main__step.active').each(function () {
            if (!$(this).is(':last-child') && $(this).attr('id') !== 'characteristics') {
                $(this).removeClass('active').next().addClass('active');
                var paginN = $(this).parents('main').find('.steps_allsteps a');
                paginN.removeClass('active');
                var number = $(this).index()+1;
                var width_line = $(this).next().attr('data-step');

                paginN.eq(number).addClass('complete');
                paginN.eq(number + 1).addClass('active');
                $('.steps').css('display', 'block');
                $('.steps_line__progress').width(width_line);
                $('.steps_line__text').css({"left": width_line});
                $('.steps_line__text span').text(width_line);
            }
        });
    }

    // slider next button
    $('.next-question').on('click', function () {
		
        $('html, body').animate({scrollTop: '0px'}, 100);

        var isContains = $(this).parents('.main__step').find('[data-multi-choose]').length > 0;
        var isOneCheck;

        $(this).parents('.main__test').find('[data-multi-choose]').each(function (e) {
            if($(this).attr('data-multi-choose') == 'check') {
                isOneCheck = true;
                return;
            }
        });

        if((isContains && isOneCheck) || !isContains) {
			var autorized = localStorage.getItem('autorized');
			if(autorized==0)
			{
				$('.question__help').next('.question__help-window').addClass('open');
			}
			//alert(autorized);
           else
		   {
		   		StepActive();
		   }
        } else {
            $('.product-modal').addClass('open').find('.no-choosen').on('click', function () {
                $('.product-modal').removeClass('open');
            });

        }

        // PROCESSING
        // if($('#processing').hasClass('active')) {
        //     $('.question').remove();
        //     $('.steps').css('display', 'none');
        //     $('.count').each(function () {
        //         $(this).prop('Counter', 0).animate({
        //             Counter: $(this).text()
        //         }, {
        //             duration: 5050,
        //             easing: 'swing',
        //             step: function (now) {
        //                 $(this).text(Math.ceil(now));
        //             },
        //             complete: function () {
        //                 $(this).prop().stop(false, true);
        //             }
        //         });
        //     });

        // }
    });
    // slider previous button
    $('.question__back').on('click', function () {
        $('html, body').animate({scrollTop: '0px'}, 100);
        $('.main .main__step.active').each(function () {
            if (!$(this).is(':first-child')) {
                $(this).removeClass('active').prev().addClass('active');

                var paginB = $(this).parents('main').find('.steps_allsteps a');
                paginB.removeClass('active');
                var number = $(this).index()+1;
                var width_line = $(this).prev().attr('data-step');

                paginB.eq(number).removeClass('complete');
                paginB.eq(number - 1).addClass('active');
                $('.steps').css('display', 'block');
                $('.steps_line__progress').width(width_line);
                $('.steps_line__text').css({"left": width_line});
                $('.steps_line__text span').text(width_line);
            } else {
                window.location = "./";
            }
            if($('#characteristics').hasClass('active')) {
                $('.steps_line__progress').width(100 + '%');
                $('.steps_line__text').css('left', 100 + '%');
                $('.steps_line__text span').text(100 + '%');

            };
        });

    });

    $('.step').on('click', function () {
        if($(this).is(':first-child')) {
            window.location = "/";
        } else {
            $('body').scrollTop(0);
            var currentIndex = $(this).index();
            var activeIndex = $(this).parent().find('.active').index();

            var paginB = $(this).parents('main').find('.steps_allsteps a');

            for(var i = currentIndex; i <= activeIndex; i++) {
                paginB.eq(i).removeClass('active').removeClass('complete');
            };
            $(this).addClass('active');
            $('.main .main__step').removeClass('active').eq(currentIndex - 1).addClass('active');
            var width_line = $('.main .main__step.active').attr('data-step');

            $('.steps_line__progress').width(width_line);
            $('.steps_line__text').css({"left": width_line});
            $('.steps_line__text span').text(width_line);
        }




    });
    //---end

    $('.choose-gender a').on('click', function (e) {
        var newText = $(this).find('legend').text();
        var a = [];
        var element = {};

        var id_name = 'gender';
        element[id_name] = newText;
        a.push(element);
        localStorage.setItem('data', JSON.stringify(a));
    });
    var gen = JSON.parse(localStorage.getItem('data'))[0].gender;


    //---choose theme
    if (gen == 'Female' || gen == 'ქალი' || gen=="женский") {
        $("body").removeClass('male');
        $("body").addClass('female');
    } else {
        $("body").addClass('male');
    }
    if ($('body').hasClass('female')) {
        $('.theme').addClass('female')
    } else {
        $('.theme').addClass('male')
    }

    function SaveData(id_name, newText) {
        var element = {};
        var kek = JSON.parse(localStorage.getItem('data'));

        var isConstains = false;
        kek.forEach(function (item) {
            if (item[id_name] != null) {
                item[id_name] = newText;
                isConstains = true;
            }
        });
        if (!isConstains) {
            element[id_name] = newText;
            kek.push(element);
        }
        localStorage.setItem('data', JSON.stringify(kek));
    }

    $('.test-answer').on('click', function () {

        var _th = $(this),
            newText1 = _th.attr('data-answer'),
            id_name1 = _th.parent().parent()[0].id;
        if(_th.parents().is('#activity')) {
            newText1 = _th.attr('data-active');
        }
        SaveData(id_name1, newText1);

    });

    $('.test-multi-answer').on('click', function () {

        var tn_array = Array();
        $(this).siblings('[data-multi-choose = "check"]').each(
            function () {
                tn_array.push($(this).attr("data-answer"));
            }
        );
        $(this).attr('data-check', tn_array);
        var newText2 = $(this).attr('data-check'),
            id_name2 = $(this).parent().parent()[0].id;
        SaveData(id_name2, newText2);
    });
    $('.test-multi-svg-answer').on('click', function () {
        if ($('.product-modal'))
        var check_ar = Array();

        $(this).siblings('[data-multi-choose = "check"]').each(
            function () {
                check_ar.push($(this).find("span").attr("data-answer"));
            }
        );
        $(this).attr('data-check', check_ar);
        var nocheck_ar = Array();
        $(this).siblings('[data-multi-choose = "no-check"]').each(
            function () {
                nocheck_ar.push($(this).find("span").attr("data-answer"));
            }
        );

        $(this).attr('data-no-check', nocheck_ar);

        var newText2 = $(this).attr('data-check'),
            id_name2 = $(this).parent().parent()[0].id + '(include)';
        SaveData(id_name2, newText2);
        var newText3 = $(this).attr('data-no-check'),
            id_name3 = $(this).parent().parent()[0].id + '(exclude)';
        SaveData(id_name3, newText3);
    });

    //=======valid form
    function inval(_parent, string, message) {
        if (string) {
            _parent.addClass('inval');
            _parent.find('.err').text(message)
        } else {
            _parent.removeClass('inval').removeClass('stop')
        }
    }
    $('.form-menu input').on("input", function () {
        var _this = $(this);
        var n = _this.val();
        var _parent = _this.parent();
        var lengthString = (n == '' );
        var message = 'This field is required.';
        inval(_parent, lengthString, message);
    });
    $('.form-menu input[type="tel"]').on("cut copy paste",function(e) {
      e.preventDefault();
    });
    $('.form-menu [name="age"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var _parent = _this.parent();
        var ageString = ((w < 18) || (w > 99));
        var message = 'Please enter a value between 18 and 99.';
        
        inval(_parent, ageString, message);
    });
    $('#metric [name="height"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var heightString = ((w < 135) ||(w > 256));
        var message = 'Please enter a value between 135 and 256.';
        inval(parentw, heightString, message);
    });
    $('#metric [name="target"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var weightString = ((w < 40) || ( w > 180));
        var message = 'Please enter a value between 40 and 180.';
        inval(parentw, weightString, message);
    });
    $('#metric [name="weight"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var weightString = ((w < 40) || ( w > 180));
        var message = 'Please enter a value between 40 and 180.';
        inval(parentw, weightString, message);
    });
    $('#imperial [name="ft"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var heightString = ((w < 4) ||(w > 8));
        var message = 'Please enter a value between 4 and 8.';
        inval(parentw, heightString, message);
    });
    $('#imperial [name="inch"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var heightString = ((w < 0) || (w > 11) || (w == ''));
        var message = 'Please enter a value between 0 and 11.';
        inval(parentw, heightString, message);
    });
    $('#imperial [name="target"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var weightString = ((w < 90) || ( w > 400));
        var message = 'Please enter a value between 90 and 400.';
        inval(parentw, weightString, message);
    });

    $('#imperial [name="weight"]').on("input", function (e) {
        var reg = /^[0-9]+$/;
        for (var i = 0; i < e.target.value.length; i++) {
          if (!reg.test(e.target.value[i]))
            $(this).val(e.target.value.slice(0, i) + e.target.value.slice(i + 1))
        }
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent();
        var weightString = ((w < 90) || ( w > 400));
        var message = 'Please enter a value between 90 and 400.';
        inval(parentw, weightString, message);
    });

    $('#imperial [name="email"], #metric [name="email"]').on("input", function (e) {
        var _this = $(this);
        var w = _this.val(function(_, v){
            return v.replace(/\s+/g, '').toLowerCase();
        });
        var w = _this.val();
        var parentw = _this.parent().parent();
        var mailString = validateEmail(w);
        var message = 'Invalid Email';
        inval(parentw, mailString, message);
    });

    $('#imperial [name="email"], #metric [name="email"]').on("keydown", function (e) {
        if (e.which == 32) {
            return false;
        }
        if (e.which == 39 ) {
            var _this = $(this);
            var w = _this.val();
            if (w.length === 0) return false;
            var parentw = _this.parent().parent();
            var mailString = validateEmail(w);
            var message = 'Invalid Email';
            inval(parentw, mailString, message);    
        }
    });
    function changeResizeAutocomplete(idName) {
        var _this = $(idName + ' [name="email"]');
        var parentThis = _this.parent().parent();
        var cval = parentThis.find('.eac-cval');
        var vval = parentThis.find('.eac-sugg');

        cval.css({
            'font-size': _this.css('font-size')
        });
        
        var tw = parseFloat(_this.css('width')) - parseFloat(_this.css('padding-left')) - parseFloat(_this.css('padding-right'));
        var ev = parseFloat(parentThis.find('.eac-cval').css('width'));
        vval.css({
            'font-size': _this.css('font-size'),
            'left': (tw / 2) + (ev / 2) + 8
        });
    }

    $( window ).resize(function() {
        changeResizeAutocomplete('#imperial');
        changeResizeAutocomplete('#metric');
    });
    $('#imperial [name="email"], #metric [name="email"]').on('blur', function (e) {
        var _this = $(this);
        var w = _this.val();
        if (w.length === 0) return false;
        var parentw = _this.parent().parent();
        var mailString = validateEmail(w);
        var message = 'Invalid Email';
        inval(parentw, mailString, message);
    });

    $('#imperial [name="email"], #metric [name="email"]').on('click', function() {
        var _this = $(this);
        var w = _this.val();
        var parentw = _this.parent().parent();
        var mailString = validateEmail(w);
        var message = 'Invalid Email';
        inval(parentw, mailString, message);
    });

    function validateEmail(email) {
        var re = /^[a-zA-Z0-9\'+=_`~-]+(?:\.[a-zA-Z0-9\'+=_`~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/i;
        if (email.indexOf('@') != -1 && 
            email.slice(email.indexOf('@')).indexOf('.') != -1 &&
            email.slice(email.indexOf('@') + 1).slice(email.slice(email.indexOf('@') + 1).indexOf('.') + 1).length < 2 )
            return true;
            
        return !re.test(String(email).toLowerCase());
    }

    function SerialForm(viewArr, type) {
        var view = {};
        for (var i in viewArr) {
            view[viewArr[i].name] = viewArr[i].value;
        }
        view['type'] = type;
        var textForm = view,
            id_form = 'measurements';
        SaveData(id_form, textForm);
        setTimeout(function () {
            $('#result').css('display','flex').siblings('section').remove();
            $('html, body').animate({scrollTop: '0px'}, 100);
        }, 5000);
    }

    $('#metric .next-question').click(function (e) {
        e.preventDefault();
        var viewArr = $(this).closest('#metric').serializeArray();
        SerialForm(viewArr, 'metric')
        var data_from = JSON.parse(localStorage.getItem('data'));
    });

    $('#imperial .next-question').click(function (e) {
        e.preventDefault();
        var viewArr = $(this).closest('#imperial').serializeArray();
        SerialForm(viewArr, 'imperial');
        var data_from = JSON.parse(localStorage.getItem('data'));

    });

});
// window.getAnswersData = function(e) {
//     return getAnswers().data ? getAnswers().data[e] : ""
// }

function initCalories() {
    (function () {
        var gen = JSON.parse(localStorage.getItem('data'))[0].gender;
        var formA = parseInt(JSON.parse(localStorage.getItem('data'))[9].measurements.age);
        var formW = parseInt(JSON.parse(localStorage.getItem('data'))[9].measurements.weight);
        var formH = parseInt(JSON.parse(localStorage.getItem('data'))[9].measurements.height);
        var formT = parseInt(JSON.parse(localStorage.getItem('data'))[9].measurements.target);
        var formH_m = formH / 100;
        var activity = JSON.parse(localStorage.getItem('data'))[7].activity;

        //=======CALORIES

        if (gen == 'Female') {
            var cal = Math.floor(((10 * formT) + (6.25 * formH) - (5 * formA) - 161) * activity);
        } else {
            cal = Math.floor(((10 * formT) + (6.25 * formH) - (5 * formA) + 5) * activity);
        }

        var min = Math.trunc(cal / 10) * 10 - 50;
        var max = Math.floor(min + 100);

        $(function () {
            var _this = $('#calories');
            _this.find('.svg-graph-2__from-title').text(min);
            _this.find('.svg-graph-2__to-title').text(max);
            _this.find('.recom_cal').text(cal)
        });

        //========BMI
        var bmi = parseFloat((formW / Math.pow(formH_m, 2)).toFixed(0));
        // console.log('bmi ' + bmi);
        $('#bmi .bmi_text p').text(bmi);
        $('#graph-1').attr('data-percent', (bmi * 1.5));
        if (bmi > 0 && bmi <= 18.5) {
            $('#bmi').find('.recom_cal').text('Underweight')
        } else if (bmi > 18.5 && bmi <= 25) {
            $('#bmi').find('.recom_cal').text('Normal')
        } else if (bmi > 25 && bmi <= 30) {
            $('#bmi').find('.recom_cal').text('Overweight')
        } else if (bmi > 30) {
            $('#bmi').find('.recom_cal').text('Obesity')
        }
        (function () {
                var e = new Snap("#graph-1")
                    , i = e.select("#colored")
                    , n = i.getTotalLength()
                    , r = e.select(".cls-2")
                    , p = e.select(".cls-3")
                    , j = e.select(".cls-4")
                    , s = parseFloat(e.attr("data-percent"))
                    , o = n / (100 / s)
                    , a = i.getPointAtLength(o);
                r.attr({
                    cx: a.x,
                    cy: a.y
                });
                p.attr({
                    cx: a.x,
                    cy: a.y
                });
                j.attr({
                    cx: a.x,
                    cy: a.y
                });
            }
        )();
        //========ACHIEVABLE WEIGHT
        var achievable = parseFloat((((formW + formT) / 2 - .2) * 0.95).toFixed(0));
        $('#achievable .recom_cal').html(achievable + "<p> Kilograms</p>");

        //=======METABOLIC AGE
        var bmi_coef = (bmi / 23);
        var activity_coef = (activity / 1.4);
        var metabolic = Math.ceil(formA * bmi_coef * activity_coef);
        if (metabolic < 18) {
            $('#metabolic .recom_cal').text(18);
            $('#metabolic').find('.small').addClass('active')
        } else if (metabolic > 17 && metabolic <= 30) {
            $('#metabolic .recom_cal').text(metabolic);
            $('#metabolic').find('.small').addClass('active')
        } else if (metabolic > 30 && metabolic <= 45) {
            $('#metabolic').find('.young').addClass('active');
            $('#metabolic .recom_cal').text(metabolic);
        } else if (metabolic > 45 && metabolic <= 65) {
            $('#metabolic').find('.middle').addClass('active');
            $('#metabolic .recom_cal').text(metabolic);
        } else if (metabolic > 65) {
            $('#metabolic').find('.old').addClass('active');
            $('#metabolic .recom_cal').text(metabolic);
        }


        //======= WATER
        (function () {
            function decimalAdjust(type, value, exp) {
                // Если степень не определена, либо равна нулю...
                if (typeof exp === 'undefined' || +exp === 0) {
                    return Math[type](value);
                }
                value = +value;
                exp = +exp;
                // Если значение не является числом, либо степень не является целым числом...
                if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
                    return NaN;
                }
                // Сдвиг разрядов
                value = value.toString().split('e');
                value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
                // Обратный сдвиг
                value = value.toString().split('e');
                return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
            }

            // Десятичное округление к ближайшему
            if (!Math.round10) {
                Math.round10 = function (value, exp) {
                    return decimalAdjust('round', value, exp);
                };
            }
        })();


        function gender(gen) {
            if (gen === "Female") {
                return 31;
            } else {
                return 35;
            }
        }

        var volume_water = Math.round10(formW * gender(gen) / 1000, -1);
        debounce(volume_water);

        function debounce(value) {
            if (value >= 5) {
                value = 5
            }
            if (value <= 1) {
                value = 1
            }
            return 99 - value * 20;
        }

        $("#SVGID_1_").css({
            "-webkit-transform": "translateY(" + debounce(volume_water) + "%)",
            "-ms-transform": "translateY(" + debounce(volume_water) + "%)",
            "transform": "translateY(" + debounce(volume_water) + "%)"
        });
        $('#water-formula .recom').text(volume_water)

    })()
}

function initCaloriesImper() {
    var gen = JSON.parse(localStorage.getItem('data'))[0].gender,
        data_form = JSON.parse(localStorage.getItem('data'))[9].measurements,
        activity = JSON.parse(localStorage.getItem('data'))[7].activity,
        data_age = data_form.age,
        heightFT = parseInt(data_form.ft),
        heightInch = parseInt(data_form.inch),
        heightCM = ((heightFT * 12) + heightInch) * 2.54,
        heightM = heightCM / 100,
        weightLB = parseInt(data_form.weight),
        weightTLB = parseInt(data_form.target),
        weightKG = Math.ceil(weightLB * .45),
        weightT_KG = Math.ceil(weightTLB * .45);

    //=======CALORIES

    if (gen == 'Female') {
        var cal = Math.floor(((10 * weightT_KG) + (6.25 * heightCM) - (5 * data_age) - 161) * activity);
    } else {
        cal = Math.floor(((10 * weightT_KG) + (6.25 * heightCM) - (5 * data_age) + 5) * activity);
    }

    var min = Math.trunc(cal / 10) * 10 - 50;
    var max = Math.floor(min + 100);

    $(function () {
        var _this = $('#calories');
        _this.find('.svg-graph-2__from-title').text(min);
        _this.find('.svg-graph-2__to-title').text(max);
        _this.find('.recom_cal').text(cal)
    });

    //========BMI
    var bmi = parseFloat((weightKG / Math.pow(heightM, 2)).toFixed(0));
    // console.log('bmi ' + bmi);
    $('#bmi .bmi_text p').text(bmi);
    $('#graph-1').attr('data-percent', (bmi * 1.5));
    if (bmi > 0 && bmi < 18.5) {
        $('#bmi').find('.recom_cal').text('Underweight')
    } else if (bmi > 18.5 && bmi <= 25) {
        $('#bmi').find('.recom_cal').text('Normal')
    } else if (bmi > 25 && bmi <= 30) {
        $('#bmi').find('.recom_cal').text('Overweight')
    } else if (bmi > 30) {
        $('#bmi').find('.recom_cal').text('Obesity')
    }
    (function () {
            var e = new Snap("#graph-1")
                , i = e.select("#colored")
                , n = i.getTotalLength()
                , r = e.select(".cls-2")
                , p = e.select(".cls-3")
                , j = e.select(".cls-4")
                , s = parseFloat(e.attr("data-percent"))
                , o = n / (100 / s)
                , a = i.getPointAtLength(o);
            r.attr({
                cx: a.x,
                cy: a.y
            });
            p.attr({
                cx: a.x,
                cy: a.y
            });
            j.attr({
                cx: a.x,
                cy: a.y
            });
        }
    )();
    //========ACHIEVABLE WEIGHT
    var achievable = parseFloat((((weightLB + weightTLB) / 2 - .2) * 0.95).toFixed(0));
    $('#achievable .recom_cal').html(achievable + '<p> Pounds</p>');

    //=======METABOLIC AGE
    var bmi_coef = (bmi / 23);
    var activity_coef = (activity / 1.4);
    var metabolic = Math.ceil(data_age * bmi_coef * activity_coef);
    if (metabolic < 18) {
        $('#metabolic .recom_cal').text(18);
        $('#metabolic').find('.small').addClass('active')
    } else if (metabolic > 17 && metabolic <= 30) {
        $('#metabolic .recom_cal').text(metabolic);
        $('#metabolic').find('.small').addClass('active')
    } else if (metabolic > 30 && metabolic <= 45) {
        $('#metabolic').find('.young').addClass('active');
        $('#metabolic .recom_cal').text(metabolic);
    } else if (metabolic > 45 && metabolic <= 65) {
        $('#metabolic').find('.middle').addClass('active');
        $('#metabolic .recom_cal').text(metabolic);
    } else if (metabolic > 65) {
        $('#metabolic').find('.old').addClass('active');
        $('#metabolic .recom_cal').text(metabolic);
    }


    //======= WATER
    (function () {
        function decimalAdjust(type, value, exp) {
            // Если степень не определена, либо равна нулю...
            if (typeof exp === 'undefined' || +exp === 0) {
                return Math[type](value);
            }
            value = +value;
            exp = +exp;
            // Если значение не является числом, либо степень не является целым числом...
            if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
                return NaN;
            }
            // Сдвиг разрядов
            value = value.toString().split('e');
            value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
            // Обратный сдвиг
            value = value.toString().split('e');
            return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
        }

        // Десятичное округление к ближайшему
        if (!Math.round10) {
            Math.round10 = function (value, exp) {
                return decimalAdjust('round', value, exp);
            };
        }
    })();


    function gender(gen) {
        if (gen === "Female") {
            return 31;
        } else {
            return 35;
        }
    }

    var volume_water = Math.round10((weightKG * gender(gen) / 1000) * 33.814, 0);
    debounce(volume_water);

    function debounce(value) {
        if (value >= 169) {
            value = 169
        }
        if (value <= 1) {
            value = 1
        }
        return 100 - (value * 100 / 169);
        // return 99 - value * 20;
    }

    $("#SVGID_1_").css({
        "-webkit-transform": "translateY(" + debounce(volume_water) + "%)",
        "-ms-transform": "translateY(" + debounce(volume_water) + "%)",
        "transform": "translateY(" + debounce(volume_water) + "%)"
    });
    $('#water-formula .recom').text(volume_water).next('span').text('OZ');
    $('#water-formula .recom').text(volume_water).next('p').text(' OZ');

    $('.diapason').find('span').text('');
    $('.diapason .max').text('169 OZ');
    $('.diapason .min').text('0 OZ');


}

$(document).ready(function () {
    // if ($('#result').length) {
    function Result() {

        var data_years = $('#result .data-person-year p'),
            data_cm = $('#result .data-person-height p'),
            data_kg = $('#result .data-person-weight p'),
            data_from = JSON.parse(localStorage.getItem('data'))[9].measurements,
            // data_form_metric = data_from.type == 'metric',
            data_form_imperial = data_from.type == 'imperial';
        if (data_form_imperial) {
            initCaloriesImper();
            // data_cm.html(((parseInt(data_from.ft) + (parseInt(data_from.inch) * .083))).toFixed(1) + '<span>ft</span>');
            data_cm.html(data_from.ft + "'" + data_from.inch + '"');
            data_kg.html(parseInt(data_from.weight) + '<span>lb</span>');

        } else {
            initCalories();
            var metre = (parseFloat(data_from.height) / 100).toFixed(2);
            var parts = metre.split('.');


            data_cm.html(parts[0] + '<em>m </em>' + (parts[1] || 0) + '<em>cm</em>');
            // data_cm.html(data_from.height + '<span>cm</span>');
            data_kg.html(data_from.weight + '<span>kg</span>');
        }
        $('#result .h1 span').text(data_from.name);

        data_years.text(data_from.age);

        

    }
    $('#metric').submit(function (e) {
    //     Result()
        var data_from = JSON.parse(localStorage.getItem('data'));
        var name = data_from[11].measurements.name;
        $('#processing .h1 b span').text(name[0].toUpperCase() + name.slice(1));
    });

    $('#imperial').submit(function (e) {
    //     Result()
        var data_from = JSON.parse(localStorage.getItem('data'));
        var name = data_from[11].measurements.name;
        $('#processing .h1 b span').text(name[0].toUpperCase() + name.slice(1));
    });

    if ($('#result').length > 0 || $('.step-1').length > 0) {
        Result()
    }
    // }

});
if (window.matchMedia("(max-width: 1025px)").matches) {
    $(document).ready(function () {
        $('body').off('touchstart');


        $('.mob__menu').on('click', function () {
            $('.mob__nav').addClass('open');
        });
        $('.mob__nav .close').on('click', function () {
            $('.mob__nav').removeClass('open');
        });
        $('.next-question').on('click', function scroll() {
            var scroller = $('.steps');
            if(!$(this).hasClass('no-choosen')) {
                scroller.animate({scrollLeft: '+=200'}, 500);
            } else {

                scroller.animate({scrollLeft: '+=0'}, 500);
            }

        });
        $('.question__back').on('click', function () {
            var scroller = $('.steps');
            scroller.animate({scrollLeft: '-=160'}, 500);
        });

    });
}

if (window.matchMedia("(max-width: 640px)").matches) {
    $(document).ready(function () {
        $('#result .get-it').clone().appendTo($('.main__datas'));

    });
}

// function firstUpper(word) {
//   return word[0].toUpperCase() + word.slice(1);
// }