#!/bin/sh

if ! test -e "./.git/hooks/pre-commit"
then cp ./pre-commit ./.git/hooks/pre-commit
chmod +x ./.git/hooks/pre-commit
fi
