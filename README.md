INSTALLATION
1. apply schema from ./data directory

2. Turn on module in ./config/application.config.php file. 
   (IMPORTANT: Please remember to disable any other register-specific
   module like CdliTwoStageSignup)

3.  Configure zfcuser module in YOUR_PROJECT_DIRECTORY/config/autoload/zfcuser.global.php
  - 'user_entity_class' => 'CrunchySignup\Entity\User' 
  - 'login_after_registration' => false,
  - 'enable_user_state' => true,
  - 'default_user_state' => null,
  - 'allowed_login_states' => array( 1 ),

4. Copy CrunchySignup/config/crunchysignup.global.php.dist to ./config/autoload/crunchysignup.global.php 


------------
HOW TO ... :

1. How to override built in view scripts ?
In your module, under the view directory, create the folder tree crunchy-signup/register.
Create the necessary override view scripts, depending on which page(s) you want to change:
e.g.: crunchy-signup/register/register.phtml

Refer to each built-in view script to see how the form is configured and rendered.
NOTE: Your module must be loaded after CrunchySignup or the overriding will not work. 