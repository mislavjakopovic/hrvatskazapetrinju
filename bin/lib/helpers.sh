#!/bin/bash -e

function run() {
  echo "[EXEC] $1" && eval $1
}

function info() {
  echo "[INFO] $1"
}
