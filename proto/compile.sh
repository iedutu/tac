#!/bin/sh

echo Executing ...
protoc ./types.proto --php_out=${HOME}/code/rohel/tac/lib/datatypes
echo PHP done.
