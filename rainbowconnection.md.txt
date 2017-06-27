# Description
Build a web site to find and manage connections between a large number of users.
A user is a person with a first and last name, a favorite color, and any number of connections to other users.  Connections are always mutual (ie bi-directional).

## Requirements
1. Site should only use ajax beyond initial index page load
2. All endpoints should follow REST protocol
3. Site should be developed using Laravel PHP and Ember.js
4. Domain should be "www.rainbowconnection.com".  In osx/linux you can edit your /etc/hosts file to point this domain to your local instance (recommend homestead or laradock).
5. All lists should be displayed using "infinite pagination".  Any list with more than 25 results should be paginated in this way.  Upon scrolling down, an additional 25 results should load at a time.
6. Color options include all primary, secondary & tertiary colors
7. Anywhere a user's favorite color appears, the text should be colored corresponding to the value.
8. Code should be well documented with appropriate comments.
9. Please include a top-level README.md explaining your major architectural decisions.  Most important requirement is shipping on time, so if you have to make feature cuts or take shortcuts in order to finish, please explain what trade-offs you made and why you chose them.

## Initial View (www.rainbowconnection.com)
* Displays a list of all users with three columns: [full name], [favorite color], [comma-separated list of full names of all connections]
* Favorite color text should be colored with the relevant color
* User's full name, and each connection name should be clickable.  Clicking should take you to User View page.

## User View (www.rainbowconnection.com/[userid])
* Displays a title with this user's full name and favorite color
* Displays a list of all user's connections with three columns: [full name], [favorite color], [remove button]
* Clicking a list item's remove button should remove that connection and update the current view.
* Clicking on the favorite color of the current user in the title bar should give a drop-down selection of colors.  Selecting a new color should update the current user's color.

## Test Endpoint (POST www.rainbowconnection.com/testdata)
* PARAMS: userCount - Integer between 1 and 1000000
* This endpoint should clear the database, and populate it with a set of [userCount] users with randomly generated, human first and last names.
* Each user should have between 0 and 50 randomly generated connections.
* Each user should have a randomly generated favorite color.
