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

// +X2C Class 25 :Parser
/**
 * This is the XML Parser.
 *
 * @package BIFE
 * @access public
 */
class BIFE_Parser {
    /**
     * Top level widget.
     *
     * @var    BIFE_Widget $root
     * @access protected
     */
    var $root = null;

    /**
     * XML parser resource.
     *
     * @var    resource $parser
     * @access protected
     */
    var $parser = null;

    /**
     * BIFE widgets stack.
     *
     * @var    array $stack
     * @access protected
     */
    var $stack = array();

    /**
     * Fallback class to use in case that a widget class is not found.
     *
     * @var    string $fallback
     * @access protected
     */
    var $fallback = '';

    /**
     * XML cache directory. Empty if no cahching must be done (for current dir use '.').
     *
     * @var    string $cache
     * @access protected
     */
    var $cache = '/tmp';

    /**
     * Files required by the parsed XML file.
     *
     * @var    array $requires
     * @access protected
     */
    var $requires = array();

    // ~X2C

    // +X2C Operation 30
    /**
     * Constructor.
     *
     * @param  string $fallback Fallback class name (none if empty).
     * @param  string $cache XML cache directory. Empty is no caching will be done.
     *
     * @return void
     * @access public
     */
    function BIFE_Parser($fallback = '', $cache = '/tmp') // ~X2C
    {
        $this->__construct($fallback, $cache);
    }
    // -X2C

    // +X2C Operation 31
    /**
     * Constructor.
     *
     * @param  string $fallback Fallback class name (none if empty).
     * @param  string $cache XML cache directory. Empty is no caching will be done.
     *
     * @return void
     * @access public
     */
    function __construct($fallback = '', $cache = '/tmp') // ~X2C
    {
        $this->parser   = xml_parser_create();
        $this->fallback = $fallback;
        $this->cache    = $cache;
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'startElement', 'endElement');
        xml_set_character_data_handler($this->parser, 'characterData');
    }
    // -X2C

    // +X2C Operation 32
    /**
     * Destructor.
     *
     * @return void
     * @access public
     */
    function __destruct() // ~X2C
    {
        xml_parser_free($this->parser);
    }
    // -X2C

    // +X2C Operation 33
    /**
     * XML parser start of element handler.
     *
     * @param  resource $parser XML parser resource.
     * @param  string $name XML tag name.
     * @param  array $attrs XML tag attributes.
     *
     * @return void
     * @access public
     */
    function startElement($parser, $name, $attrs) // ~X2C
    {
        $class = 'bife_' . strtolower(strtr($name, ':', '_'));
        if (!class_exists($class)) {
            $inc = 'BIFE/' .
                strtr(ucwords(strtr(strtolower($name), ':', ' ')), ' ', '/') .
                '.php';
            if (@include_once $inc) {
                $this->includes[] = $inc;
            }
        }
        if (class_exists($class)) {
            $obj =& new $class($attrs);
            // XXX - Does this check make sense?
            if (!is_a($obj, 'bife_widget')) {
                trigger_error("Class '$class' is not a BIFE_Widget.", E_USER_WARNING);
            }
            $this->stack[] =& $obj;
        } else {
            if ($this->fallback) {
                $class = $this->fallback;
                $obj =& new $class($name, $attrs);
                if (!is_a($obj, 'bife_fallback')) {
                    trigger_error("Class '$class' is not a BIFE_Fallback.", E_USER_WARNING);
                }
                $this->stack[] =& $obj;
            } else {
                trigger_error("Class not found '$class'.", E_USER_ERROR);
            }
        }
    }
    // -X2C

    // +X2C Operation 34
    /**
     * XML parser end of element handler.
     *
     * @param  resource $parser XML parser resource.
     * @param  string $name XML tag name.
     *
     * @return void
     * @access public
     */
    function endElement($parser, $name) // ~X2C
    {
        end($this->stack);
        $current =& $this->stack[key($this->stack)];
        array_pop($this->stack);
        end($this->stack);
        $parent =& $this->stack[key($this->stack)];
        if ($parent) {
            $parent->addContents($current);
        } else {
            $this->root =& $current;
        }
    }
    // -X2C

    // +X2C Operation 35
    /**
     * XML parser character data handler.
     *
     * @param  resource $parser XML parser resource.
     * @param  string $data XML character data.
     *
     * @return void
     * @access public
     */
    function characterData($parser, $data) // ~X2C
    {
        end($this->stack);
        $current =& $this->stack[key($this->stack)];
        $current->addContents($data);
    }
    // -X2C

    // +X2C Operation 36
    /**
     * Parse a string with XML data.
     *
     * @param  string $data XML string to parse.
     * @param  bool $final Indicates if is the last string to parse.
     *
     * @return void
     * @access public
     */
    function parse($data, $final = true) // ~X2C
    {
        if (!xml_parse($this->parser, $data, $final)) {
            trigger_error(
                sprintf('XML error: %s at line %d.',
                    xml_error_string(xml_get_error_code($this->parser)),
                    xml_get_current_line_number($this->parser)
                ),
                E_USER_WARNING
            );
        }
    }
    // -X2C

    // +X2C Operation 37
    /**
     * Parse a XML file with a complete and valid XML document.
     *
     * @param  string $filename Filename to parse.
     *
     * @return &BIFE_Widget
     * @access public
     */
    function &parseFile($filename) // ~X2C
    {
        if ($this->cache) {
            $cache = $this->cache . '/' . 'bife_parser_cache' . strtr(realpath($filename), '/', '_');
            if (@filemtime($cache) > @filemtime($filename)) {
                $file = file($cache);
                foreach(unserialize(trim(array_shift($file))) as $required) {
                    include_once $required;
                }
                return unserialize(join('', $file));
            }
        }
        if ($fp = @fopen($filename, 'r')) {
            while ($data = fread($fp, 4096)) {
                $this->parse($data, feof($fp));
            }
        } else {
            trigger_error("Could not open BIFE XML input file '$filename'.",
                E_USER_WARNING);
        }
        fclose($fp);
        if ($this->cache) {
            $fp = fopen($cache, 'w');
            fputs($fp, serialize($this->includes) . "\n");
            fputs($fp, serialize($this->root));
            fclose($fp);
        }
        return $this->root;
    }
    // -X2C

    // +X2C Operation 74
    /**
     * Parse a XML string with a complete and valid XML document.
     *
     * @param  string $data XML data to parse.
     *
     * @return &BIFE_Widget
     * @access public
     */
    function &parseString($data) // ~X2C
    {
        $this->parse($data, true);
        return $this->root;
    }
    // -X2C

} // -X2C Class :Parser

?>