<?php

// Unzip for Symbiose WebOS
// Coded by TiBounise (http://tibounise.com)
// Released as GPL v3 software

if (!$this->arguments->isParam(0)) {
  throw new InvalidArgumentException('Aucun fichier fourni');
}

$FileManager = $this->webos->managers()->get('File');

if (!$FileManager->exists($this->terminal->getAbsoluteLocation($this->arguments->getParam(0)))) {
  throw new InvalidArgumentException('Le fichier n\'existe pas !');
}

// Vérifier l'extension
if (!preg_match('#\.zip$#',$this->arguments->getParam(0))) {
  throw new InvalidArgumentException('Le fichier fourni ne semble pas être au format .zip');
}

// Générer les vrais chemins du fichier zip et du dossier parent
$FilePath = $FileManager->get($this->terminal->getAbsoluteLocation($this->arguments->getParam(0)))->realpath();
$FolderPath = preg_replace('#'.end(explode("/",$FilePath)).'$#','',$FilePath);

// Compter le temps à l'init
$startTime = mktime();

// Décompresser le zip
$zip = new ZipArchive;
$zipHandler = $zip->open($FilePath);
if ($zipHandler === TRUE) {
  $zip->extractTo($FolderPath);
  $zip->close();
  echo end(explode("/",$FilePath)).' a été décompressé en '.(mktime() - $startTime).' secondes.';
} else {
  throw new InvalidArgumentException('L\'archive n\'a pu s\'extraire');
}