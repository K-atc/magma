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

export WORK="$TARGET/work"
rm -rf "$WORK"
mkdir -p "$WORK"
mkdir -p "$WORK/lib" "$WORK/include"

pushd "$TARGET/freetype2"
polytracker build ./autogen.sh
CFLAGS="-g" LDFLAGS="" LIBS="" PKG_CONFIG_PATH="$HOME/bin/vcpkg/packages/brotli_x64-linux/lib/pkgconfig" \
  polytracker build ./configure --prefix="$WORK" --disable-shared --without-bzip2 --without-brotli
polytracker build make -j$(nproc) clean
polytracker build make -j$(nproc)
polytracker build make install

mkdir -p "$WORK/poppler"
cd "$WORK/poppler"
rm -rf *

EXTRA=""
test -n "$AR" && EXTRA="$EXTRA -DCMAKE_AR=$AR"
test -n "$RANLIB" && EXTRA="$EXTRA -DCMAKE_RANLIB=$RANLIB"

### NOTE: LIBS に -lharfbuzz を入れるとリンクエラー
# LDFLAGS="${LDFLAGS} -lharfbuzz -L $HOME/bin/vcpkg/packages/brotli_x64-linux/lib -lbrotlidec-static" \
# -DCMAKE_TOOLCHAIN_FILE=$HOME/bin/vcpkg/scripts/buildsystems/vcpkg.cmake \
LD_LIBRARY_PATH="$WORK/lib" \
LDFLAGS="${LDFLAGS} -lharfbuzz" \
polytracker build cmake -B "$WORK/poppler" "$TARGET/repo" \
  $EXTRA \
  -DCMAKE_BUILD_TYPE=Release \
  -DBUILD_SHARED_LIBS=OFF \
  -DCMAKE_EXPORT_COMPILE_COMMANDS=ON \
  -DCMAKE_CXX_FLAGS="${CXXFLAGS}" \
  -DFONT_CONFIGURATION=generic \
  -DBUILD_GTK_TESTS=OFF \
  -DBUILD_QT5_TESTS=OFF \
  -DBUILD_CPP_TESTS=OFF \
  -DENABLE_LIBPNG=ON \
  -DENABLE_SPLASH=ON \
  -DENABLE_UTILS=ON \
  -DWITH_Cairo=ON \
  -DENABLE_CMS=none \
  -DENABLE_DCTDECODER=unmaintained \
  -DENABLE_LIBCURL=OFF \
	-DENABLE_LIBOPENJPEG=unmaintained \
  -DENABLE_GLIB=OFF \
  -DENABLE_GOBJECT_INTROSPECTION=OFF \
  -DENABLE_QT5=OFF \
  -DENABLE_LIBCURL=OFF \
	-DWITH_JPEG=OFF \
	-DWITH_TIFF=OFF \
	-DWITH_NSS3=OFF \
	-DWITH_Cairo=OFF \
  -DFREETYPE_INCLUDE_DIRS="$WORK/include/freetype2" \
  -DFREETYPE_LIBRARY="$WORK/lib/libfreetype.a" \
  -DICONV_LIBRARIES="/usr/lib/x86_64-linux-gnu/libc.so"
polytracker build cmake --build "$WORK/poppler" -j$(nproc) --target poppler poppler-cpp pdfimages pdftoppm pdfdetach pdfattach
EXTRA=""
polytracker instrument-targets --taint pdfdetach --ignore-lists freetype fontconfig harfbuzz libjpeg libpng libtiff libz openjpeg &
polytracker instrument-targets --taint pdfimages --ignore-lists freetype fontconfig harfbuzz libjpeg libpng libtiff libz openjpeg &
polytracker instrument-targets --taint pdftoppm  --ignore-lists freetype fontconfig harfbuzz libjpeg libpng libtiff libz openjpeg &

cp -v $WORK/poppler/utils/pdf* "$OUT/"
polytracker build $CXX $CXXFLAGS -std=c++11 -I"$WORK/poppler/cpp" -I"$TARGET/repo/cpp" \
    "$TARGET/src/pdf_fuzzer.cc" -o "$OUT/pdf_fuzzer" \
    "$WORK/poppler/cpp/libpoppler-cpp.a" "$WORK/poppler/libpoppler.a" \
    "$WORK/lib/libfreetype.a" $LDFLAGS $LIBS -lharfbuzz -ljpeg -lz \
    -lopenjp2 -lpng -ltiff -llcms2 -lm -lpthread -pthread

polytracker instrument-targets --taint pdf_fuzzer --ignore-lists freetype fontconfig harfbuzz libjpeg libpng libtiff libz openjpeg # => バイナリを実行するとセグフォ

wait
