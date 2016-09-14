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
$USERNAME = $argv[1];
$TEAMNAME = $argv[2];
$LIMITAPP = $argv[3];
$MYPASSAP = $argv[4];
$GITHUBAPP = "api.bitbucket.org";
$LIMITPGS = "2";

# generate file
#$txtFile = "listprojects_".date("YmdHis").".txt";
$txtFile = "listprojects.txt";
$fp = fopen($txtFile, "w");
fwrite($fp, "");

for ($iPg = 1; $iPg <= $LIMITPGS; $iPg++) {

	$URL = " -u {$USERNAME}:$MYPASSAP https://{$GITHUBAPP}/2.0/repositories/{$TEAMNAME}\?pagelen\={$LIMITAPP}\&page\=" . $iPg;
// curl -s  -u username:passwd https://api.bitbucket.org/2.0/repositories/teamname\?pagelen\=10&&page=2

# run curl in shell
	echo $cmd = "curl -s {$URL}";
	$resJson = shell_exec($cmd);
	$resArGit = (array)json_decode($resJson, true);
//print "<pre>"; print_r($resArGit); die();

	$fp = fopen($txtFile, "a");
	foreach ($resArGit["values"] as $repoGit) {
		// https://username@bitbucket.org/username/emulaterepo.git.
		$cloneUrl = $repoGit['links']['clone'][0]['href'];
		$cloneUrl = str_replace("@bitbucket.org", ":" . $MYPASSAP . "@bitbucket.org", $cloneUrl);    // add pass in repo url
		fwrite($fp, $cloneUrl . "\n");
	}

}

/*
x[links][clone][0][href] // https
x[links][clone][1][href] // ssh
 */
