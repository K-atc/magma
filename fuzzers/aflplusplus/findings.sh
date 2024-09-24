#!/bin/bash
set -eu

##
# Pre-requirements:
# - env SHARED: path to directory shared with host (to store results)
##

CRASH_DIR="${SHARED}/*/findings/default/crashes"
ls $CRASH_DIR > /dev/stderr # DEBUG: 

# if [[ -z $(ls $CRASH_DIR) ]]; then
#     echo "[!] No crashes found: CRASH_DIR=${CRASH_DIR}" > /dev/stderr
#     exit 1
# fi

find $CRASH_DIR -type f -name 'id:*'
