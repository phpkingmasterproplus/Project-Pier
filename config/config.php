<?php
  # --- Database Configuration ---
  $services_json = json_decode(getenv("VCAP_SERVICES"),true);
  if ($services_json == "") {
      $LOCAL_MYSQL = '{"mysql-5.1":[
          {
              "credentials":{
                  "name":"pier",
                  "hostname":"localhost",
                  "username":"root",
                  "password":"654321"
              }
          }
      ]}';
      $services_json = json_decode($LOCAL_MYSQL, true);
  }
  $mysql_config = $services_json["mysql-5.1"][0]["credentials"];

  $db_adapter    = 'mysql';
  $db_hostname   = $mysql_config["hostname"];
  $db_username   = $mysql_config["username"];
  $db_password   = $mysql_config["password"];
  $database_name = $mysql_config["name"];

  define('DB_ADAPTER', $db_adapter);
  define('DB_HOST',    $db_hostname);
  define('DB_USER',    $db_username);
  define('DB_PASS',    $db_password);
  define('DB_NAME',    $database_name);

  define('DB_PREFIX', 'pp_');
  define('DB_CHARSET', 'utf8');
  define('DB_PERSIST', false);
  return true;
?>