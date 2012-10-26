<?php

// Unzip for Symbiose WebOS
// Coded by TiBounise (http://tibounise.com)
// Released as GPL v3 software

if (!$this->arguments->isParam(0))
  throw new InvalidArgumentException('Aucun fichier fourni');

$FileManager = $this->webos->managers()->get('File');
$AbsoluteLocation = $this->terminal->getAbsoluteLocation($this->arguments->getParam(0));

if (!$FileManager->exists($AbsoluteLocation))
  throw new InvalidArgumentException('Le fichier n\'existe pas !');

// Check the extension
if (!preg_match('#\.zip$#',$AbsoluteLocation))
  throw new InvalidArgumentException('Le fichier fourni ne semble pas être au format .zip');

// Generate the real paths
$FilePath = $FileManager->get($AbsoluteLocation)->realpath();
$ZipFilename = end(explode("/",$FilePath));
$FolderPath = preg_replace('#'.$ZipFilename.'$#','',$FilePath);

// Stores the times at the beginning of the script
$startTime = mktime();

// Unzip :P
$ZipHandler = new ZipArchive;
$zip = $zip->open($FilePath);
if ($zip === TRUE) {
  $ZipHandler->extractTo($FolderPath);
  $ZipHandler->close();
  echo $ZipFilename.' a été décompressé en '.(mktime() - $startTime).' secondes.';
} else {
  throw new InvalidArgumentException('L\'archive n\'a pu s\'extraire');
}