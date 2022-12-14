## Technical Assessment for Figured

## How to setup

### Laravel
Clone this repository and run the following command below:
```bash
cd ./figured-assessment

# Install Laravel dependencies and packages
composer install

# Copy ENV example file to run your own local setup
cp .env.example .env

# Generate your local encryption key
php artisan key:generate

# Make sure to create your local database `figured` before running the migration command.
# It will seed the database on some inventories
php artisan migrate:fresh --seed

# You will need to open two terminal to serve both frontend and backend
# Usually you'll be serve on http://localhost:8000
php artisan serve
```

### Frontend
The frontend is running on Nuxt 3, TailwindCSS, and Axios. Run the following command below on a separate terminal window to setup.
```bash
cd ./frontend

# Nuxt 3 should be run on Node v16
nvm use 16

# You can also use `npm` if you prefer
yarn install

# You'll need to copy the ENV to point the API URL to the
# port you get after running `php artisan serve`
cp .env.example .env

# Usually you'll be serve on http://localhost:3000
yarn dev
```

## Show list of inventory
I have prepared a command to display the inventory list in the console. You can run

```bash
php artisan inventory:list
```
In action 🎬

![lYNnE2OHuS](https://user-images.githubusercontent.com/10015302/207359558-7d3d7cab-5091-4102-bfdf-ed5b54d579cc.gif)


## Add to inventory
As an admin, you can run this command to add an entry to the inventory.

```bash
# php artisan inventory:add {quantity} {unit_price?} {--type=purchase|application}

# Default type is "purchased", this will add 10 items to the inventory and $5 per unit
php artisan inventory:add 10 5

# Add 10 items to the inventory with the type application
php artisan inventory:add 10 --type=application
```

In action 🎬

![ECiThorHyE](https://user-images.githubusercontent.com/10015302/207360212-f0c7a210-0f7e-4479-93a2-0fba6cabbcba.gif)


## UI/UX
Visit the http://localhost:3000 on your browser. If you are running on a different port, make sure to update your Laravel ENV `FRONTEND_URL` to point on the correct URL to CORS issues. Example shown below:

```env
FRONTEND_URL=http://localhost:3001
```

In action 🎬

![7SzS1ioIgS](https://user-images.githubusercontent.com/10015302/207361908-0928e52f-1394-4f05-b9a3-2974838508dc.gif)

## Testing
In the terminal, you can run `php artisan test`.

In action 🎬

![xwMbpq5Tcc](https://user-images.githubusercontent.com/10015302/207363827-cc27e3f1-091b-4c87-90a9-f2a22132e59d.gif)

## Credits
- [Harlequin Doyon](https://github.com/harlekoy)
