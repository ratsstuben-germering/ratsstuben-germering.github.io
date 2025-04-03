#!/bin/bash

# Ova skripta podrazumjeva da je web server nginx i certbot vec configurirani.
# ToDo: dodati nginx i certbot automatizaciju 
#       u svrhu da se sa skriptom u potpunosti WebApp deploya na fresh VPS.
# CILJ: KOMPLET INFRASTRUKTURU HOSTAT NA 1 VPSU. IDEALNO NIX MASINI 
#        (nix ovdje prestavlja specificno nix distribuciju(funkcijski model deploymenta))
# PROBLEM: Single point of failure, configurirati fallback rjesenje

systemctl stop nginx
	
rm -rf /srv/www/ratsstuben-germering.de 
mkdir /srv/www/ratsstuben-germering.de

git clone https://github.com/ratsstuben-germering/ratsstuben-germering.github.io /srv/www/ratsstuben-germering.de/

cp /srv/www/ratsstuben-germering.de/.deployment_scripts/deployWebApp.sh /root/Scripts/deployWebApp.sh

chown -R www-data:www-data /srv/www/ratsstuben-germering.de/

chown www-data:www-data /root/GojinUnuk/send_msg_argv.py

systemctl start nginx

echo "Deployed new ratsstuben-germering.de web files"  