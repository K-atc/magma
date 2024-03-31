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

WORK="$TARGET/work"
rm -rf "$WORK"
mkdir -p "$WORK"
mkdir -p "$WORK/lib" "$WORK/include"

cd "$TARGET/repo"
polytracker build cmake -B build . -DCMAKE_INSTALL_PREFIX=$WORK -DBUILD_SHARED_LIBS=OFF -DBUILD_STATIC_LIBS=ON -DCMAKE_EXPORT_COMPILE_COMMANDS=ON \
    -DCMAKE_CXX_FLAGS="$CXXFLAGS" -DCMAKE_C_FLAGS="$CFLAGS"
polytracker build cmake --build build
# cmake --build build --target install .

polytracker instrument-targets --taint tiffcp --ignore-lists libz libjpeg jbig libdeflate

cp build/tools/tiffcp "$OUT/"
polytracker build $CXX $CXXFLAGS -std=c++11 -I$WORK/include \
    -I$TARGET/repo/libtiff -I$TARGET/repo/build/libtiff \
    contrib/oss-fuzz/tiff_read_rgba_fuzzer.cc -o $OUT/tiff_read_rgba_fuzzer \
    build/libtiff/libtiffxx.a build/libtiff/libtiff.a \
    -lz -ljpeg -ljbig -ldeflate -Wl,-Bstatic -llzma -Wl,-Bdynamic \
    $LDFLAGS $LIBS

polytracker instrument-targets --taint tiff_read_rgba_fuzzer --ignore-lists libz libjpeg jbig libdeflate
