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
require_once 'BIFE/Fallback.php';
// ~X2C

// +X2C Class 7 :Translate
/**
 * This is a generic and simple (but very usefull) BIFE_Fallback implementation. Translate widgets using a template with it's name, prepended with 'bife_'. If not template is found, it copy the XML to the output.
 *
 * @package BIFE
 * @access public
 */
class BIFE_Translate extends BIFE_Fallback {
    // ~X2C

    // +X2C Operation 12
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
        $name = "bife_{$this->name}";
        if ($template->exists($name, '')) {
            $this->attrs['CONTENTS'] = $this->renderContents($template);
            $out = $template->parse($name, $this->attrs, '', '');
        } else {
            $name = $this->name;
            $out = "<$name";
            foreach ($this->attrs as $attr => $val) {
                $out .= sprintf(' %s="%s"', $attr, $val);
            }
            $contents = $this->renderContents($template);
            if ($contents !== '') {
                $out .= ">$contents</$name>";
            } else {
                $out .= "/>";
            }
        }
        return $out;
    }
    // -X2C

} // -X2C Class :Translate

?>