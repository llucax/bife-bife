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
// | Created: Sun Jun 1 20:00:20 2003                                   |
// | Authors: Leandro Lucarella <luca@lugmen.org.ar>                    |
// +--------------------------------------------------------------------+
//
// $Id$
//

// +X2C includes
require_once 'BIFE/Container.php';
// ~X2C

// +X2C Class 110 :Link
/**
 * Link to another page.
 *
 * @package BIFE
 * @access public
 */
class BIFE_Link extends BIFE_Container {
    // ~X2C

    // +X2C Operation 111
    /**
     * Constructor.
     *
     * @param  array $attrs Attributes.
     *
     * @return void
     * @access public
     */
    function BIFE_Link($attrs) // ~X2C
    {
        $this->__construct($attrs);
    }
    // -X2C

    // +X2C Operation 112
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
        $link_attrs['URL']    = $this->getURL($attrs);
        $link_attrs['DESC']   = @$attrs['DESC'];
        $link_attrs['TARGET'] = @$attrs['TARGET'];
        parent::__construct($link_attrs);
    }
    // -X2C

    // +X2C Operation 142
    /**
     * Gets a URL string based on Link attributes.
     *
     * @param  array $attrs Link attributes.
     *
     * @return string
     * @access public
     */
    function getURL($attrs) // ~X2C
    {
        $url = @$attrs['URL'];
        unset($attrs['URL']);
        if (isset($attrs['BIFE'])) {
            $attrs['DATA-BIFE']  = $attrs['BIFE'];
            unset($attrs['BIFE']);
        }
        $query = array();
        foreach($attrs as $name => $value) {
            if (substr($name, 0, 5) === 'DATA-') {
                if ($name = substr($name, 5)) {
                    $query[] = urlencode($name) . '=' . urlencode($value);
                }
            }
        }
        if ($query) {
            $url .= '?' . join('&', $query);
        }
        return $url;
    }
    // -X2C

    // +X2C Operation 157
    /**
     * Renders the widget.
     *
     * @param  HTML_Template_HIT &$template Template to use to render the widget.
     *
     * @return string
     * @access public
     */
    function render(&$template) // ~X2C
    {
        $this->attrs['CONTENTS'] = $this->renderContents($template);
        return $template->parse('bife_link', $this->attrs, '', '');
    }
    // -X2C

} // -X2C Class :Link

?>