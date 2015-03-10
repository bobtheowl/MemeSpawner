/*global jQuery*/
'use strict';

var viewer = new function ($) {
    // Private properties
    var self = this,
        $allMemeButtons = $('.btn-generated'),
        $viewModal = $('#view-modal'),
        $viewImage = $viewModal.find('#meme-image-display'),
        $viewLink = $viewModal.find('#meme-image-link');
    
    // Private methods
    
    // Description: Displays the generated meme with the ID stored in the button.
    // Param: none
    // Return: undefined
    function handleBtnClick() {
        var $btn = $(this),
            id = $btn.data('meme-id');
        self.display(id);
    }//end handleBtnClick()
    
    // Description: Clears the <img> src and <a> href and text from the Viewer modal.
    // Param: none
    // Return: undefined
    function clearImage() {
        $viewImage.attr('src', '');
        $viewLink.attr('href', '').text('');
    }//end clearImage()
    
    // Public methods
    
    /**
     * @summary Initializes the events for viewing generated memes.
     * @retval undefined
     */
    this.init = function () {
        $allMemeButtons.on('click.viewer', handleBtnClick);
        $viewModal.on('hidden.bs.modal', clearImage);
    };//end viewer.init()
    
    /**
     * @summary Displays the specified generated meme in the meme modal.
     * @param number id ID of generated meme to display
     * @retval undefined
     */
    this.display = function (id) {
        var url = siteUrl + 'generated/' + id,
            method = 'GET';
        
        $allMemeButtons.prop('disabled', true);
        
        $.ajax({'url': url, 'type': method, 'dataType': 'json'})
            .done(function (data) {
                $viewImage.attr('src', data.image_data);
                $viewLink.attr('href', siteUrl + 'generated/view/' + id).text(siteUrl + 'generated/view/' + id);
                $viewModal.modal('show');
            })
            .fail(function () {
                bootbox.alert('There was a problem displaying the generated meme.');
            })
            .always(function () {
                $allMemeButtons.prop('disabled', false);
            });
    };//end viewer.display()
}(jQuery);//end viewer

//end file viewer.js
