#!/bin/bash
set -eux
set -o pipefail

MAGMA=$(cd $(dirname ${BASH_SOURCE:-$0}); pwd)
ROOT=${MAGMA}/..
TARGETS=${ROOT}/targets
FUZZERS=${ROOT}/fuzzers
VANILLA_FUZZER=${FUZZERS}/vanilla

### Build environment variables
export CC=clang
export CXX=clang++
export LIBS="-L${VANILLA_FUZZER} -l:afl_driver.o -lstdc++"

### Build vanilla fuzzer
echo "[*] Build vanilla fuzzer"
FUZZER=${VANILLA_FUZZER} OUT=${VANILLA_FUZZER} ${VANILLA_FUZZER}/build.sh

### Build targets
for target_name in $(echo libpng libxml2 sqlite3 openssl php libtiff poppler); do
    target="${TARGETS}/${target_name}"
    if (ls ${target}/${target_name}_*fuzzer); then
        echo "[*] Target ${target_name} exists. skip"
    else
        echo "[*] Building taget ${target}"
        if [ ! -e ${target}/repo/.git ]; then
            TARGET=${target} OUT=${target} ${target}/fetch.sh
        fi
        git -C ${target}/repo reset --hard
        TARGET=${target} ${MAGMA}/apply_patches.sh
        TARGET=${target} OUT=${target} ${target}/build.sh
    fi
done