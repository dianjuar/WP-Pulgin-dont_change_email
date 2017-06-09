/**
 * Using wp_localize_script will send the next variables:
 *
 * @param {string} message_not_able_change_email
 *         		   Just a message with i18n to show to the user that is no possible change the email.
 */
jQuery(function($) {
	
    var emailElement = $('#email');
    
    emailElement.attr('readonly', true);
    
    // Add some styles to look like a disabled field
    addStylesToLookDisabled(emailElement);
    
    //<span class="description">Usernames cannot be changed.</span>
    var message_not_able_to_change_email = $("<span></span>").text(message_not_able_change_email);
    message_not_able_to_change_email.addClass('description');
    emailElement.after(message_not_able_to_change_email);

    // To keep the style
    emailElement.after("&nbsp;");


    /**
     * Given an element add styles to look like a disabled field
     * @param DOMelement element 
     *        jquery dom element to be applied the styles
     */
    function addStylesToLookDisabled(element) {
        emailElement.css('color', 'rgba(51,51,51,.5)');
        emailElement.css('background', '#F8F8F8');
    }
});