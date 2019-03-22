#!/usr/bin/env bash

rm -f ./build/oc-redirectconidtionsheader-plugin.zip
zip -r ./build/oc-redirectconidtionsheader-plugin.zip . -x@build-exclude.txt
