/*global jQuery, BsEnhancedTable, siteUrl, bootbox*/
'use strict';

var manageGeneratedMemes = new function ($) {
    // Private properties
    var self = this,
        isInit = false,
        // Grid
        $table = $('#generated-memes-table'),
        $tbody = $table.find('tbody'),
        $overlay = $table.siblings('.grid-loading-overlay'),
        $deleteBtn = $('#generatedmeme-btn-delete'),
        generatedTable,
        // Modal
        $modal = $('#generated-delete-modal'),
        $label = $modal.find('#generated-delete-msglabel'),
        $submitBtn = $modal.find('#generated-delete-submit-btn');
    
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
                '<td>' + row.id + '</td>' +
                '<td><img src="' + row.thumbnail_data + '" /></td>' +
                '<td>' + row.created_at + '</td>' +
                '</tr>'
            );
        }//end for
        
        generatedTable.refreshEvents();
    }//end addGridData()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function populateDeleteField($row) {
        $label.text($row.data('row-id'));
    }//end populateDeleteField()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function submitDelete() {
        var $row = generatedTable.getSelectedRow(),
            url = siteUrl + 'generated/',
            method = 'DELETE';
            
        if ($row === null || $row.length === 0) {
            bootbox.alert('You must select a row to delete.');
            return false;
        }//end if
        url += $row.data('row-id');
        $submitBtn.prop('disabled', true);
        $.ajax({'url': url, 'type': method})
            .done(function () {
                $modal.modal('hide');
                self.refreshGrid();
            })
            .fail(function () {
                bootbox.alert('There was a problem deleting the generated meme.');
            })
            .always(function () {
                $submitBtn.prop('disabled', false);
            });
    }//end submitDelete()
    
    // Description: _____
    // Param: type name Description
    // Return: type Description
    function initEvents() {
        //$deleteBtn
        //generatedTable
        //$table
        //$tbody
        //$modal
        //$label
        //$submitBtn
        
        // Grid events
        generatedTable.on('select', function () {
            $deleteBtn.prop('disabled', false);
        });
        generatedTable.on('deselect', function () {
            $deleteBtn.prop('disabled', true);
        });
        
        // Modal events
        $modal.on('show.bs.modal', function () {
            var $row = generatedTable.getSelectedRow();
            if ($row === null || $row.length === 0) {
                bootbox.alert('You must select a row to delete.');
                return false;
            }//end if
            populateDeleteField($row);
        });
        $submitBtn.on('click.generated', submitDelete);
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
        var url = siteUrl + 'generated',
            method = 'GET';
        
        $overlay.removeClass('hidden');
        $.ajax({'url': url, 'type': method, 'dataType': 'json'})
            .done(function (data) {
                $tbody.find('tr').remove();
                addGridData(data);
            })
            .fail(function () {
                bootbox.alert('There was a problem getting the generated memes data.');
            })
            .always(function () {
                $overlay.addClass('hidden');
            });
    };//end manageGeneratedMemes.refreshGrid()
    
    /**
     * @summary _____
     * @description _____
     * 
     * @param type name Description
     * @retval type Description
     */
    this.init = function () {
        if (isInit === false) {
            generatedTable = new BsEnhancedTable($table);
            initEvents();
            self.refreshGrid();
            isInit = true;
        }//end if
    };//end manageGeneratedMemes.init()
}(jQuery);//end manageGeneratedMemes

//end file generatedmemes.js
