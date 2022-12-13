## Technical Assessment for Figured

## How to setup

### Laravel
Clone this repository and run the following command below
```bash
composer install

# It will seed the database on some inventories
php artisan migrate:fresh --seed

# You will need to open two terminal to serve both frontend and backend
# Usually you'll be serve on http://localhost:8000
php artisan serve
```

### Frontend
The frontend is running on Nuxt 3, TailwindCSS, and Axios. Run the following script below to setup.
```bash
# Nuxt 3 should be run on Node v16
nvm use 16

# You can also use `npm` if you prefer
yarn install

# You'll need to copy the ENV to point the API URL to the
# port you get after running `php artisan serve`
cp .env.testing.example .env

# Usually you'll be serve on http://localhost:3000
yarn dev
```

## Show list of inventory
I have prepared a command to display the inventory list in the console. You can run

```bash
php artisan inventory:list
```

## Add to inventory
As an admin, you can run this command to add an entry to the inventory.

```bash
# php artisan inventory:add {quantity} {unit_price?} {--type=purchase|application}

# Default type is "purchased", this will add 10 items to the inventory and $5 per unit
php artisan inventory:add 10 5

# Add 10 items to the inventory with the type application
php artisan inventory:add 10 --type=application
```

## UI/UX
Visit the http://localhost:3000 on your browser.

## Credits
- [Harlequin Doyon](https://github.com/harlekoy)
