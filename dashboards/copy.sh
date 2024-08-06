#!/bin/bash

file=""
max=""
force="false"

OPTSTRING=":f:n:F"

while getopts ${OPTSTRING} opt; do

	case ${opt} in

	f)
		file="${OPTARG}"
		# echo "Set file to ${OPTARG}"
		;;
	n)
		max="${OPTARG}"
		# echo "Set max to ${OPTARG}"
		;;
	F)	
		force="true"
		;;
	:)
		echo "Error: ${OPTARG} requires an argument."
		exit 1
		;;
	?)
		echo "Error: Unrecognized argument: ${OPTARG}"
		exit 1
		;;
	esac
done

number='^[0-9]+$'

if [[ -z "$file" ]]; then
	echo "Error: No file specified."
	exit 1
elif [[ -z "$max" ]]; then
	echo "Error: No number specified."
	exit 1
elif [[ ! "$max" =~ $number ]]; then
	echo "$max is not a valid number."
	exit 1
fi


if [[ "$force" != "true" ]]; then

	read -p "You're about to copy $file about $max times. Proceed? (y/n)" choice
	if [[ "$choice" != "y" ]]; then
		echo "Aborted."
		exit 1
	fi
fi

for (( i=0; i<=$max; i++ ))
do
	cp "$file" "${file}_${i}.json"
done

echo "Copied '$file' about $max times."

exit 0
