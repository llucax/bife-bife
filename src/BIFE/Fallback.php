<?php
// vim: set expandtab tabstop=4 shiftwidth=4 binary:
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
// | Created: Tue May 20 17:57:56 2003                                  |
// | Authors: Leandro Lucarella <luca@lugmen.org.ar>                    |
// +--------------------------------------------------------------------+
//
// $Id$
//

// +X2C includes
require_once 'BIFE/Container.php';
// ~X2C

// +X2C Class 61 :Fallback
/**
 * Fallback widget to use when no specific widget is implemented.
 *
 * @package BIFE
 * @access public
 * @abstract
 */
class BIFE_Fallback extends BIFE_Container {
    /**
     * Name of the widget.
     *
     * @var    string $name
     * @access private
     */
    var $name = '';

    // ~X2C

    // +X2C Operation 62
    /**
     * Constructor.
     *
     * @param  string $name Name of the widget to draw.
     * @param  array $attrs Attributes.
     *
     * @return void
     * @access public
     */
    function BIFE_Fallback($name, $attrs) // ~X2C
    {
        $this->__construct($name, $attrs);
    }
    // -X2C

    // +X2C Operation 63
    /**
     * Constructor.
     *
     * @param  string $name Name of the widget.
     * @param  array $attrs Attributes.
     *
     * @return void
     * @access public
     */
    function __construct($name, $attrs) // ~X2C
    {
        parent::__construct($attrs);
        $this->name = strtolower(strtr($name, ':', '_'));
    }
    // -X2C

} // -X2C Class :Fallback

?>