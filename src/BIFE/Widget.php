<?php
// vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
// +--------------------------------------------------------------------+
// |                       BIFE - Buil It FastEr                        |
// +--------------------------------------------------------------------+
// | This file is part of BIFE.                                         |
// |                                                                    |
// | BIFE is free software; you can redistribute it and/or modify it    |
// | under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or  |
// | (at your option) any later version.                                |
// |                                                                    |
// | BIFE is distributed in the hope that it will be useful, but        |
// | WITHOUT ANY WARRANTY; without even the implied warranty of         |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU   |
// | General Public License for more details.                           |
// |                                                                    |
// | You should have received a copy of the GNU General Public License  |
// | along with Hooks; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA      |
// +--------------------------------------------------------------------+
// | Created: Wed May 17 18:16:54 ART 2003                              |
// | Authors: Leandro Lucarella <luca@lugmen.org.ar>                    |
// +--------------------------------------------------------------------+
//
// $Id$
//

// +X2C Class 3 :Widget
/**
 * Base widget class.
 *
 * @package BIFE
 * @access public
 * @abstract
 */
class BIFE_Widget {
    /**
     * Attribute list.
     *
     * @var    array $attrs
     * @access protected
     */
    var $attrs = array();

    // ~X2C

    // +X2C Operation 126
    /**
     * Constructor.
     *
     * @param  array $attrs Attributes.
     *
     * @return void
     * @access public
     */
    function BIFE_Widget($attrs) // ~X2C
    {
        $this->__construct($attrs);
    }
    // -X2C

    // +X2C Operation 127
    /**
     * Constructor.
     *
     * @param  array $attrs Attributes.
     *
     * @return void
     * @access public
     */
    function __construct($attrs) // ~X2C
    {
        $this->attrs = $attrs;
    }
    // -X2C

    // +X2C Operation 4
    /**
     * Renders the widget using a template returning a string with the results.
     *
     * @param  HTML_Template_HIT &$template Template object to render the widget.
     *
     * @return string
     * @access public
     * @abstract
     */
    function render(&$template) // ~X2C
    {
        trigger_error('Method not implemented '.get_class($this).
            '::render().', E_USER_ERROR);
    }
    // -X2C

} // -X2C Class :Widget

?>