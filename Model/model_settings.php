<?php

/** @var User $profUser */
$profUser = $_SESSION["User"];
$name = $profUser->getName();
$email = $profUser->getEmail();
$telefon = $profUser->getTelefon();


$clubMember = $DBTasks->isUserClubMember($profUser->getId());
$clubleader = $profUser->isClubLeader();
$fedLeader = $profUser->isFederationLeader();