<h1 align="center">Laravel Route-based Access</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.0-orange" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.1-blue" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

<p align="center">A Laravel project demonstrating route-based access control for role-based permissions.</p>

<h2>Installation</h2>

<p>To get started with the project, follow these steps:</p>

<ol>
  <li>Clone the repository to your local machine:</li>
</ol>

<pre><code>git clone https://github.com/Helalbrur/laravel-route-based-access.git
</code></pre>

<ol start="2">
  <li>Navigate to the project directory:</li>
</ol>

<pre><code>cd laravel-route-based-access
</code></pre>

<ol start="3">
  <li>Install PHP dependencies:</li>
</ol>

<pre><code>composer update
</code></pre>

<ol start="4">
  <li>Install JavaScript dependencies:</li>
</ol>

<pre><code>npm install
</code></pre>

<ol start="5">
  <li>Create a copy of the <code>.env-example</code> file and rename it to <code>.env</code>:</li>
</ol>

<pre><code>cp .env-example .env
</code></pre>

<ol start="6">
  <li>Generate an application key:</li>
</ol>

<pre><code>php artisan key:generate
</code></pre>

<ol start="7">
  <li>Run the database migrations:</li>
</ol>

<pre><code>php artisan migrate
</code></pre>

<ol start="8">
  <li>Seed the database (optional):</li>
</ol>

<pre><code>php artisan db:seed
</code></pre>

<h2>Usage</h2>

<p>To run the project, you can use Laravel's built-in development server:</p>

<pre><code>php artisan serve
</code></pre>

<pre><code>npm run dev
</code></pre>

<p>This will start the development server, and you can access the application by visiting <a href="http://localhost:8000">http://localhost:8000</a> in your web browser.</p>

<h2>Docker</h2>

<p>Alternatively, you can also run the project using Docker. Here are the steps:</p>

<ol>
  <li>Build the Docker image:</li>
</ol>

<pre><code>sudo docker build -t laravel-app .
</code></pre>

<ol start="2">
  <li>Run a Docker container:</li>
</ol>

<pre><code>sudo docker run -p 8080:80 laravel-app
</code></pre>

<p>The application will be accessible at <a href="http://localhost:8080">http://localhost:8080</a> in your web browser.</p>

<p>Please note that you need to have Docker installed on your machine to use the Docker commands.</p>

<h2>Requirements</h2>

<p>The project has the following requirements:</p>

<ul>
  <li>PHP 8.1 or higher</li>
  <li>Guzzle HTTP library version 7.2 or higher</li>
  <li>Laravel Framework version 10.0 or higher</li>
  <li>Laravel Tinker version 2.8 or higher</li>
  <li>Toastr library version 2.3 or higher</li>
</ul>

<p>Make sure your environment meets these requirements before running the project.</p>

<h2>Contributing</h2>

<p>Contributions are welcome! If you find any issues or want to add new features, feel free to open a pull request.</p>

<h2>License</h2>

<p>This project is open-source and available under the <a href="LICENSE">MIT License</a>.</p>
