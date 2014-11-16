<?php

// Only permit this script to be run from CLI
if (php_sapi_name() != "cli")
	die();

// Fetch the contents of the JSON file
$json = json_decode(file_get_contents(__DIR__.'/index.json'), true);

// Iterate through the JSON file as a key=>object pair
foreach ($json as $key=>$obj)
{
	// Set some variables
	$version = $obj['version'];
	$repository = $obj['repository'];
	$archive = array();
	$cardDir = __DIR__.'/'.$key.'/'.$version;

	// Make the necessary base directory
	if (!file_exists(__DIR__.'/'.$key))
		mkdir(__DIR__.'/'.$key);

	// Make the subdirectory
	if (!file_exists($cardDir))
		mkdir($cardDir);
	else
	{
		// If this is a dev branch, wipe the current folder and start again, otherwise ignore it
		if ((substr($version, 0, 4)) == "dev-")
		{
			$files = glob($cardDir.'/*');
			foreach ($files as $file)
			{
				if (is_file($file))
					unlink($file);
			}
		}
		else
			continue;
	}

	// Download the zip archive of either the branch of tag
	if ((substr($version, 0, 4)) == "dev-")
	{
		$branch = str_replace('dev-', '', $version);
		$archive = downloadArchive($branch, $repository);
	}
	else
		$archive = downloadArchive($version, $repository);

	// If a download error occured, continue with the next card
	if ($archive['error'] != "")
		continue;

	// Write the zip file to disk
	file_put_contents($cardDir.'.zip', $archive['archive']);

	// Extract the zip file
	$zip = new ZipArchive;
	if ($zip->open($cardDir.'.zip') === TRUE)
	{
		$folder = NULL;
		for($i = 0; $i < $zip->numFiles; $i++)
		{
        	$filename = $zip->getNameIndex($i);
       		$fileinfo = pathinfo($filename);
       		$data = explode('/', $filename);
       		$folder = $data[0];
       		// Write just the file to disk
        	copy("zip://".$cardDir.".zip#".$filename, $cardDir.'/'.$fileinfo['basename']);
    	}  

    	$zip->close();

    	// Remove the ZIP file, and the parent folder github makes
    	unlink($cardDir.'/'.$folder);
    	unlink($cardDir.'.zip');
	}
	else
		continue;
}

/**
 * Utility method to download the github zip archive
 * @param  string $version    The branch/tag version to download
 * @param  url $repository    The repository url
 * @return array
 */
function downloadArchive($version, $repository)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $repository.'/archive/'.$version.'.zip');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$data = curl_exec($ch);
	$error = curl_error($ch); 
	curl_close($ch);

	return array(
		'error' => $error,
		'archive' => $data
	);
}