# Web Applications Assignment
Written by Will Corkill.
 
- Furness College:
	- Student ID: 40019692
	- Email: 40019692@student.furness.ac.uk
- UCLan
	- Student ID: G20973951
	- Email: WCorkill@uclan.ac.uk
 ## Introduction
 This repository will be used to store and update versions of the assignment product. This will help with organising the files for the assignment, and will be used for evidence of version control. The requirements for this assignment will be listed below, however, some important notes will first be detailed below:
 
- References for the website will be listed at the end of this file.
- Part of the requirements for a 2:1 grade in this assignment is the use of a back-end framework. To make the process easier from the start, I have decided to begin the assignment with the base of [CodeIgniter](http://codeigniter.com/), a PHP framework which provides a range of tools, such as security and database features.
- The MySQL database as provided in XAMPP will be used for this assignment. As this is a local solution for a database, the SQL script will be provided in the root directory to replicate the data used in the database.
 
More important notes will be added as and when necessary.
 
## Base for the site
This web application will be based on my current workplace [Furness Golf Club](http://furnessgolfclub.co.uk/). Having worked at this establishment for a year and a half, many members have stated that the website feels dated and could do with an upgrade.
 
As this establishment has both a booking system and a bar, it provides two opportunities for dynamic pages and *full* C.R.U.D. functionality.
 
- The bar will provide functionality to check a user's date of birth to check which drinks they are eligible to order, having different types of membership will also provide an opportunity for tiered discounts and vouchers.
- The booking system will allow users to book times to play a round of golf. Different account tiers can go through different steps to book, for example, users on a full membership can book without payment, however, base accounts (or visitors) could be taken through a payment page
 
These are, of course, just ideas, and the full explanation of the website and its pages will be detailed below and evaluated in Assignment 2.
 
## Assignment Requirements
| Requirement | Pass | 3rd | 2:2 | 2:1 | 1st | High 1st | Completed |
|      --     |  --  | --  |  -- | --  |  -- |    --    |     --    |
| Build an application which demonstrates FULL C.R.U.D. functionality built around your chosen scenario. (Create, Read, Update, and Delete) of records from at least ONE database table. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| A user registration system which adds new users to a database table. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| Feature a login system verifying a user against data in a database table. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| Maintain a state using sessions or alternative means. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| Do not permit non logged-in users from accessing areas where C.R.U.D. operations (other than user registration) take place. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| User's passwords MUST NOT be stored in plain text in the database and must be hashed using a secure algorithm (BCRYPT etc.) and NOT merely MD5 or SHA1. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| All endpoints accessible within the application should render well-structured, valid HTML documents. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| No stubs (incomplete pages) or invalid mark-up. | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| An attempt has been made to style the user interface using CSS, either handwritten or using a framework. ***There may be some minor flaws and it may not work well on mobile.*** |  | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| Some appropriate validation of user input on the front and/or backend to improve security and usability of the application. ***Examples such as password length validator, data types, email format etc.*** |  | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| The application should contain no dead-ends, or security holes. ***An example such as a user logs in, and is sent to an empty page and must use the back button etc.*** |  | ✓ | ✓ | ✓ | ✓ | ✓ |
| Some front-end features have been implemented in JavaScript/jQuery which add to the usability and or security of the application in some way. ***For example, include real time edits to the on-screen content in response to user input e.g. adding and removing elements from a list.*** |  | ✓ | ✓ | ✓ | ✓ | ✓ | ✓
| A backend web framework **may** have been used as opposed to standard PHP, but otherwise good code quality is evident throughout with no deprecated methods or procedural PHP methods. |  |  | ✓ | ✓ | ✓ | ✓ | ✓
| Multi-level user access has been achieved allowing an admin user to access pages other cannot. |  |  | ✓ | ✓ | ✓ | ✓ | ✓
| An attempt has been made to secure the application against common threats such as SQL injection or cross-site request forgery. |  |  | ✓ | ✓ | ✓ | ✓ | ✓ 
| External APIs such as Google Maps have been incorporated into the application e.g., to show directions to a location. |  |  | ✓ | ✓ | ✓ | ✓ | ✓ 
| A back-end web framework must have been used as opposed to straight unstructured PHP. |  |  |  | ✓ | ✓ | ✓ | ✓
| Multi-level user access will be achieved allowing at a minimum for a "normal" and "admin" user type to have different access rights over data within the application from the back-end database. |  |  |  | ✓ | ✓ | ✓ | ✓
| The application incorporates some AJAX features such as a username availability checker. |  |  |  | ✓ | ✓ | ✓ | ✓
| Responsive design allows for the application to transform allowing both desktop and mobile browsing with a modern user interface free from usability flaws. |  |  |  |  | ✓ | ✓ |
| Multiple instances of AJAX techniques have been incorporated, or the application follows a backend API with separate front-end architecture. |  |  |  |  | ✓ | ✓ |
| Appropriate back-end privileges have been set up e.g. the application must NOT connect to the MySQL database using the root user with unlimited privilege. |  |  |  |  | ✓ | ✓ | ✓
| A well considered user hierarchy has been incorporated into the application including the facility for administrators to manage other user accounts. |  |  |  |  |  | ✓ |
| The application must have no major security flaws. Vulnerabilities ranging beyond just SQL injection have been addressed. |  |  |  |  |  | ✓ |
| You have undertaken significant independent learning and used tools, and or techniques beyond what was given to you throughout the labs and lectures this year. |  |  |  |  |  | ✓ |
 
## Assessment Response: Explanations & Justifications
This section will be completed as decisions are made throughout development.
 
## References & Bibliography