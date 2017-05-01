jQuery(function($) {
	
    var emailElement = $('#email');
    
    emailElement.attr('disabled', true);
    
    //<span class="description">Usernames cannot be changed.</span>
    var message_not_able_to_change_email = $("<span></span>").text(message_not_able_change_email);
    message_not_able_to_change_email.addClass('description');
    emailElement.after(message_not_able_to_change_email);

    // To keep the style
    emailElement.after("&nbsp;");
});