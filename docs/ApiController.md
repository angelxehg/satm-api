# API Controller

This is an standard controller that implements some extra methods in the Controller class.

## Method isLogged()

This method checks if the user has logged in.

- Returns *User*.
- Throws exception (if not logged in).

## Method isAdmin()

If the user has logged in, this method checks if this user is an admin.

- Returns *User*.
- Throws exception (if not admin or logged in).
