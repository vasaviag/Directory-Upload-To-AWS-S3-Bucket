<?php
	
require 'vendor/autoload.php';
use Aws\S3\Transfer;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


$bucketName = 'Bucket-Name-Of-Your-Choice'; //Bucket name should be unique
$IAM_KEY = 'Your-IAM-Key'; //Enter Your IAM key here
$IAM_SECRET = 'Your-IAM-Secret-Key'; //Enter Your IAM Secret Key
$source = 'Directory-To-Upload'; //Enter the Directory you want to Upload
$dest = 'Enter-The-Path-You-Want-To-Upload-The-Directory-To-In-Bucket'; //Eg. - s3://Your-Bucket-Name/Path/to/folder/In/S3/Bucket
$region = 'Enter-the-region-of-your-S3-Bucket'; //Eg. - 'us-east-2'	

try {
	$s3 = S3Client::factory(
		array(
			'credentials' => array(
				'key' => $IAM_KEY,
				'secret' => $IAM_SECRET
			),
			'version' => 'latest',
			'region'  => $region
		)
	);
} 
catch (Exception $e) 
{
	die("Error: " . $e->getMessage());
}


$options[] = [
	'DEBUG' => true,
];

$manager = (new Transfer($s3, $source, $dest , $options));

$promise = $manager->promise();
$promise->then(function () {
	echo 'Done!';
});

$manager->transfer();

?>