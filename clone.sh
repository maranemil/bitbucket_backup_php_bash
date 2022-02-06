#!/bin/bash

# -----------------------------------
# set user name from git
# -----------------------------------
TEAM_GIT="your_team_name" 	# your team name
USER_GIT="your_git_user" 	# your git username
LIMIT="100"				# how many repos you want to read
MY_PASS="your_passwd"	# your pass

# -----------------------------------
# get list of projects
# -----------------------------------
php -f get_git_list.php -- $USER_GIT $TEAM_GIT $LIMIT $MY_PASS

# -----------------------------------
# clone projects
# -----------------------------------
# shellcheck disable=SC2162
while read F  ; do
      echo "$F"
		git clone "$F"
done < listprojects.txt

# -----------------------------------
# make zip of git projects
# -----------------------------------
for i in */; do zip -r "${i%/}.zip" "$i"; done
