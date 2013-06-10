<?php

class subscribepageexample extends phplistPlugin {
  public $name = "Subscribe page example plugin for phpList";
  public $coderoot = '';
  public $version = "0.1";
  public $authors = 'Michiel Dethmers';
  public $enabled = 1;
  public $description = 'Shows how to add and validate field in the subscribe page';

  function __construct() {
    parent::phplistplugin();
  }

  function adminmenu() {
    return array(
    );
  }
  
  function upgrade($previous) {
    parent::upgrade($previous);
    return true;
  }
  
  function displaySubscribepageEdit($data) {
    
    $myFieldValue = $data['myField'];
    
    return s('Please enter a value').': <input type="text" name="myField" value="'.htmlspecialchars($myFieldValue).'" />';
    
  }

  function processSubscribePageEdit($id) {
    
    $myValue = $_POST['myField'];
    $myValue = preg_replace('/[^\w -]+/','',$myValue);
    
    Sql_Query(sprintf('replace into %s (id,name,data) values(%d,"myField","%s")',
       $GLOBALS['tables']["subscribepage_data"],$id,sql_escape($myValue)));
  }

  
  function displaySubscriptionChoice($pageData, $userID = 0) {
    if ($pageData['myField'] == 'check') {
      return s('Please do not enter anything in this field').' '.'<input type="text" name="myValidationCheck" value="" />';
    } else {
      return '<!-- nothing to do -->';
    }
  }
 
  function validateSubscriptionPage($pageData) {
    if ($pageData['myField'] == 'check') {
      if (!empty($_POST['myValidationCheck'])) {
        return s('Sorry, you did enter something, we requested not to do so');
      }
    }
    return '';
  }
 

}
