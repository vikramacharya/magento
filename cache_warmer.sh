#!/bin/bash
 
URL='www.domain.nd'
SITEMAP='sitemap.xml'
wget --quiet http://$URL/$SITEMAP --no-cache --output-document - | egrep -o "http://$URL[^<]+" | while read line; do
    time curl -A 'Cache Warmer' -s -L $line > /dev/null 2>&1
    echo $line
done
