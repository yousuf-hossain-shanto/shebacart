# Shebacart
### Simple cart package for Laravel artist.
#### Overview
Using **Shebacart** You can easily implement cart and cart type system (Like Wishlist, Favorite) in your project. Installation and usages is very simple. You can immediately start by making a class that will extend **CartInstance** class. By using this package you can implement multiple cart into a single project. It can store cart data into the session as well as the database. You can also transfer data from session to the database. It can also work with multiple product models like (App\Product, App\Service)
**Multiple product model**, **Multiple Cart**, **Guest Cart**, **User Cart**, **Multiple User Type** made this package a must-try item

* [Installation](#installation)
* [Usage](#usage)
* [Collections](#collections)
* [Instances](#instances)
* [Models](#models)
* [Database](#database)
* [Transfer](#transfer)
* [Example](#example)

#### Installation
Install the package through [Composer](http://getcomposer.org/).

Run the Composer command from the Terminal:
```
composer require yhshanto/shebacart
``` 
If you still be on version 5.4 of Laravel, You have to add the service provider of the package. To do this open your `config/app.php` file.
Add this to the `providers` array:

	YHShanto\ShebaCart\ShebaCartServiceProvider::class
	

	
