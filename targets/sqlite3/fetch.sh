#!/bin/bash
set -e

##
# Pre-requirements:
# - env TARGET: path to target work dir
##

if [ ! -e "$OUT/sqlite.tar.gz" ]; then
curl "https://www.sqlite.org/src/tarball/sqlite.tar.gz?r=16e281ed6219cc22" \
  -o "$OUT/sqlite.tar.gz"
fi
mkdir -p "$TARGET/repo" && \
tar -C "$TARGET/repo" --strip-components=1 -xzf "$OUT/sqlite.tar.gz"