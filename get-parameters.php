<?php
  # Retrieve settings from Parameter Store
  error_log('Retrieving settings');
  require 'vendor/autoload.php'; 

  use Aws\SecretsManager\SecretsManagerClient;
  use Aws\Exception\AwsException;
  // require 'aws.phar';
  
  $az = file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
  // $region = substr($az, 0, -1);
  $region = 'ap-southeast-1';
  // Create Secrets Manager client
  $client = new SecretsManagerClient([
      'version' => 'latest',
      'region'  => $region
  ]);

  try {
    // Retrieve the secret value
      $result = $client->getSecretValue([
          'SecretId' => 'MSRI/CSVC/RDS/MySql'
      ]);

      if (isset($result['SecretString'])) {
          $secret = json_decode($result['SecretString'], true);

          // Assign secret values
          $ep = $secret['endpoint'] ?? '';
          $un = $secret['username'] ?? '';
          $pw = $secret['password'] ?? '';
          $db = $secret['database'] ?? '';
      } else {
          throw new Exception("SecretString not found");
      }
  }
  catch (AwsException $e) {
    $ep = '';
    $db = '';
    $un = '';
    $pw = '';
  }

?>