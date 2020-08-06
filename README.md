# Clients Api

Please find how to launch the application and the structure of the API bellow.



## Application launching

	1) cp .env.example .env
	2) create database and update credentials in .env file
	3) composer install
	4) php artisan migrate 
	5) php artisan jwt:secret
	6) php artisan serve
	
	

## Api structure

- URL  
	- /api/search-client/
- HTTP Method  
	- GET
- Operation  
	- Search the client
- Api Call Example  
	- api/search-client?name=name&lastname=lastname&email=name@gmail.com&phone=123456

##

- URL  
	- /api/clients/:client
- HTTP Method  
	- GET
- Operation  
	- Select client
- Api Call Example  
	- api/client/1
	
##	
	
- URL  
	- api/clients
- HTTP Method  
	- POST
- Operation  
	- Create geoObject 
- Api Call Example 
	- api/clients	
- Request Body
    ```
    "name" 
    "lastname"
    "emails": [] 
    "phone_numbers": []
## 	   

- URL  
	- api/clients/:client
- HTTP Method  
	- PUT
- Operation  
	- Update given client
- Api Call Example 
	- api/clients/1
- Request Body	
	```
  "name"
  "lastname"
  "emails": [] 
  "phone_numbers": []
##

- URL  
	- api/clients/:client
- HTTP Method  
	- DELETE
- Operation  
	- Delete given client 
- Api Call Example 
	- api/clients/1	
