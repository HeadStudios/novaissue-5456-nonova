#!/bin/bash
for file in $(git diff --name-only --diff-filter=U); do
  git checkout --theirs "$file"
done