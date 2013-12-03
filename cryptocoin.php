<?php 
/* For documentation, please visit http://code.google.com/p/cryptocoin */ 
/* THIS FREEWARE IS UNDER THE MIT SOFTWARE LICENSE */
/* Creator: Gio Panaro */
/*
Please help support the cryptocoin project by donating.
Bitcoin: 15vv2L5Yy95F3qiXGMXGEEgDYSZ6PWRfLT
Litecoin: LQ1gFiVZpXDCtKV8FCAp8AzuoxdRGeYLx7
*/
require_once 'jsonrpcphp/includes/jsonRPCClient.php'; 
include 'inc.php';
function offserver($currency) //turns off server for given cryptocurrency - cryptocoin.php will not work until manually tuned back on.
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    $bitcoin->stop();
    return true; 
  } 
} 
function settransactionfee($amount,$currency) //sets transaction fee
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    $bitcoin->settxfee($amount);
    return true; 
  } 
} 
function backup($filepath,$currency) //backups wallet to wallet.dat 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    $bitcoin->backupwallet($filepath);
    return true; 
  } 
} 
function getbalance($account,$currency) //This function will return the balance of a given cryptocurrency account or a wallet. If the value of account is null, wallet balance will be returned.
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    if($account==null) 
    { 
      return $bitcoin->getbalance(); 
    } 
    return $bitcoin->getbalance($account); 
  } 
} 
function getaddressfromaccount($account,$currency) //returns given cryptocurrency address from given account name 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    return $bitcoin->getaccountaddress($account); 
  } 
} 
function getaccountfromaddress($address,$currency) //returns given cryptocurrency account from given address (local only) 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    return $bitcoin->getaccount($address); 
  } 
} 
function getinfo($currency) //gets info on rpc server 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    return $bitcoin->getinfo(); 
  } 
} 
function listaccounts($currency) //lists accounts 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    return $bitcoin->listaccounts(); 
  } 
}
function accountgen($name,$override,$currency) //generates given cryptocurrency account
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    if($name==null) 
    { 
      return false; 
    }
 if($override=true)
 {
      return $bitcoin->getnewaddress($name); //returns given cryptocurrency address
 }
 $accounts=listaccounts($currency);
 if(!isset($accounts[$name]))
 {
   return $bitcoin->getnewaddress($name); //returns given cryptocurrency address
 }
 return false;
  } 
}
function valtrans($a,$f,$c) //Validates the amount of given cryptocurrency being sent from one account to another account or address without generating errors.
{ 
  if($c=="btc") 
  { 
    global $bitcoin;
    $comp=trim($bitcoin->getbalance($f)); 
    if($comp>$a) 
    { 
      $a=$comp; 
    } 
 return $a;
  }  
} 
function movecoins($from,$to,$amount,$currency) //moves coins from one local account to another using the account name (returns true of false) 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
 $amount=valtrans($amount,$from,$currency);
    $accounts=listaccounts($currency);
    if(isset($accounts[$to]))
 {
   $bitcoin->move($from,$to,$amount);
   return true;
    } 
    else 
    { 
      return false; 
    } 
  } 
} 
function validate($address,$currency) //checks to see if given cryptocurrency address is valid (returns true or false) 
{ 
  if($currency=="btc") 
  { 
    global $bitcoin; 
    $a=$bitcoin->validateaddress($address); 
    if($a['isvalid']=="true") 
    { 
      return true; 
    } 
    else 
    { 
      return false; 
    } 
  } 
}
function sendbtc($from,$to,$amount,$currency) //Sends given cryptocurrency to another address (non-exclusively foreign)
{
  if($currency=="btc")
  {
    global $bitcoin;
 $va=validate($to,$currency);
 if($va==false)
 {
   return false;
 }
 $amount=valtrans($amount,$from,$currency);
 $bitcoin->sendfrom($from,$to,$amount);
 return true;
  }
}
?>