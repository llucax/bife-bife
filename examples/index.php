<?
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

$tmp = ini_get('include_path');
ini_set('include_path', "..:$tmp");
unset($tmp);
umask('002');

require_once 'HTML/Template/HIT.php';
require_once 'BIFE/Parser.php';
require_once 'BIFE/Translate.php';

$file = isset($_REQUEST['BIFE']) ? $_REQUEST['BIFE'] : 'index.xbf';
#$file = isset($_SERVER['PATH_INFO']) ? ".{$_SERVER['PATH_INFO']}" : 'index.xbf';

$template =& new HTML_Template_HIT('templates');

$parser =& new BIFE_Parser('BIFE_Translate');
$page =& $parser->parseFile($file);
$parser->__destruct();
echo $page->render($template);

?>
