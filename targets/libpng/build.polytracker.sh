#!/bin/bash
set -eux

##
# Pre-requirements:
# - env TARGET: path to target work dir
# - env OUT: path to directory where artifacts are stored
# - env CC, CXX, FLAGS, LIBS, etc...
##

if [ ! -d "$TARGET/repo" ]; then
    echo "fetch.sh must be executed first."
    exit 1
fi

# build the libpng library
cd "$TARGET/repo"
LDFLAGS=${LDFLAGS} \
polytracker build cmake -B build . -DBUILD_SHARED_LIBS=OFF -DCMAKE_EXPORT_COMPILE_COMMANDS=ON \
    -DCMAKE_C_FLAGS="$CFLAGS"
polytracker build cmake --build build --target png_static

cp build/libpng16.a "$OUT/"

# build libpng_read_fuzzer.
polytracker build $CXX $CXXFLAGS -I. \
     contrib/oss-fuzz/libpng_read_fuzzer.cc \
     -I $TARGET/repo/build \
     -o $OUT/libpng_read_fuzzer \
     $LDFLAGS build/libpng16.a $LIBS -lz

polytracker instrument-targets --taint libpng_read_fuzzer --ignore-lists libz