/*global jQuery*/
'use strict';

// Exception objects

var InvalidActionException = function InvalidActionException(action) {
    this.message = 'The requested action "' + action + '" is invalid.';
    this.name = 'InvalidActionException';
};//end InvalidActionException

var InvalidCallbackException = function InvalidCallbackException() {
    this.message = 'The callback sent is not a function.';
    this.name = 'InvalidCallbackException';
};//end InvalidCallbackException

var InvalidIndexException = function InvalidIndexException(index) {
    this.message = 'The requested index "' + index + '" is invalid.';
    this.name = 'InvalidIndexException';
};//end InvalidIndexException

// Additional functions

function generate_uuid() {
    // Courtesy of: http://stackoverflow.com/a/2117523
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
        return v.toString(16);
    });
}

// Bootstrap Enhanced Table object

var BsEnhancedTable = function BsEnhancedTableObject(elem) {
    // Private properties
    var self = this,
        $ = jQuery,
        $elem = $(elem),
        $tbody = $elem.find('tbody'),
        activeClass = 'success',
        actions = {
            'click': {},
            'select': {},
            'deselect': {}
        };

    // Private methods

    // Description: _____
    // Param: type name Description
    // Return: type Description
    function fireEvent(action, $row) {
        var callbackId;

        if (typeof actions[action] === 'undefined') {
            throw new InvalidActionException(action);
        }//end if

        for (callbackId in actions[action]) {
            if (actions[action].hasOwnProperty(callbackId)) {
                actions[action][callbackId].apply($row, [$row]);
            }//end if
        }//end for
    }//end fireEvent()

    // Description: _____
    // Param: type name Description
    // Return: type Description
    function deselectRow($row) {
        $row.removeClass(activeClass);
        fireEvent('deselect', $row);
    }//end deselectRow()

    // Description: _____
    // Param: type name Description
    // Return: type Description
    function deselectActiveRows() {
        $tbody.find('tr.' + activeClass).each(function () {
            deselectRow($(this));
        });
    }//end deselectActiveRows()

    // Description: _____
    // Param: type name Description
    // Return: type Description
    function selectRow($row) {
        deselectActiveRows();
        $row.addClass(activeClass);
        fireEvent('select', $row);
    }//end selectRow()

    // Description: _____
    // Param: type name Description
    // Return: type Description
    function construct() {
        deselectActiveRows();
        self.refreshEvents();
    }//end construct()

    // Public methods

    /**
     * @summary Clears and recreates row click events.
     * @retval undefined
     */
    this.refreshEvents = function () {
        $tbody.find('tr').each(function () {
            var $this = $(this);
            $this.off('click.bset');
            $this.on('click.bset', function () {
                var $this = $(this);
                fireEvent('click', $this);
                if ($this.hasClass(activeClass)) {
                    deselectActiveRows();
                } else {
                    selectRow($this);
                }
            });
        });
    };//end BsEnhancedTableObject.refreshEvents()

    /**
     * @summary Add a callback to the specified action.
     *
     * @param string action Action to add callback to
     * @param function callback Callback to add
     * @retval string Unique ID to added callback. This is used to remove it with .off() later
     * @throws InvalidActionException
     * @throws InvalidCallbackException
     */
    this.on = function (action, callback) {
        var id;

        if (typeof actions[action] === 'undefined') {
            throw new InvalidActionException(action);
        }//end if
        if (typeof callback !== 'function') {
            throw new InvalidCallbackException;
        }//end if

        id = generate_uuid();
        actions[action][id] = callback;

        return id;
    };//end BsEnhancedTableObject.on()

    /**
     * @summary Remove one/all event callback(s) from the specified action
     *
     * @param string action Action to remove event callback(s) from
     * @param string index (optional) Index of callback to remove, or remove all if not specified
     * @retval undefined
     * @throws InvalidActionException
     * @throws InvalidIndexException
     */
    this.off = function (action, index) {
        var prop;
        if (typeof actions[action] === 'undefined') {
            throw new InvalidActionException(action);
        }//end if
        if (typeof index === 'undefined') {
            for (prop in actions[action]) {
                if (actions[action].hasOwnProperty(prop)) {
                    delete actions[action][prop];
                }//end if
            }//end for
        } else {
            if (typeof actions[action][index] === 'undefined') {
                throw new InvalidIndexException(index);
            }//end if
            delete actions[action][index];
        }//end if/else
    };//end BsEnhancedTableObject.off()

    /**
     * @summary Return a jQuery object containing the selected row, or null if no row is selected.
     * @retval mixed jQuery object containing selected row if one is selected, or null otherwise
     */
    this.getSelectedRow = function () {
        var $selected = $tbody.find('tr.' + activeClass);
        return ($selected.length > 0) ? $selected.first() : null;
    };//end BsEnhancedTableObject.getSelectedRow()

    // Run constructor
    construct();
};//end BsEnhancedTableObject

//end file bs-enhanced-table.js
