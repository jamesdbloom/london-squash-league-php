#!/bin/bash
#
# copy beta to www
#

echo "backing up beta files"
mv ~/domains/beta.london-squash-league.com/html/config/config.php ~/domains/beta.london-squash-league.com/html/config/config.beta
mv ~/domains/beta.london-squash-league.com/html/.htaccess ~/domains/beta.london-squash-league.com/html/.htaccess.beta

echo "renaming www files to main files"
mv ~/domains/beta.london-squash-league.com/html/config/config.www ~/domains/beta.london-squash-league.com/html/config/config.php
mv ~/domains/beta.london-squash-league.com/html/.htaccess.www ~/domains/beta.london-squash-league.com/html/.htaccess

echo "coping all files"
cp -R ~/domains/beta.london-squash-league.com/* ~/domains/www.london-squash-league.com

echo "backing up www files"
mv ~/domains/beta.london-squash-league.com/html/config/config.php ~/domains/beta.london-squash-league.com/html/config/config.www
mv ~/domains/beta.london-squash-league.com/html/.htaccess ~/domains/beta.london-squash-league.com/html/.htaccess.www

echo "renaming beta files to main files"
mv ~/domains/beta.london-squash-league.com/html/config/config.beta ~/domains/beta.london-squash-league.com/html/config/config.php
mv ~/domains/beta.london-squash-league.com/html/.htaccess.beta ~/domains/beta.london-squash-league.com/html/.htaccess