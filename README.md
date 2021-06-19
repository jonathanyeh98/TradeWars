Introduction:
Simple stock market fantasy league game website


File list:
	account.php: the account settings page
	create_league.php: the league creation page
	errors.php: container for errors that will be shown on screen
	homepage.php: homepage of project. intended starting point of project
	index.php: main menu after login
	league.php: the league selection page
	league_page.php: the individual league page
	login.php: the login page
	register.php: the registration page
	server.php: the backend code for database functions
	stock.php: the stock search/buy/sell page
	style.css: the CSS for the project
	users (2).sql: the database of the project. should be imported


How to run:
Since our project is meant to be a website, it should be accessible via url through the web browser and will not require install if currently hosted on a web server. 

However, our group does not have the resources to host the project indefinitely, so our project will require you to load a local version onto your computer in order to run it. To do this, it is best to use a php development suit like XAMPP or WAMP to do this, and to locate the php files in the htdocs folder of the install location, and to import the users.sql database locally.


Use instructions:
Our project is meant to be accessed via the homepage.php page as the starting point. From here the user can register or login. To register, simply fill out the form after clicking "Register." This will automatically log you in. To log in, please make sure you have already created an account and log in using your login credentials.

From the main menu, you can access 3 different types of functions:
	1. Account Settings
	2. View your leagues
	3. Logout

To change your account information, navigate the the "Account Settings" page and fill out the form with the desired new information in the relavent boxes and enter your current password.

To log out, simply press Logout.

To access or create leages, navigate to the "Leagues" page. To create a league, simply press "Create League" and enter the desired name of the league and the starting balance of each player. This will make you the manager of the league that you created, which allows you to add players to your league. 

Once you created a league, you may access your league, and you will see the current leaderboard upon loading. If you are the manager, you will also see a box where you can add members. To do so, simply type the username of the player you wish to add and press enter.

Your portfolio is tied to the leagues you are in, which means that you have a unique portfolio for every league you are part of. To buy and sell stocks, you will need to navigate to the league you wish to update your portfolio in and press search and buy stocks. From there, you can simply enter the ticker symbol of the company you wish to invest in and press search. Then you will see the current price of the stock and you will be able to type in the desired number of shared you wish to trade. 
