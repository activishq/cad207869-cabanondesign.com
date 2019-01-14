#!/bin/bash
exec 3>&1 4>&2
trap 'exec 2>&4 1>&3' 0 1 2 3
exec 1>log.out 2>&1

#|--------------------------------------------------------------------------
# Deploy Script
# For Activis Technologies Inc.
#
# Written by Simon Bouchard <sbouchard@activis.ca>
# Created: August 17 2018
#
# You may use, modify, and redistribute this script freely
#|

#|--------------------------------------------------------------------------
#| Let's do this
#|--------------------------------------------------------------------------

cd ../
git reset --hard HEAD && git pull origin master
