#!/bin/bash
set -eux
set -o pipefail

MAGMA=$(cd $(dirname ${BASH_SOURCE:-$0}); pwd)
ROOT=${MAGMA}/..
TARGETS=${ROOT}/targets

### Build targets
for target_name in $(ls -1 ${TARGETS}); do
    target="${TARGETS}/${target_name}"
    echo "\n[*] Preinstall for target ${target}"
    sudo ${target}/preinstall.sh
done