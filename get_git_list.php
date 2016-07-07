<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 07.07.16
 * Time: 16:37
 */

ini_set('error_reporting', 0);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

# Substitute variables here if needed
$USERNAME = $argv[1];
$TEAMNAME = $argv[2];
$LIMITAPP = $argv[3];
$MYPASSAP = $argv[4];
$GITHUBAPP = "api.bitbucket.org";


$URL = " -u {$USERNAME}:$MYPASSAP https://{$GITHUBAPP}/2.0/repositories/{$TEAMNAME}\?pagelen\={$LIMITAPP}";
// curl -s  -u username:passwd https://api.bitbucket.org/2.0/repositories/teamname\?pagelen\=10

# run curl in shell
echo $cmd = "curl -s {$URL}";
$resJson = shell_exec($cmd);
$resArGit = (array) json_decode($resJson,true);
//print "<pre>"; print_r($resArGit); die();

# generate file
//$fp = fopen("listprojects".date("YmdHis").".txt","w");
$fp = fopen("listprojects.txt","w");
fwrite($fp, "");

$fp = fopen("listprojects.txt","a");
foreach($resArGit["values"] as $repoGit){
	// https://username@bitbucket.org/username/emulaterepo.git.
	$cloneUrl = $repoGit['links']['clone'][0]['href'];
	$cloneUrl = str_replace("@bitbucket.org", ":".$MYPASSAP."@bitbucket.org", $cloneUrl);	// add pass in repo url
	fwrite($fp, $cloneUrl."\n");
}

/*
x[links][clone][0][href] // https
x[links][clone][1][href] // ssh
 */
