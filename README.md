## Taurus Framework ##

# Paging #
Paging works out of the box on every API configured through the Taurus Web Service System and Router.
It's configured in the config.yml in the app directory usually called yourapp.config.yml. There are 3 important configs you need
to set/know to use it. 

| Config Name | Description | Default |
| ------ | ------ | ------ |
|default_page_size|Sets the number of elements returned for a page. The number can be changed dynamically per request by setting the page_size_param_name in the request | 20 |
| page_size_param_name |This is the name of the request parameter that can be used to overwrite the default page size in a specific request | pageSize |
| page_param_name | This is the request parameter you need to use to request a certain page | page |

# Authentication #
Authentication is build into Taurus. The following steps have to be done to configure it: 

* Configure Authentication in config.yaml
    * Set auth_enabled to true
    * Define a password encryption algorithm default HS256
    * Define how the token that will secure the APIs is exchanged (header or cookie)
    * Define the name of the token in header or cookie
    * Define on a secret to encrypt passwords, when stored
* Create an Entity usually User that has the username and password data
    * The entity requires a PasswordHash annotation on the property that will hold the password
    * The PasswordHash annotation will make sure that the password is encrypted, when a new user is created
    * The entity has to extend AuthenticationResource
* Create an Authentication Specification, which is used to load the user data, when login is attempted
    * The specification would usually have a single field username, but any combination can be used
    * The specification will be used to build the query that will load the user from the database, *before the password is validated using password_hash!*
    * If the specification returns more then one user, authentication will fail with 401 Response
* Configure Authentication in config.yaml
    * Set auth_enabled to true
    * Define a password encryption algorithm default HS256
    * Define how the token that will secure the APIs is exchanged (header or cookie)
    * Define the name of the token in header or cookie
    * Define on a secret to encrypt passwords, when stored
    * Configure the user entity you defined earlier
    * Configure the user specification you defined earlier
    * Configure the authentication url (*make sure that url is not listed in the public resources in the config.yaml*)
* Create an authentication route in the Routing Config using the buildAuthenticationRoute method of the Route builder
    * It is important that the login url in the config.yaml is exactly matching the url in the routing config including leading slashes

Once all that is done, all resources are protected apart from those in the public resource array in the config and the login url. The channels are secured with a JWT token. 

# Filtering #
Taurus allows to easily configure filters on APIs by writing a *Specification*. A specification is a class that defines the fields by which can be filtered. The actual filtering happens by passing a paramter filter that is an array of field=filter pairs. 

/api/user?filter[name]=test

## How to Build a Specification ##
tbd.
