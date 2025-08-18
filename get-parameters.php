<?php
  # Retrieve settings from Parameter Store
  error_log('Retrieving settings');
  require 'vendor/autoload.php'; 

  use Aws\SecretsManager\SecretsManagerClient;
  use Aws\Exception\AwsException;
  // require 'aws.phar';
  
  $az = file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
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

          $dsn = "mysql:host={$ep};dbname={$db};charset=utf8mb4";
          $pdo = new PDO($dsn, $un, $pw, [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          ]);

          error_log("Database connection successful");

      } else {
          throw new Exception("SecretString not found");
      }
  } catch (AwsException $e) {
    error_log("Error retrieving secret: " . $e->getMessage());
    $ep = '';
    $db = '';
    $un = '';
    $pw = '';
  } catch (PDOException $e) {
      error_log("Database connection failed: " . $e->getMessage());
      $pdo = null;
  }

?>