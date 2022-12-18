chgrp www-data storage themes -R chmod g+rwx storage themes -R chown www-data:www-data themes storage -R

# start docker for prod - use this from html folder
docker-compose -f docker-compose.prod.yml run --rm composer install

# update composer - use this from html folder
docker-compose -f docker-compose.prod.yml run --rm composer update

# migrate
docker-compose -f docker-compose.prod.yml run --rm artisan october:migrate
# ignore files git rm --cached file



# use sass compiler npx ##install

use terminal, and go to themes/fundatie dir
npm install
npx mix - compile all see https://laravel-mix.com/docs/6.0/installation
npx mix watch - localhost:3000 will reaload each time a file is changed
#https://octobercms.com/forum/post/how-to-add-more-fonts-to-froala-richeditor