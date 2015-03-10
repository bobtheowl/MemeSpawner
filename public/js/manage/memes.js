/*global jQuery, siteUrl, bootbox, BsEnhancedTable*/
'use strict';

var manageMemes = new function ($) {
    // Private properties
    var self = this,
        isInit = false,
        $table = $('#memes-table'),
        $tbody = $table.find('tbody'),
        $overlay = $table.siblings('.grid-loading-overlay'),
        memeTable,
        // Toolbar buttons
        $addBtn = $('#meme-btn-add'),
        $editBtn = $('#meme-btn-edit'),
        $delBtn = $('#meme-btn-delete'),
        // Modals
        $addModal = $('#meme-add-modal'),
        $editModal = $('#meme-edit-modal'),
        $deleteModal = $('#meme-delete-modal'),
        // Add Modal Objects
        $canvas = $('#meme-add-image'),
        $containerImage = $('#meme-add-image-elem'),
        memeImage = $containerImage[0];

    // Private methods
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function addGridData(data) {
        var i = 0, length = data.length, row;
        
        for (i; i < length; i++) {
            row = data[i];
            $tbody.append(
                '<tr data-row-id="' + row.id + '">' +
                '<td>' + row.name + '</td>' +
                '<td><input type="checkbox" disabled ' + ((row.is_hidden) ? 'checked ' : '') + '/></td>' +
                '<td>' + row.created_at + '</td>' +
                '<td>' + row.updated_at + '</td>' +
                '</tr>'
            );
        }//end for
        
        memeTable.refreshEvents();
    }//end addGridData()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function populateEditFields($row) {
        var url = siteUrl + 'meme/' + $row.data('row-id'),
            method = 'GET';
        
        $editModal.find('input').val('').prop('disabled', true);
        $editModal.find('select').val('f').prop('disabled', true);
        $editModal.find('button').prop('disabled', true);
        $editModal.find('img').attr('src', '').addClass('hidden');
        
        $.ajax({'url': url, 'type': method, 'dataType': 'json'})
            .done(function (data) {
                var tags = [], i = 0, length = data.tags.length;
                
                for (i; i < length; i++) {
                    tags.push(data.tags[i].name);
                }//end for
                
                $('#meme-edit-name').val(data.name);
                $('#meme-edit-toptemplate').val(data.top_text_template);
                $('#meme-edit-bottomtemplate').val(data.bottom_text_template);
                $('#meme-edit-tags').val(tags.join(' '));
                $('#meme-edit-hidden').val((data.is_hidden) ? 't' : 'f');
                $('#meme-edit-image').attr('src', data.thumbnail_data).removeClass('hidden');
                
                $editModal.find('input').prop('disabled', false);
                $editModal.find('select').prop('disabled', false);
                $editModal.find('button').prop('disabled', false);
            })
            .fail(function () {
                $editModal.modal('hide');
                bootbox.alert('There was a problem getting the meme data.');
            });
    }//end populateEditFields()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function populateDeleteField($row) {
        var name = $row.find('td').first().text(),
            $label = $('#meme-delete-msglabel');
        $label.text(name);
    }//end populateDeleteField()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function submitNewMeme() {
        var url = siteUrl + 'meme',
            method = 'POST',
            data = {
                'name': $('#meme-add-name').val(),
                'image_data': memeImage.src,
                'top_text_template': $('#meme-add-toptemplate').val(),
                'bottom_text_template': $('#meme-add-bottomtemplate').val(),
                'tags': $('#meme-add-tags').val().split(' '),
                'is_hidden': $('#meme-add-hidden').val()
            };
        
        $.ajax({'url': url, 'type': method, 'data': data})
            .done(function () {
                $addModal.modal('hide');
                self.refreshGrid();
            })
            .fail(function () {
                bootbox.alert('There was a problem submitting the new meme.');
            });
    }//end submitNewMeme()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function submitEditMeme() {
        var $row = memeTable.getSelectedRow(),
            url = siteUrl + 'meme/',
            method = 'PUT',
            data = {
                'name': $('#meme-edit-name').val(),
                'top_text_template': $('#meme-edit-toptemplate').val(),
                'bottom_text_template': $('#meme-edit-bottomtemplate').val(),
                'tags': $('#meme-edit-tags').val().split(' '),
                'is_hidden': $('#meme-edit-hidden').val()
            };
        
        if ($row === null || $row.length === 0) {
            return bootbox.alert('You must select a row to edit.');
        }//end if
        
        url += $row.data('row-id');
        
        $.ajax({'url': url, 'type': method, 'data': data})
            .done(function () {
                $editModal.modal('hide');
                self.refreshGrid();
            })
            .fail(function () {
                bootbox.alert('There was a problem updating the meme.');
            });
    }//end submitEditMeme()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function submitDeleteMeme() {
        var $row = memeTable.getSelectedRow(),
            url = siteUrl + 'meme/',
            method = 'DELETE';
            
        if ($row === null || $row.length === 0) {
            return bootbox.alert('You must select a row to delete.');
        }//end if
        
        url += $row.data('row-id');
        
        $.ajax({'url': url, 'type': method})
            .done(self.refreshGrid)
            .fail(function () {
                bootbox.alert('There was a problem deleting the meme.');
            })
            .always(function () {
                $deleteModal.modal('hide');
            });
    }//end submitDeleteMeme()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function handleImageDrop(e) {
        var file, imageReader;
        e.preventDefault();
        e.stopPropagation();
        if (e.originalEvent.dataTransfer) {
            if (e.originalEvent.dataTransfer.files.length > 0) {
                file = e.originalEvent.dataTransfer.files[0];
                imageReader = new FileReader();
                imageReader.readAsDataURL(file);
                imageReader.onload = function (imageEvent) {
                    memeImage.src = imageEvent.target.result;
                    memeImage.onload = function () {
                        $canvas.addClass('hidden');
                        $containerImage.removeClass('hidden');
                    }//end memeImage.onload()
                };//end imageReader.onload()
            }//end if
        }//end if
    }//end handleImageDrop()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function initEvents() {
        // Grid events
        memeTable.on('select', function () {
            $editBtn.prop('disabled', false);
            $delBtn.prop('disabled', false);
        });
        memeTable.on('deselect', function () {
            $editBtn.prop('disabled', true);
            $delBtn.prop('disabled', true);
        });
        // Add modal events
        $addModal.on('show.bs.modal', function () {
            memeImage.src = '';
            $canvas.removeClass('hidden');
            $containerImage.addClass('hidden');
            $addModal.find('input').val('');
            $addModal.find('select').val('f');
        });
        $editModal.on('show.bs.modal', function () {
            var $row = memeTable.getSelectedRow();
            if ($row === null || $row.length === 0) {
                bootbox.alert('You must select a row to edit.');
                return false;
            }//end if
            populateEditFields($row);
        });
        $deleteModal.on('show.bs.modal', function () {
            var $row = memeTable.getSelectedRow();
            if ($row === null || $row.length === 0) {
                bootbox.alert('You must select a row to delete.');
                return false;
            }//end if
            populateDeleteField($row);
        });
        $('#meme-edit-submit-btn').on('click.meme', submitEditMeme);
        $('#meme-delete-submit-btn').on('click.meme', submitDeleteMeme);
        $('#meme-add-modal-submit').on('click.meme', submitNewMeme);
        $canvas.on('dragover.meme, dragenter.meme', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $canvas.on('drop.meme', handleImageDrop);
    }//end initEvents()

    // Public methods

    /**
     * @summary _____
     * @description _____
     * 
     * @param type name Description
     * @retval type Description
     */
    this.refreshGrid = function () {
        var url = siteUrl + 'meme',
            method = 'GET';
        $overlay.removeClass('hidden');
        $.ajax({'url': url, 'type': method})
            .done(function (data) {
                $tbody.find('tr').remove();
                addGridData(data);
            })
            .fail(function () {
                bootbox.alert('Unable to load meme data.');
            })
            .always(function () {
                $overlay.addClass('hidden');
            });
    };//end manageMemes.refreshGrid()
    
    /**
     * @summary _____
     * @description _____
     *
     * @param type name Description
     * @retval type Description
     */
    this.init = function () {
        if (!isInit) {
            memeTable = new BsEnhancedTable($table);
            initEvents();
            self.refreshGrid();
            isInit = true;
        }//end if
    };//end manageMemes.init()
}(jQuery);//end manageMemes

//end file ./js/manage/memes.js
