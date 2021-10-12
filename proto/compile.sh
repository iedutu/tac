#!/bin/sh

echo Executing ...
protoc ./types.proto --php_out=../lib/datatypes
echo PHP done.
