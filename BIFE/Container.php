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

// +X2C includes
require_once 'BIFE/Widget.php';
// ~X2C

// +X2C Class 5 :Container
/**
 * Base container widget class.
 *
 * @package BIFE
 * @access public
 * @abstract
 */
class BIFE_Container extends BIFE_Widget {
    /**
     * Widget contents.
     *
     * @var    array $contents
     * @access public
     */
    var $contents = array();

    // ~X2C

    // +X2C Operation 6
    /**
     * Adds contents to the container.
     *
     * @param  mixed &$contents Contents to add to the container.
     *
     * @return void
     * @access public
     */
    function addContents(&$contents) // ~X2C
    {
        if (is_object($contents)) {
            $this->contents[] =& $contents;
        } else {
            $this->contents[] = $contents;
        }
    }
    // -X2C

    // +X2C Operation 59
    /**
     * Renders the widget using a template returning a string with the results.
     *
     * @param  HTML_Template_HIT &$template Template object to render the widget.
     *
     * @return string
     * @access public
     */
    function renderContents(&$template) // ~X2C
    {
        $c = count($this->contents);
        $o = '';
        for ($i = 0; $i < $c; $i++) {
            if (is_object($this->contents[$i])) {
                $o .= $this->contents[$i]->render($template);
            } else {
                $o .= $this->contents[$i];
            }
        }
        return $o;
    }
    // -X2C


} // -X2C Class :Container

?>