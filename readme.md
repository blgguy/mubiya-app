### END -POINT

## Aminu M. BUlangu

# post Request
* Create a new User
anything inside {} is the users field. oin development you have to remove {}.
http://mukoya.educationhost.cloud/create/index.php?name={smaple}&email={sample@gmail.com}&password={234}


# get Request
* View All Users that registered

http://mukoya.educationhost.cloud/view/
* View Users by ID.

http://mukoya.educationhost.cloud/view/index.php?id={1}

* Login User
/api/auth/{email}/{password}


* All Users logs details
/api/users/logs/{email}/{password}
