#!/bin/bash

# Ova skripta podrazumjeva da je web server nginx i certbot vec configurirani.
# ToDo: dodati nginx i certbot automatizaciju 
#       u svrhu da se sa skriptom u potpunosti WebApp deploya na fresh VPS.
# CILJ: KOMPLET INFRASTRUKTURU HOSTAT NA 1 VPSU. IDEALNO NIX MASINI 
#        (nix ovdje prestavlja specificno nix distribuciju(funkcijski model deploymenta))
# PROBLEM: Single point of failure, configurirati fallback rjesenje

systemctl stop nginx
	
rm -rf /srv/www/ratsstuben-germering.de/* 

git clone https://github.com/ratsstuben-germering/ratsstuben-germering.github.io /srv/www/ratsstuben-germering.de/


# 	Ucini da se makereservationJSON.php izvrsi ispravno	
# 	Potrebno naknadno istraziti koje su minimalne permisije za izvrsavanje

chmod 664 /var/www/html/approved_reservations.json /var/www/html/rejected_reservations.json /var/www/html/new_reservations.json
chown www-data:www-data /var/www/html/approved_reservations.json /var/www/html/rejected_reservations.json /var/www/html/new_reservations.json

systemctl start nginx
echo "Deployed new ratsstuben-germering.de web files"  