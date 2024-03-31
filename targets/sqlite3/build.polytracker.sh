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

# build the sqlite3 library
cd "$TARGET/repo"

export WORK="$TARGET/work"
rm -rf "$WORK"
mkdir -p "$WORK"
cd "$WORK"

export CFLAGS="$CFLAGS -DSQLITE_MAX_LENGTH=128000000 \
               -DSQLITE_MAX_SQL_LENGTH=128000000 \
               -DSQLITE_MAX_MEMORY=25000000 \
               -DSQLITE_PRINTF_PRECISION_LIMIT=1048576 \
               -DSQLITE_DEBUG=1 \
               -DSQLITE_MAX_PAGE_COUNT=16384"

polytracker build "$TARGET/repo"/configure --disable-shared --enable-rtree
polytracker build make clean
polytracker build make -j$(nproc)
polytracker build make sqlite3.c

polytracker build $CC $CFLAGS -I. \
    "$TARGET/repo/test/ossfuzz.c" "./sqlite3.o" \
    -o "$OUT/sqlite3_fuzz" \
    $LDFLAGS $LIBS -pthread -ldl -lm

polytracker instrument-targets --taint sqlite3_fuzz --ignore-lists libpthread libdl libm