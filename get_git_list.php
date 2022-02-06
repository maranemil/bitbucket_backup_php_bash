<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 14.09.16
 * Time: 14:37
 */

ini_set('error_reporting', 'E_ERROR');
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

# Substitute variables here if needed
list($USER_NAME,$TEAM_NAME,$LIMIT_APP,$MY_PASS_AP) = [$argv[1],$argv[2],$argv[3],$argv[4]];
//$USER_NAME = $argv[1];
//$TEAM_NAME = $argv[2];
//$LIMIT_APP = $argv[3];
//$MY_PASS_AP = $argv[4];
$GITHUB_API = "api.bitbucket.org";
$LIMIT_PGS = "2";

/**
 * generate file
 */
#$txtFile = "listprojects_".date("YmdHis").".txt";
$txtFile = "list_projects.txt";
$fp = fopen($txtFile, 'wb');
fwrite($fp, "");

for ($iPg = 1; $iPg <= $LIMIT_PGS; $iPg++) {
    $URL = " -u $USER_NAME:$MY_PASS_AP https://$GITHUB_API/2.0/repositories/$TEAM_NAME\?pagelen\=$LIMIT_APP\&page\=" . $iPg;
    // curl -s  -u username:passwd https://api.bitbucket.org/2.0/repositories/teamname\?pagelen\=10&&page=2

    # run curl in shell
    echo $cmd = "curl -s $URL";
    $resJson = shell_exec($cmd);
    $resArGit = (array)json_decode($resJson, true);

    $fp = fopen($txtFile, 'ab');
    foreach ($resArGit["values"] as $repoGit) {
        // https://username@bitbucket.org/username/emulaterepo.git.
        $cloneUrl = $repoGit['links']['clone'][0]['href'];
        $cloneUrl = str_replace("@bitbucket.org", ":" . $MY_PASS_AP . "@bitbucket.org", $cloneUrl);    // add pass in repo url
        fwrite($fp, $cloneUrl . "\n");
    }
}

/*
x[links][clone][0][href] // https
x[links][clone][1][href] // ssh
*/
