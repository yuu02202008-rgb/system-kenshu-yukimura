#!/usr/bin/env bash
set -euo pipefail
work=$(mktemp -d)
trap 'rm -rf "$work"' EXIT
cd "$work"
git init -q -b main
git config user.name Training
git config user.email training@example.invalid
printf 'base\n' > example.txt
git add example.txt; git commit -qm base
git switch -qc feature
printf 'feature\n' > example.txt
git commit -qam feature
git switch -q main
printf 'main\n' > example.txt
git commit -qam main
if git merge feature; then echo 'Expected conflict missing'; exit 1; fi
test -n "$(git ls-files -u)"
cat example.txt
printf 'main + feature\n' > example.txt
git add example.txt; git commit -qm 'Resolve both intentions'
test -z "$(git ls-files -u)"
git log --oneline --graph --all
echo 'Conflict reproduced and resolved'
