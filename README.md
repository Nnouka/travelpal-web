# Jason Web Token Authorization Server

## Register your client app

 Uri: POST
  
     'api/public/client/register'
     
 Sample Request:
 
    {
       "clientId": "My App 2",
       "clientSecret": "12345678",
        "webServerRedirectUri": "www.mungwin.com"
    }
    
 Expected Request Header: 
 
    None
    
 Expected Success Response:
 
    {
        "client_id": "My App 3",
        "access_token_validity": 3600,
        "refresh_token_validity": 864000,
        "web_server_redirect_uri": "www.mungwin.com",
        "app_key": "igZh5kKbH6YKAYdzqjmb3iL6qvkHkg4i",
        "id": 3
    }
 
 The appKey, access_token_validity and refresh_token_validity
 are the defaults. You can choose to set them to suit your needs
 
## See default client details
Uri: GET

    'api/protected/client/details

Expected Request Header:

    Name: X-Api-Auth
    Type: Basic Auth "password grant_type"
    Value: Basic base_64UrlEncode(<client_id>:<client_secret>)
Note: 

    This Header is requested for all subsequent client/protected endpoints

## Generate a new App Key
 Uri: POST
 
    'api/protected/client/app_key'
    
 Expected Request Header
 
    Name: X-Api-Auth
    Type: Basic Auth "password grant_type"
    Value: Basic base_64UrlEncode(<client_id>:<client_secret>)
    
 Note: 
    
    This Header is requested for all subsequent client/protected endpoints

## Update "web_server_redirect_uri"
Uri: POST
 
    'api/protected/client/web_server_redirect_uri'
    
Sample Request:
 
    {
        "webServerRedirectUri": "www.mungwincore.com"
    }
      
Expected Success Response:
 
    {
        "client_id": "My App 3",
        "access_token_validity": 3600,
        "refresh_token_validity": 864000,
        "web_server_redirect_uri": "www.mungwincore.com",
        "app_key": "igZh5kKbH6YKAYdzqjmb3iL6qvkHkg4i",
        "id": 3
    } 

## Update "access_token_validity"
Uri: POST
 
    'api/protected/client/access_token_validity'
    
Sample Request: validity value is in seconds
 
    {
        "access_token_validity": 1800
    }
      
Expected Success Response:
 
    {
        "client_id": "My App 3",
        "access_token_validity": 1800,
        "refresh_token_validity": 864000,
        "web_server_redirect_uri": "www.mungwincore.com",
        "app_key": "igZh5kKbH6YKAYdzqjmb3iL6qvkHkg4i",
        "id": 3
    } 
    
## Update "refresh_token_validity"
Uri: POST
 
    'api/protected/client/refresh_token_validity'
    
Sample Request: validity value is in seconds
 
    {
        "refresh_token_validity": 432000
    }
      
Expected Success Response:
 
    {
        "client_id": "My App 3",
        "access_token_validity": 1800,
        "refresh_token_validity": 43200,
        "web_server_redirect_uri": "www.mungwincore.com",
        "app_key": "igZh5kKbH6YKAYdzqjmb3iL6qvkHkg4i",
        "id": 3
    } 
        
## Update client details in one go 
Uri: POST
 
    'api/protected/client/details/update'
    
Sample Request: validity value is in seconds
 
      {
        "access_token_validity": 2400,
        "refresh_token_validity": 83200,
        "web_server_redirect_uri": "www.mungwinstore.com"
       } 
      
Expected Success Response:
 
    {
        "client_id": "My App 3",
        "access_token_validity": 1800,
        "refresh_token_validity": 43200,
        "web_server_redirect_uri": "www.mungwinstore.com",
        "app_key": "igZh5kKbH6YKAYdzqjmb3iL6qvkHkg4i",
        "id": 3
    } 
## Not Advisable to Delete App

## Use App Key to sign our tokens

## [Live sample server](https://mg-jwtauthserver.herokuapp.com)
