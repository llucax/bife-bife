# vim: set noexpandtab tabstop=4 softtabstop=4 shiftwidth=4:
# +--------------------------------------------------------------------+
# |                       BIFE - Buil It FastEr                        |
# +--------------------------------------------------------------------+
# | This file is part of BIFE.                                         |
# |                                                                    |
# | BIFE is free software; you can redistribute it and/or modify it    |
# | under the terms of the GNU General Public License as published by  |
# | the Free Software Foundation; either version 2 of the License, or  |
# | (at your option) any later version.                                |
# |                                                                    |
# | BIFE is distributed in the hope that it will be useful, but        |
# | WITHOUT ANY WARRANTY; without even the implied warranty of         |
# | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU   |
# | General Public License for more details.                           |
# |                                                                    |
# | You should have received a copy of the GNU General Public License  |
# | along with Hooks; if not, write to the Free Software Foundation,   |
# | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA      |
# +--------------------------------------------------------------------+
# | Created: Mon May 19 00:16:56 ART 2003                              |
# | Authors: Leandro Lucarella <luca@lugmen.org.ar>                    |
# +--------------------------------------------------------------------+
#
# $Id$
#

VERSION=0.11
MODULE_FILE=BIFE.php
MODULE_NAME=Core
PHP_FILES=$(filter-out $(MODULE_FILE),$(subst ./,,$(shell find src -name '*.php')))
EXAMPLE_FILES=$(subst ./,,$(shell find examples -regex '.*\.svn.*'))
DOC_FILES=README ROADMAP
X2C_TEMPLATE=xmi2code.tpl.php

package: package.xml $(PHP_FILES) $(EXAMPLE_FILES) $(DOC_FILES)
	pear package

code: bife.xmi xmi2code.config
	@xmi2code

code-clean:
	@find src -name '*.bak' | xargs rm -vf

$(MODULE_FILE): code $(PHP_FILES) $(X2C_TEMPLATE)
	@( \
		( \
			cat $(X2C_TEMPLATE) | \
			grep -v '@@date' | \
			grep -v '$$Id' | \
			egrep -v '^//$$' \
		); \
		echo '//'; \
		echo -n '// BIFE $(MODULE_NAME) (version $(VERSION)) - '; \
		date; \
		echo '//'; \
		( \
			cat $(PHP_FILES) | \
			grep -v require_once | \
			grep -v '?>' | \
			grep -v '<?php' | \
			egrep -v '^\s*//' \
		); \
		echo -n '?>' \
	) > $(MODULE_FILE)
