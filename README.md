## CrunchySignup
Version 0.0.1 Created by Patrick Sagan ([zf2dev.com](http://zf2dev.com))


## INTRODUCTION
CrunchySignup is a user registration module for Zend Framework 2 which provides
**email verification functionality during registration process**. It extends [ZfcUser](https://github.com/ZF-Commons/ZfcUser)
module. It adds extra columns to user table like: created_at, updated_at, token, token_created_at.


## REQUIREMENTS
* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)
* [ZfcBase](https://github.com/ZF-Commons/ZfcBase) (latest master)
* [ZfcUser](https://github.com/ZF-Commons/ZfcUser) (latest master)



## INSTALLATION
##### WITH COMPOSER (RECOMMENDED)
1. Add this project, ZfcUser and ZfcBase in your composer.json:

    ```json
    "require": {
        "zf-commons/zfc-base": "dev-master",
        "zf-commons/zfc-user": "dev-master",
        "crunchy/crunchy-signup": "dev-master"
    }
    ```
2.  Tell Composer to download CrunchySignup:

    ```bash
    $ php composer.phar update
    ``` 

    
##### … OR BY CLONING PROJECT
* Install the ZfcBase ZF2 module by cloning it into ./vendor/.
* Install the ZfcUser ZF2 module by cloning it into ./vendor/.
* Clone this project into your ./vendor/ directory.


## POST INSTALLATION

1. apply schema from ./vendor/crunchy/crunchy-signup/data/schema_up.sql

2. Turn on module in ./config/application.config.php file - add 'CrunchySignup'.
   Please ensure that CrunchySignup is added after ZfcBase and ZfcUser.

    ```php
        'modules' => array(
            'ZfcBase',
            'ZfcUser',
            'CrunchySignup'
        )
    
    ```

3. Configure zfcuser module in ./config/autoload/zfcuser.global.php  
  * 'user_entity_class' => 'CrunchySignup\Entity\User' 
  * 'login_after_registration' => false,
  * 'enable_user_state' => true,
  * 'default_user_state' => null,
  * 'allowed_login_states' => array( 1 )



4. Copy CrunchySignup/config/crunchysignup.global.php.dist to ./config/autoload/crunchysignup.global.php 


## FUTURE UPGRADES (TO-DO)
* Do it more configurable **(important)**
* Add Doctrine Adapter
* Add other mail transports


## KNOW HOW :

###  How to override built in view scripts ?

* In your module, under the view directory, create the folder tree crunchy-signup/register.
* Create the necessary override view scripts, depending on which page(s) you want to change:
e.g.: crunchy-signup/register/register.phtml
* Refer to each built-in view script to see how the form is configured and rendered.
NOTE: Your module must be loaded after CrunchySignup or the overriding will not work. 


