#!/bin/bash

# -----------------------------------
# set user name from git
# -----------------------------------
TEAMN="your_team_name" 	# your team name
USERN="your_git_user" 	# your git username
LIMIT="100"				# how many repos you want to read
MYPASS="your_passwd"	# your pass

# -----------------------------------
# get list of projects
# -----------------------------------
php -f get_git_list.php -- $USERN $TEAMN $LIMIT $MYPASS

# -----------------------------------
# clone projects
# -----------------------------------
while read F  ; do
      echo $F
		git clone $F
done < listprojects.txt

# -----------------------------------
# make zip of git projects
# -----------------------------------
for i in */; do zip -r "${i%/}.zip" "$i"; done
