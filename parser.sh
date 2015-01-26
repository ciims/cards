#!/bin/bash
# This is a bash wrapper for parser.php
#
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
$(which cd) $DIR && $(which git) pull
$(which cd) $DIR && $(which php) parser.php
