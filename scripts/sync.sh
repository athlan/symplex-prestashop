#!/bin/bash

usage="$(basename "$0") -f file -o reports_output -- Synchronizes prestashop with symplex file -f
Generates execution reports to -o directory

where:
    -f  symplex input file
    -o  reports output directory
"

file=""
reports_dir=""

while getopts ':hf:o:' option; do
  case "$option" in
    h) echo "$usage"
       exit
       ;;
    f) file=$OPTARG
       ;;
    o) reports_dir=$OPTARG
       ;;
    :) printf "missing argument for -%s\n" "$OPTARG" >&2
       echo "$usage" >&2
       exit 1
       ;;
   \?) printf "illegal option: -%s\n" "$OPTARG" >&2
       echo "$usage" >&2
       exit 1
       ;;
  esac
done
shift $((OPTIND - 1))

[[ -z "$file" ]] && echo "Mising -f option" && echo -e "\n$usage" && exit 1
[[ -z "$reports_dir" ]] && echo "Mising -o option" && echo -e "\n$usage" && exit 1
[[ ! -f "$file" ]] && echo "File $file does not exists" && exit 1

basedir=$(dirname $(readlink -f $0))/..

# Creates reports dir if needed
mkdir -p $reports_dir

# Wait for file readiness, file cannot be modified since 10 sec
echo "Waiting for file $file readiness"
$basedir/bin/fmodwait -f $file -t 10

# Move file to process
file_processing="$file.processing"
mv $file $file_processing

# Sync
report_file="$reports_dir/sync-log.txt"
echo "Sync report - $(date +"%Y-%m-%d %T")" > $report_file
$basedir/bin/sync $file_processing >> $report_file

# Generate mismapped report
report_file="$reports_dir/mismapped-log.txt"
echo "Mismapped report - $(date +"%Y-%m-%d %T")" > $report_file
$basedir/bin/list-shop-mismapped $file_processing >> $report_file

# Complete
rm $file_processing

echo "Done"
