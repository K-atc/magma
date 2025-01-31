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
# autoreconf -f -i
# ./configure --with-libpng-prefix=MAGMA_ --disable-shared
# make -j$(nproc) clean
# make -j$(nproc) libpng16.la
LDFLAGS=${LDFLAGS} \
cmake -B build . -DBUILD_SHARED_LIBS=OFF -DCMAKE_EXPORT_COMPILE_COMMANDS=ON \
    -DCMAKE_C_FLAGS="$CFLAGS"
# cmake --build build --target clean
cmake --build build --target png_static

cp build/libpng16.a "$OUT/"

# build libpng_read_fuzzer.
$CXX $CXXFLAGS -std=c++11 -I. \
     contrib/oss-fuzz/libpng_read_fuzzer.cc \
     -o $OUT/libpng_read_fuzzer \
     $LDFLAGS build/libpng16.a $LIBS -lz