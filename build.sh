#!/usr/bin/env bash

rm -f ./build/oc-redirectconditionsheader-plugin.zip
zip -r ./build/oc-redirectconditionsheader-plugin.zip . -x@build-exclude.txt
