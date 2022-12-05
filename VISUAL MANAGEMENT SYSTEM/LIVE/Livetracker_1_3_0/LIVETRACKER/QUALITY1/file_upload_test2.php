<?php
 require './vendor/autoload.php';

 use Office365\SharePoint\ClientContext;
 use Office365\Runtime\Auth\ClientCredential;
 
 $credentials = new ClientCredential("{cnixon@kentstainless.com}", "{CNks2022??}");
 $client = (new ClientContext("https://kentstainlesswex.sharepoint.com/"))->withCredentials($credentials);
 
 $list = $client->getWeb()->getLists()->getByTitle("Tasks");
 $listItem = $list->getItemById("{item-id-to-update}");
 $listItem->setProperty('PercentComplete',1);
 $listItem->update();
 $client->executeQuery();