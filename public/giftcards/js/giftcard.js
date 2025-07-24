
function qtychange(){
    var qty = $('#qty').val();
    var price = $("#amountdisplay").attr('amount');
    var finalamout = qty*price;
    $("#amountdisplay").html(qty+' X '+'$'+price + ' gift card');
    // $("#amountdisplay").attr('amount', price);
    $("#amountdisplay").attr('finalAmount', finalamout);
    $("#amountdisplay").attr('coupondiscount', 0);
    
}
function sqtychange(){
    var qty = $('#sqty').val();
    var price = $("#amountdisplay").attr('amount');
    var finalamout = qty*price;
    $("#amountdisplay").html(qty+' X '+'$'+price + ' gift card');
    $("#amountdisplay").attr('finalAmount', finalamout);
    $("#amountdisplay").attr('coupondiscount', 0);
    
}

    // Default Show 
    $('#someoneform').show();
    $('#selfform').hide();

    // default show Code END
function someOneElse(action){
    if(action=='someone')
    {
        $qtyold=$('#sqty').val();
   if($qtyold>=1){
        var Newqty = $('#sqty').val();
    $('#qty').val(Newqty);
   }
        $('#someone').addClass('active');
        $('#self').removeClass('active');
        $('#selfform').hide();
        $('#someoneform').show();
    }
    if(action=='self')
    {
    var Newqty = $('#qty').val();
    $('#sqty').val(Newqty);
    //  var Newqty = $('#qty').val();   // Get the new quantity value
    // var old_qty = $('#sqty').val(); // Get the currently selected option's value from the select element
    
    // // Find the option with the value equal to `old_qty` and update it
    // $('#sqty option[value="' + old_qty + '"]').val(Newqty).text(Newqty);
		
        $('#self').addClass('active');
        $('#someone').removeClass('active');
        $('#selfform').show();
        $('#someoneform').hide();
    }
}

function giftsend(printCondition){
if(printCondition=='onemail')
{
    $('#giftSendByEmail').show();
}

if(printCondition=='onprint')

$('#giftSendByEmail').hide();

}


function giftsendsomeone(printCondition){
    (printCondition=='onemail')
    {
        $('#emailfields').show();
    }
    
    if(printCondition=='onprint')
    {
    
    $('#emailfields').hide();
    
    }
}

// for giftcards show or hide

$('.giftcardField').hide();
function checkbalance(){
    $('.giftcardField').show();
}



function nextClick(){
    current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		
		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now) {
				// for making fielset appear animation
				opacity = 1 - now;
	
				current_fs.css({
					'display': 'none',
					'position': 'relative'
				});
				next_fs.css({'opacity': opacity});
			}, 
			duration: 600
		});
}


function couponRedeem(section_id) {
    // Get the selected radio button
    var selectedValue = document.querySelector('input[name="coupon"]:checked').value;
    if ($('#coupon_yes_'+section_id).is(':checked')) {
        $('#coupon_code_section_'+section_id).show();
        } 
    if ($('#coupon_no_'+section_id).is(':checked')) {

        $('#coupon_code_section_'+section_id).hide();
    } 

}

$('#future_date_section').hide();
function futureDate() {
    // Get the selected radio button
    var selectedValue = document.querySelector('input[name="future_status"]:checked').value;
    if ($('#future_yes').is(':checked')) {
        $('#future_date_section').show();
    } 
    if ($('#future_no').is(':checked')) {
        $('#future_date_section').hide();
        
    } 

}
//  Validation of Static Form
$("#giftcards").validate({
    rules: {
        amount: {
            required: true,
            number: true,
            maxlength: 8,
        },
        to: {
            required: true,
            email: true,
            maxlength: 60,
        },
        from: {
            required: true,
            email: true,
            maxlength: 60,
        },
        msg: {
            required: true,
            minlength: 20,
        },
        to_name: "required",
        from_name: "required",
        future_date: "required",
    },
    messages: {
        amount: {
            required: "Amount field is required.",
            maxlength: "Please enter  less than 8 digit.",
        },
        to: {
            required: "Please Enter Receiver Email Id",
            maxlength: "Your Receiver email should not be more than 60 characters long.",
        },
        from: {
            required: "Please Enter Sender Email Id",
            maxlength: "Your Sender email should not be more than 60 characters long.",
        },
        msg: {
            required: "Message Field is Required",
            minlength: "Please enter at least 20 characters",
        },
        to_name: "Please Enter Receiver Name",
        from_name: "Please Enter Sender Name",
        future_date: "Please Select Date",
    },

});

