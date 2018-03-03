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
