/**
 * Using wp_localize_script will send the next variables:
 *
 * @param {string} message_not_able_change_email
 *                 Just a message with i18n to show to the user that is no possible change the email.
 */
jQuery(function($) {

    var emailElement = $('#account_email');

    emailElement.attr('readonly', true);

    // Add some styles to look like a disabled field
    addStylesToLookDisabled(emailElement);

    // Delete the requiered span.
    deleteRequired(emailElement);

    //
    addMessage(emailElement);

    /**
     * Given an element add styles to look like a disabled field
     * @param DOMelement element 
     *        jquery dom element to be applied the styles
     */
    function addStylesToLookDisabled(element) {
        emailElement.css('color', 'gray');
        emailElement.css('background', '#ddd');
    }

    /**
     * Given an element delete the requiered span.
     * @param DOMelement element 
     *        jquery dom element to be deleted the span
     */
    function deleteRequired(element) {
        // The element looks like <label for="account_email">Email address <span class="required">*</span></label>
        var spanRequired = element.prev().find('span');
        spanRequired.remove();
    }

    /**
     * Given an element add a message telling him that is not possible change its email
     * @param DOMelement element 
     *        jquery dom element to be deleted the span
     */
    function addMessage(element) {
        var message = $("<small></small>").text('(' + message_not_able_change_email + ')');
        message.css('color','#999');

        var label = element.prev();
        label.append(message);
    }

});

