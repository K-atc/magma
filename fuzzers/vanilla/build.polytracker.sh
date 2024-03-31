#!/bin/bash
set -eux

##
# Pre-requirements:
# - env FUZZER: path to fuzzer work dir
##

# compile afl_driver.cpp
polytracker build ${CXX} $CXXFLAGS -c "$FUZZER/src/afl_driver.cpp" -fPIC \
    -o "$OUT/afl_driver.o"
