# E-commerce-inventory-
use html php css js with ajax mysql 
write a web based sol to help a customer find desired producrs on an e commerce web, purchase some in a cart and checkout  
the website maintains its products in the followin format in rdbms 
1
product id 
product name 
desc 
unit price
imagecode  (image id )

2-
product id , quantity available  

3 optional 
image id , image 

the end user visits the site and sees all items listed in a grid format 
the end user is presented qwith a search bar which is dynamically searchable as the user types charachters 
the end user selecrs items and adds them to a cart 
when the end user presses checkout then the items get deducted from the db 
there should be a link on the homepage to add items to the inventory , on clicking this link page is displayed that enlists the table 1 join with table 2 
it also shows a form row to add entries to the db table and on adding an entry , the page dynamically updates itself using ajax 
you do not have to implement payment , but only a notional checkout that deducts the items from the db , not need for log in 
overall there are foll parts of your code
1-db table creation , entering data in db , correct queries 
2- implementing search page 
3- implementing checkout 
4- implementing inventory management 
