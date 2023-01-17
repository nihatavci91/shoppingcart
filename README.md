1. <p>Clone the project: </p><br />
<p>git clone https://github.com/nihatavci91/shoppingcart.git</p>

<hr />

2. <p>Starting the docker containers:</p> 
   <p>a) docker-compose -f docker-compose.yml build</p><br />
   <p>b) docker-compose -f docker-compose.yml up -d</p><br />

<hr />

3. <p>Copy .env.example file and rename to .env </p><br />

<hr />

4. <p>Install packages: composer install</p><br />

<hr />

5. <p>Generate the application key:</p><br />
   <p>php artisan key:generate</p><br />

<hr />

6. <p>docker exec -ti laravel-app bash</p><br /> 

<hr />

7. <p>php artisan migrate --seed</p><br />

<hr />

Usage: <a href="http://localhost/">localhost</a>

