var inFormOrLink;
var singleValid = false;

(function ($) {
    $.extend($.fn, {
	validate: function (callback) {
	    var form = $(this);
	    form.submit(function () {
		singleValid = false;

		$('.tooltip', this).remove();
		$('.error, .title, .required', this).removeClass("error");
		$('.valid', this).removeClass("valid");

		$('[data-rule-required="true"]:visible', this).each(function () {
		    if (!$(this).required()) {
			$(this).removeClass('valid').addClass('error required');
		    } else {
			$(this).removeClass('error').removeClass('required').addClass('valid');
		    }
		});

		$('[data-rule-maxlength]:visible', this).each(function () {
		    if (!$(this).maxlength()) {
			if (!$(this).hasClass('required')) {
			    $(this).removeClass('valid').addClass('error title');
			}
		    } else {
			if (!$(this).hasClass('error')) {
			    $(this).removeClass('error').removeClass('title').addClass('valid');
			}
		    }
		});

		$('[data-rule-minlength]:visible', this).each(function () {
		    if (!$(this).minlength()) {
			if (!$(this).hasClass('required')) {
			    $(this).removeClass('valid').addClass('error title');
			}
		    } else {
			if (!$(this).hasClass('error')) {
			    $(this).removeClass('error').removeClass('title').addClass('valid');
			}
		    }
		});

		$('[data-rule-type]:visible', this).each(function () {
		    var type = $(this).data('rule-type');

		    if (!$(this).validator(type)) {
			if (!$(this).hasClass('required')) {
			    $(this).removeClass('valid').addClass('error title');
			}
		    } else {
			if (!$(this).hasClass('error')) {
			    $(this).removeClass('error').removeClass('title').addClass('valid');
			}
		    }

		});

		$('[data-rule-expiration="true"]:visible', this).each(function () {
		    if (!$(this).expiration()) {
			$(this).removeClass('valid').addClass('error title');
		    } else {
			$(this).removeClass('error').removeClass('title').addClass('valid');
		    }
		});

		$('[data-rule-new-expiration="true"]:visible', this).each(function () {
		    if (!$(this).newExpiration()) {
			if (!$(this).hasClass('required')) {
			    $(this).removeClass('valid').addClass('error title');
			}
		    } else {
			if (!$(this).hasClass('error')) {
			    $(this).removeClass('error').removeClass('title').addClass('valid');
			}
		    }
		});

		$('[data-rule-dob-small="true"]:visible', this).each(function () {
		    if (!$(this).dobSmall()) {
			if (!$(this).hasClass('required')) {
			    $(this).removeClass('valid').addClass('error dob-title');
			}
		    } else {
			if (!$(this).hasClass('error')) {
			    $(this).removeClass('error').removeClass('title').addClass('valid');
			}
		    }
		});

		$('[data-rule-required="false"]:visible', this).each(function () {
			if (!$(this).required()) {
				$(this).removeClass('error').removeClass('title').addClass('valid');
			}
		});

		$('.error', this).errors();
		if ($('.error', this).length)
		    return false;

		inFormOrLink = true;
		if (callback)
		    callback();

		// do not POST form
		if ($(this).hasClass('ajax'))
		    return false;

	    });
	},

	singleValidate: function (callback) {
	    singleValid = true;

	    $('.tooltip', $(this)).remove();
	    $('.error, .title, .required', $(this)).removeClass("error");
	    $('.valid', $(this)).removeClass("valid");

	    $('[data-rule-required="true"]:visible', $(this)).each(function () {
		if (!$(this).required()) {
		    $(this).removeClass('valid').addClass('error required');
		} else {
		    $(this).removeClass('error').removeClass('required').addClass('valid');
		}
	    });

	    $('[data-rule-maxlength]:visible', $(this)).each(function () {
		if (!$(this).maxlength()) {
		    if (!$(this).hasClass('required')) {
			$(this).removeClass('valid').addClass('error title');
		    }
		} else {
		    if (!$(this).hasClass('error')) {
			$(this).removeClass('error').removeClass('title').addClass('valid');
		    }
		}
	    });

	    $('[data-rule-minlength]:visible', $(this)).each(function () {
		if (!$(this).minlength()) {
		    if (!$(this).hasClass('required')) {
			$(this).removeClass('valid').addClass('error title');
		    }
		} else {
		    if (!$(this).hasClass('error')) {
			$(this).removeClass('error').removeClass('title').addClass('valid');
		    }
		}
	    });

	    $('[data-rule-type]:visible', $(this)).each(function () {
		var type = $(this).data('rule-type');

		if (!$(this).validator(type)) {
		    if (!$(this).hasClass('required')) {
			$(this).removeClass('valid').addClass('error title');
		    }
		} else {
		    if (!$(this).hasClass('error')) {
			$(this).removeClass('error').removeClass('title').addClass('valid');
		    }
		}

	    });

	    $('[data-rule-expiration="true"]:visible', $(this)).each(function () {
		if (!$(this).expiration()) {
		    $(this).removeClass('valid').addClass('error title');
		} else {
		    $(this).removeClass('error').removeClass('title').addClass('valid');
		}
	    });

	    $('[data-rule-new-expiration="true"]:visible', $(this)).each(function () {
		if (!$(this).newExpiration()) {
		    if (!$(this).hasClass('required')) {
			$(this).removeClass('valid').addClass('error title');
		    }
		} else {
		    if (!$(this).hasClass('error')) {
			$(this).removeClass('error').removeClass('title').addClass('valid');
		    }
		}
	    });

	    $('[data-rule-dob-small="true"]:visible', $(this)).each(function () {
		if (!$(this).dobSmall()) {
		    if (!$(this).hasClass('required')) {
			$(this).removeClass('valid').addClass('error dob-title');
		    }
		} else {
		    if (!$(this).hasClass('error')) {
			$(this).removeClass('error').removeClass('title').addClass('valid');
		    }
		}
	    });

	    $('.error', $(this)).errors();
	    if ($('.error', $(this)).length)
		return false;

	    if (callback)
		callback();

	},
    });

    $.extend($.fn, {
	required: function () {
	    var val = $(this).val();

	    if ($.trim(val)) {
		return true;
	    }
	},
	maxlength: function () {
	    var self = $(this);

	    var maxlength = self.data('rule-maxlength');
	    var val = self.val();
	    val = $.trim(val);

	    if (maxlength >= val.length) {
		return true;
	    }
	},
	minlength: function () {
	    var self = $(this);

	    var minlength = self.data('rule-minlength');
	    var val = self.val();
	    val = $.trim(val);

	    if (minlength <= val.length) {
		return true;
	    }
	},
	expiration: function () {
	    var month = $("[name='card_exp_date_m']").val();
	    var year = $("[name='card_exp_date_y']").val();

	    var today = new Date();
	    var min_valid = new Date(today.getFullYear(), today.getMonth() + 3, today.getDate());
	    var expiry = new Date(year, month);

	    if (min_valid.getTime() < expiry.getTime()) {
		return true;
	    }
	},
	newExpiration: function () {
	    if ($(".exp-date-one").length > 0) {
		var date = $(".exp-date-one").val().split('/');

		var month = date[0];
		var year = '20' + date[1];

		var today = new Date();
		var min_valid = new Date(today.getFullYear(), today.getMonth() + 3, today.getDate());
		var max_valid = new Date(2038, 1, 1);
		var expiry = new Date(year, month);
		if (expiry.getTime() > min_valid.getTime() && expiry.getTime() < max_valid.getTime()) {
		    return true;
		}
	    }
	},
	dobSmall: function () {
	    if ($(".dob-small").length > 0) {
		var date = $(".dob-small").val().split('/');

		var year = date[2];
		var month = date[0];
		var day = date[1];
		var expiry = new Date(year, month - 1, day);

		var today = new Date();
		var min_valid = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

		if (min_valid.getTime() > expiry.getTime()) {
		    return true;
		}
	    }
	},
	validator: function (type) {
	    var val = $(this).val();
	    val = $.trim(val);

	    if (type == 'name') {
		return !/[~!@#\$%\^&\*\(\)_\+=\}\{\]\[\|:;\?\\\/><]/.test(val);
	    } else if (type == 'address') {
		return !/[~!@\$%\^\+=\}\{_\]\[\|\?\`><]/.test(val);
	    } else if (type == 'country') {
		return !/[~!@#\$%\^&\*\(\)_\+=\}\{\]\[\|:;\?\\><\.,]/.test(val);
	    } else if (type == 'zip-us') {
		return /^\d{5}(-\d{4})?$/.test(val);
	    } else if (type == 'zip-no') {
		return /^[0-9]{4,4}$/.test(val);
	    } else if (type == 'zip-se') {
		return /^\d{3}\s\d{1,2}$/.test(val);
	    } else if (type == 'zip-fr') {
		return /^[0-9]{4,5}$/.test(val);
	    } else if (type == 'zip-ca') {
		return /^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/.test(val);
	    } else if (type == 'zip-uk') {
		return /^[0-9a-zA-Z]{3} *[0-9a-zA-Z]{3}$/.test(val);
	    } else if (type == 'zip-au') {
		return /^[0-9]{3,4}?$/.test(val);
	    } else if (type == 'zip-other') {
		return /^[0-9a-zA-Z\s]{3,12}$/.test(val);
	    } else if (type == 'phone') {
		return /[0-9]{3}-[0-9]{3}-[0-9]{4}/.test(val);
	    } else if (type == 'email') {
		return $pattern = /^[a-zA-Z0-9\'+=_`~-]+(?:\.[a-zA-Z0-9\'+=_`~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/i.test(val);
	    } else if (type == 'creditcard') {
		val = val.replace(/ /g, '');
		var creditCardInfo = $.getCreditCardInfo(val);
		return creditCardInfo.valid;
	    } else if (type == 'mobilecred') {
		return /^[0-9]{16,16}$/.test(val);
	    } else if (type == 'cvv') {
		return /^[0-9]{3,3}$/.test(val);
	    } else if (type == 'exp-date') {
		return /^0[0-9]|10|11|12\/[0-9]{2,2}$/.test(val);
	    } else if (type == 'dob-small') {
		return /^((0[1-9]|1[012])\/(0[1-9]|[12]\d)|(0[13-9]|1[012])\/30|(0[13578]|1[02])-31)\/(19|20)\d\d$/.test(val);
	    }
	},
	errors: function () {
	    var item = 0;
	    $(this).each(function () {
		var self = $(this);

		if (self.hasClass('title')) {
		    var message = self.data('original-title');
		} else if (self.hasClass('dob-title')) {
		    var message = self.data('original-dob-title');
		} else {
		    var message = self.data('original-required');
		}

		var width = self.width();

		self.after('<div class="tooltip hide">' + message + '</div>');
		self.next('.tooltip').css('marginLeft', '-' + ($(this).next('.tooltip').width() / 2 + 10) + 'px');

		self.hover(function () {
		    if (self.hasClass('error') || self.closest('.error').length > 0) {
			$('.tooltip').addClass('hide');
			$(this).next('.tooltip').removeClass('hide');

			// fix long tooltips
			if ($(window).width() <= 480 && $(this).hasClass('tooltip-right')) {
			    center = $(this).width() / 2;
			    $(this).next('.tooltip:after').css({'left':'0','right':center+'px'});
			}


		    } else {
			$(this).next('.tooltip').addClass('hide');
		    }
		}, function () {
		    if (!$(this).is(":focus")) {
			$(this).next('.tooltip').addClass('hide');
		    }
		});

		self.focus(function () {
		    if (self.hasClass('error') || self.closest('.error').length > 0) {
			$(this).next('.tooltip').removeClass('hide');
		    } else {
			$(this).next('.tooltip').addClass('hide');
		    }
		});
		self.blur(function () {
		    $(this).next('.tooltip').addClass('hide');
		});

		item++;
	    });

	    if (!singleValid) {

		$('.error').each(function () {
		    $(this).focus();
		    return false;
		});

	    }


	}
    });
}(jQuery));