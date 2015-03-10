/*global jQuery, viewer*/
'use strict';

var generator = new function ($) {
    // Private properties
    var self = this,
        $createButton = $('#meme-create-blank'),
        $allMemeButtons = $('.btn-meme'),
        $hiddenRow = $('#meme-hidden-row'),
        $searchInput = $('#search-input'),
        $searchReset = $('#meme-search-reset'),
        // Generate Meme Modal
        $memeModal = $('#meme-modal'),
        $memeTextInputs = $memeModal.find('input[type="text"]'),
        $memeTopText = $memeModal.find('#meme-top-text'),
        $memeBottomText = $memeModal.find('#meme-bottom-text'),
        $memeRadios = $memeModal.find('input[type="radio"]'),
        $saveMemeBtn = $memeModal.find('#save-meme'),
        // View Meme Modal
        $viewModal = $('#view-modal'),
        $viewImage = $viewModal.find('img'),
        $viewLink = $viewModal.find('a');
    
    // Private methods
    
    // Description: Generates a new meme based on the data input into the modal.
    // Param: Meme memeObj Meme object to pull image data from
    // Return: undefined
    function generateMeme(memeObj) {
        var url = siteUrl + 'generated',
            method = 'POST',
            data = {
                'base64data': memeObj.getImageData()
            };
        
        $saveMemeBtn.prop('disabled', true);
        $.ajax({'url': url, 'type': method, 'data': data})
            .done(function (id) {
                $memeModal.modal('hide');
                viewer.display(id);
            })
            .fail(function () {
                bootbox.alert('There was a problem generating the meme.');
            })
            .always(function () {
                $saveMemeBtn.prop('disabled', false);
            });
    }//end generateMeme()
    
    // Description: Generates new modal input events based on the passed meme object.
    // Param: Meme memeObj Meme object to call functions from
    // Return: undefined
    function createInputEvents(memeObj) {
        $memeTopText.on('keyup.meme', function () {
            memeObj.setTopText($(this).val());
        });
        $memeBottomText.on('keyup.meme', function () {
            memeObj.setBottomText($(this).val());
        });
        $memeRadios.on('change.meme', memeObj.refresh);
        $saveMemeBtn.on('click.meme', function () {
            generateMeme(memeObj);
        });
    }//end createInputEvents()
    
    // Description: Destroys the existing modal input events.
    // Param: none
    // Return: undefined
    function destroyInputEvents() {
        $memeTextInputs.off('keyup.meme');
        $memeRadios.off('change.meme');
        $saveMemeBtn.off('click.meme');
    }//end destroyInputEvents()
    
    // Description: Displays the Generate Meme modal without a meme displayed.
    // Param: none
    // Return: undefined
    function onCreateBlankClick() {
        var memeObj = new Meme();
        $memeModal.find('.modal-title').text('Blank Meme');
        createInputEvents(memeObj);
    }//end onCreateBlankClick()
    
    // Description: Displays the Generate Meme modal, called when a meme button is clicked.
    // Param: none
    // Return: undefined
    function onMemeClick() {
        var $this = $(this),
            memeId = $this.data('meme-id'),
            url = siteUrl + 'meme/',
            method = 'GET',
            memeObj;
            
        if (!memeId) {
            return bootbox.alert('Meme does not appear to have an ID.');
        }//end if
        url += memeId;
        $allMemeButtons.prop('disabled', true);
        
        $.ajax({'url': url, 'type': method, 'dataType': 'json'})
            .done(function (data) {
                memeObj = new Meme(data.image_data);
                $memeModal.find('.modal-title').text(data.name);
                $memeTopText.val(data.top_text_template);
                $memeBottomText.val(data.bottom_text_template);
                memeObj.setTopText($memeTopText.val());
                memeObj.setBottomText($memeBottomText.val());
                createInputEvents(memeObj);
                $memeModal.modal('show');
            })
            .fail(function () {
                bootbox.alert('Unable to get meme data.');
            })
            .always(function () {
                $allMemeButtons.prop('disabled', false);
            });
    }//end onMemeClick()
    
    // Description: Removes the hidden class from the hidden meme row.
    // Param: none
    // Return: undefined
    function showHiddenMemes() {
        $hiddenRow.removeClass('hidden');
    }//end showHiddenMemes()
    
    // Description: Loops through all meme buttons and hides the ones whose tags
    //              don't match the tags in the search query.
    // Param: string searchString String of space-separated tags to search for
    // Return: undefined
    function runMemeSearch(searchString) {
        var searchTags = String(searchString).toLowerCase().split(' ');
        // Remove empty values
        searchTags = searchTags.filter(function (e) {
            return e;
        });
        // Check all memes
        $allMemeButtons.each(function () {
            var $this = $(this),
                $container = $this.parent(),
                memeTags = $this.data('meme-tags').split(' ');
            // Get array intersect of meme tags
            memeTags = memeTags.filter(function (x) {
                return (searchTags.indexOf(x) !== -1);
            });
            // Add/remove 'hidden' class as needed
            if (searchTags.length > 0 && memeTags.length === 0) {
                $container.addClass('hidden');
            } else {
                $container.removeClass('hidden');
            }
        });
    }//end runMemeSearch()
    
    // Public methods
    
    /**
     * @summary Initializes the events used to generate memes.
     * @retval undefined
     */
    this.init = function () {
        $createButton.on('click.meme', onCreateBlankClick);
        $allMemeButtons.on('click.meme', onMemeClick);
        $memeModal.on('hidden.bs.modal', function () {
            destroyInputEvents();
            $memeModal.find('input[type=text]').val('');
        });
        $memeModal.on('shown.bs.modal', function () {
            $('#meme-top-text').focus();
        });
        $viewModal.on('hidden.bs.modal', function () {
            $viewImage.attr('src', '');
            $viewLink.attr('href', '').text('');
        });
        $searchInput.on('keyup.meme', function () {
            runMemeSearch($(this).val());
        });
        $searchReset.on('click.meme', function () {
            runMemeSearch('');
        })
        new Konami(showHiddenMemes);
    };//end generator.init()
}(jQuery);//end generator

//end file generator.js
